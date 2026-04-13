<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\StokLog;
use App\Models\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\StockLogExport;
use Illuminate\Support\Facades\Auth;

class StockController extends Controller
{
    public function index()
    {
        $products = Product::with('category')->latest()->get();
        $lowStock = Product::where('stok', '<', 10)->where('stok', '>', 0)->count();
        $outOfStock = Product::where('stok', '<=', 0)->count();
        $totalStock = Product::sum('stok');
        $totalValue = Product::select(DB::raw('SUM(harga * stok) as total'))->first()->total;
        
        return view('admin.stock.index', compact('products', 'lowStock', 'outOfStock', 'totalStock', 'totalValue'));
    }

    public function create($product_id)
    {
        $product = Product::findOrFail($product_id);
        return view('admin.stock.create', compact('product'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_product' => 'required|exists:products,id',
            'qty' => 'required|integer|min:1',
            'tipe' => 'required|in:masuk,keluar',
            'keterangan' => 'required|string|max:255',
        ]);

        DB::beginTransaction();
        try {
            $product = Product::findOrFail($request->id_product);
            
            if ($request->tipe == 'masuk') {
                $product->stok += $request->qty;
            } else {
                if ($product->stok < $request->qty) {
                    throw new \Exception('Stok tidak mencukupi. Stok tersedia: ' . $product->stok);
                }
                $product->stok -= $request->qty;
            }
            
            $product->save();

            $stokLog = StokLog::create([
                'id_product' => $request->id_product,
                'tipe' => $request->tipe,
                'qty' => $request->qty,
                'keterangan' => $request->keterangan,
                'id_user' => Auth::id(),
            ]);

            try {
                Log::create([
                    'id_user' => Auth::id(),
                    'role_user' => Auth::user()->role,
                    'activity' => 'Stock ' . ucfirst($request->tipe),
                    'keterangan' => $request->tipe == 'masuk' 
                        ? 'Menambah stok ' . $product->nama_produk . ' sebanyak ' . $request->qty . ' pcs. Keterangan: ' . $request->keterangan
                        : 'Mengurangi stok ' . $product->nama_produk . ' sebanyak ' . $request->qty . ' pcs. Keterangan: ' . $request->keterangan,
                ]);
            } catch (\Exception $e) {
                Log::error('Gagal menyimpan log: ' . $e->getMessage());
            }

            DB::commit();

            return redirect()->route('admin.stock.index')
                ->with('success', 'Stok berhasil di' . ($request->tipe == 'masuk' ? 'tambah' : 'kurang') . 'i.');
                
        } catch (\Exception $e) {
            DB::rollback();
            
            return redirect()->route('admin.stock.create', $request->id_product)
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function log(Request $request)
    {
        $query = StokLog::with(['product', 'user'])->latest();
        
        if ($request->filled('tipe')) {
            $query->where('tipe', $request->tipe);
        }
        
        if ($request->filled('product')) {
            $query->where('id_product', $request->product);
        }
        
        if ($request->filled('start_date')) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }
        
        if ($request->filled('end_date')) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }
        
        $logs = $query->paginate(20);
        $totalMasuk = StokLog::where('tipe', 'masuk')->sum('qty');
        $totalKeluar = StokLog::where('tipe', 'keluar')->sum('qty');
        
        $products = Product::all();
        
        return view('admin.stock.log', compact('logs', 'totalMasuk', 'totalKeluar', 'products'));
    }

    public function export(Request $request)
    {
        $query = StokLog::with(['product', 'user', 'product.category']);
        
        if ($request->tipe) {
            $query->where('tipe', $request->tipe);
        }
        
        if ($request->product) {
            $query->where('product_id', $request->product);
        }
        
        if ($request->start_date) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }
        
        if ($request->end_date) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }
        
        $logs = $query->orderBy('created_at', 'desc')->get();
        
        return Excel::download(new StockLogExport($logs), 'log_stok_' . date('Y-m-d_His') . '.xlsx');
    }
}