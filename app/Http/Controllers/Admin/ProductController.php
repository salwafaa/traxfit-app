<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log as FacadesLog;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('category')->latest()->get();
        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        $categories = ProductCategory::all();
        return view('admin.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        // Debug: lihat data yang dikirim
        FacadesLog::info('Data yang dikirim:', $request->all());
        
        // Validasi dengan pesan kustom
        $request->validate([
            'nama_produk' => 'required|string|max:255|unique:products,nama_produk',
            'harga' => 'required|numeric|min:0',
            'stok' => 'required|integer|min:0',
            'kategori' => 'required|exists:product_categories,id',
            'deskripsi' => 'nullable|string',
        ], [
            'nama_produk.required' => 'Nama produk wajib diisi',
            'nama_produk.unique' => 'Nama produk sudah digunakan',
            'harga.required' => 'Harga wajib diisi',
            'harga.numeric' => 'Harga harus berupa angka',
            'stok.required' => 'Stok wajib diisi',
            'stok.integer' => 'Stok harus berupa angka',
            'kategori.required' => 'Kategori wajib dipilih',
            'kategori.exists' => 'Kategori tidak valid',
        ]);

        DB::beginTransaction();
        try {
            // Cek dulu kolom apa saja yang ada di tabel products
            // Ini untuk debugging - hapus setelah selesai
            $columns = DB::getSchemaBuilder()->getColumnListing('products');
            FacadesLog::info('Kolom dalam tabel products:', $columns);
            
            // Data yang akan disimpan - SESUAIKAN DENGNA KOLOM DI DATABASE ANDA
            $data = [
                'nama_produk' => $request->nama_produk,
                'harga' => $request->harga,
                'stok' => $request->stok,
                'kategori' => $request->kategori,                    
                'deskripsi' => $request->deskripsi,
                'created_at' => now(),
                'updated_at' => now(),
            ];
            
            FacadesLog::info('Data yang akan disimpan:', $data);
            
            // Simpan data
            $product = Product::create($data);
            
            FacadesLog::info('Produk berhasil disimpan dengan ID: ' . $product->id);

            // Log aktivitas
            try {
                Log::create([
                    'id_user' => auth()->id(),
                    'role_user' => auth()->user()->role ?? 'admin',
                    'activity' => 'Create Product',
                    'keterangan' => 'Menambahkan produk baru: ' . $product->nama_produk,
                ]);
            } catch (\Exception $e) {
                FacadesLog::error('Gagal menyimpan log: ' . $e->getMessage());
                // Tetap lanjutkan meskipun log gagal
            }

            DB::commit();

            return redirect()->route('admin.products.index')
                ->with('success', 'Produk "' . $product->nama_produk . '" berhasil ditambahkan.');
                
        } catch (\Exception $e) {
            DB::rollback();
            
            FacadesLog::error('Error saat menyimpan produk: ' . $e->getMessage());
            FacadesLog::error('File: ' . $e->getFile() . ' Line: ' . $e->getLine());
            
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $categories = ProductCategory::all();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, $id)
    {
        FacadesLog::info('Update produk ID: ' . $id, $request->all());
        
        $product = Product::findOrFail($id);
        
        $request->validate([
            'nama_produk' => 'required|string|max:255|unique:products,nama_produk,' . $id,
            'harga' => 'required|numeric|min:0',
            'stok' => 'required|integer|min:0',
            'kategori' => 'required|exists:product_categories,id',
            'deskripsi' => 'nullable|string',
        ]);

        DB::beginTransaction();
        try {
            // Data yang akan diupdate - SESUAIKAN DENGAN KOLOM DI DATABASE ANDA
            $data = [
                'nama_produk' => $request->nama_produk,
                'harga' => $request->harga,
                'stok' => $request->stok,
                // UBAH 'kategori' ini sesuai dengan nama kolom di database Anda
                'kategori' => $request->kategori,                    // Jika kolomnya 'kategori'
                // 'id_kategori' => $request->kategori,              // Jika kolomnya 'id_kategori'
                // 'category_id' => $request->kategori,              // Jika kolomnya 'category_id'
                // 'kategori_id' => $request->kategori,              // Jika kolomnya 'kategori_id'
                'status' => $request->has('status') ? 1 : 0,
                'deskripsi' => $request->deskripsi,
            ];
            
            $product->update($data);

            // Log aktivitas
            try {
                Log::create([
                    'id_user' => auth()->id(),
                    'role_user' => auth()->user()->role ?? 'admin',
                    'activity' => 'Update Product',
                    'keterangan' => 'Mengupdate produk: ' . $product->nama_produk,
                ]);
            } catch (\Exception $e) {
                FacadesLog::error('Gagal menyimpan log: ' . $e->getMessage());
            }

            DB::commit();

            return redirect()->route('admin.products.index')
                ->with('success', 'Produk "' . $product->nama_produk . '" berhasil diupdate.');
                
        } catch (\Exception $e) {
            DB::rollback();
            
            FacadesLog::error('Error saat update produk: ' . $e->getMessage());
            
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        DB::beginTransaction();
        try {
            $namaProduk = $product->nama_produk;
            $product->delete();

            // Log aktivitas
            try {
                Log::create([
                    'id_user' => auth()->id(),
                    'role_user' => auth()->user()->role ?? 'admin',
                    'activity' => 'Delete Product',
                    'keterangan' => 'Menghapus produk: ' . $namaProduk,
                ]);
            } catch (\Exception $e) {
                FacadesLog::error('Gagal menyimpan log: ' . $e->getMessage());
            }

            DB::commit();

            return redirect()->route('admin.products.index')
                ->with('success', 'Produk "' . $namaProduk . '" berhasil dihapus.');
                
        } catch (\Exception $e) {
            DB::rollback();
            
            return redirect()->route('admin.products.index')
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function toggleStatus($id)
    {
        $product = Product::findOrFail($id);

        DB::beginTransaction();
        try {
            $oldStatus = $product->status;
            $product->status = !$product->status;
            $product->save();

            // Log aktivitas
            try {
                Log::create([
                    'id_user' => auth()->id(),
                    'role_user' => auth()->user()->role ?? 'admin',
                    'activity' => 'Toggle Product Status',
                    'keterangan' => 'Mengubah status produk ' . $product->nama_produk . ' dari ' . ($oldStatus ? 'aktif' : 'nonaktif') . ' menjadi ' . ($product->status ? 'aktif' : 'nonaktif'),
                ]);
            } catch (\Exception $e) {
                FacadesLog::error('Gagal menyimpan log: ' . $e->getMessage());
            }

            DB::commit();

            return redirect()->route('admin.products.index')
                ->with('success', 'Status produk "' . $product->nama_produk . '" berhasil diubah.');
                
        } catch (\Exception $e) {
            DB::rollback();
            
            return redirect()->route('admin.products.index')
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}