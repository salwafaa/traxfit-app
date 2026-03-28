<?php

namespace App\Http\Controllers\Kasir;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use App\Models\Member;
use App\Models\Product;
use App\Models\StokLog;
use App\Models\Log;
use App\Models\MembershipPackage;
use App\Models\GymSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        $query = Transaction::with(['user', 'member'])
            ->where('id_user', auth()->id());

        // Filter by date
        if ($request->filled('start_date')) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }
        if ($request->filled('end_date')) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }

        // Filter by member status
        if ($request->filled('member_status')) {
            if ($request->member_status == 'member') {
                $query->whereNotNull('id_member');
            } elseif ($request->member_status == 'nonmember') {
                $query->whereNull('id_member');
            }
        }

        // Filter by transaction type
        if ($request->filled('jenis_transaksi')) {
            $query->where('jenis_transaksi', $request->jenis_transaksi);
        }

        $transactions = $query->latest()->paginate(20);
        
        $totalToday = Transaction::where('id_user', auth()->id())
            ->whereDate('created_at', today())
            ->sum('total_harga');

        $totalPendapatan = $query->sum('total_harga');
        $totalMember = $query->whereNotNull('id_member')->count();
        $totalNonMember = $query->whereNull('id_member')->count();
            
        return view('kasir.transaksi.index', compact('transactions', 'totalToday', 'totalPendapatan', 'totalMember', 'totalNonMember'));
    }

    public function create()
    {
        $nomorUnik = Transaction::generateNomorUnik();
        $products = Product::with('category')
            ->where('status', true)
            ->orderBy('nama_produk')
            ->get();
        $membershipPackages = MembershipPackage::where('status', true)->get();
        
        // ===== PERBAIKAN: AMBIL HARGA VISIT DARI GYM SETTINGS =====
        $gymSettings = GymSetting::first();
        
        // Jika belum ada setting, buat default
        if (!$gymSettings) {
            $gymSettings = GymSetting::create([
                'nama_gym' => 'TRAXFIT GYM',
                'harga_visit' => 25000,
                'footer_struk' => 'Terima kasih telah berolahraga bersama kami!'
            ]);
        }
        
        $hargaVisit = $gymSettings->harga_visit ?? 25000; // Default 25000 jika belum diatur
        // ==========================================================
        
        return view('kasir.transaksi.create', compact('nomorUnik', 'products', 'membershipPackages', 'hargaVisit'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'jenis_transaksi' => 'required|in:produk,visit,membership,produk_visit,produk_membership',
            'items' => 'required_if:jenis_transaksi,produk,produk_visit,produk_membership|array',
            'items.*.product_id' => 'required_if:jenis_transaksi,produk,produk_visit,produk_membership|exists:products,id',
            'items.*.qty' => 'required_if:jenis_transaksi,produk,produk_visit,produk_membership|integer|min:1',
            'total_harga' => 'required|numeric|min:0',
            'uang_bayar' => 'required|numeric|min:0',
            'uang_kembali' => 'required|numeric|min:0',
            'metode_bayar' => 'required|in:cash',
            'member_id' => 'nullable|exists:members,id',
            'catatan' => 'nullable|string',
            
            // Visit validation
            'harga_visit' => 'required_if:jenis_transaksi,visit,produk_visit|numeric|min:0',
            'tgl_visit' => 'required_if:jenis_transaksi,visit,produk_visit|date',
            
            // Membership validation
            'id_paket' => 'required_if:jenis_transaksi,membership,produk_membership|exists:membership_packages,id',
            'tgl_mulai_membership' => 'required_if:jenis_transaksi,membership,produk_membership|date',
        ]);

        // Validasi stok produk
        if (in_array($request->jenis_transaksi, ['produk', 'produk_visit', 'produk_membership'])) {
            foreach ($request->items as $item) {
                $product = Product::find($item['product_id']);
                if ($product->stok < $item['qty']) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Stok ' . $product->nama_produk . ' tidak cukup. Stok tersedia: ' . $product->stok
                    ], 400);
                }
            }
        }

        DB::beginTransaction();
        try {
            // Proses member baru jika ada
            $memberId = $request->member_id;
            
            if ($request->has('new_member')) {
                $newMember = $request->new_member;
                
                if (empty($newMember['nama']) || empty($newMember['telepon']) || empty($newMember['id_paket'])) {
                    throw new \Exception('Data member baru tidak lengkap');
                }
                
                $package = MembershipPackage::find($newMember['id_paket']);
                if (!$package) {
                    throw new \Exception('Paket membership tidak ditemukan');
                }
                
                $kodeMember = 'MBR' . date('Ymd') . rand(100, 999);
                $tglDaftar = now();
                $tglExpired = now()->addDays($package->durasi_hari);
                
                $member = Member::create([
                    'kode_member' => $kodeMember,
                    'nama' => $newMember['nama'],
                    'telepon' => $newMember['telepon'],
                    'alamat' => $newMember['alamat'] ?? null,
                    'jenis_member' => 'member',
                    'id_paket' => $newMember['id_paket'],
                    'tgl_daftar' => $tglDaftar,
                    'tgl_expired' => $tglExpired,
                    'status' => 'active'
                ]);
                
                $memberId = $member->id;
            }

            // Siapkan data tambahan (JSON)
            $dataTambahan = [];
            
            // Data Visit
            if (in_array($request->jenis_transaksi, ['visit', 'produk_visit'])) {
                $dataTambahan['harga_visit'] = $request->harga_visit;
                $dataTambahan['tgl_visit'] = $request->tgl_visit;
            }
            
            // Data Membership
            if (in_array($request->jenis_transaksi, ['membership', 'produk_membership'])) {
                $package = MembershipPackage::find($request->id_paket);
                $tglMulai = Carbon::parse($request->tgl_mulai_membership);
                $tglSelesai = $tglMulai->copy()->addDays($package->durasi_hari);
                
                $dataTambahan['id_paket'] = $package->id;
                $dataTambahan['nama_paket'] = $package->nama_paket;
                $dataTambahan['durasi_hari'] = $package->durasi_hari;
                $dataTambahan['harga_paket'] = $package->harga;
                $dataTambahan['tgl_mulai'] = $tglMulai->format('Y-m-d H:i:s');
                $dataTambahan['tgl_selesai'] = $tglSelesai->format('Y-m-d H:i:s');

                // Update masa aktif member
                if ($memberId) {
                    $member = Member::find($memberId);
                    if ($member) {
                        if ($member->tgl_expired && $member->tgl_expired > now()) {
                            $newExpired = Carbon::parse($member->tgl_expired)->addDays($package->durasi_hari);
                        } else {
                            $newExpired = $tglMulai->copy()->addDays($package->durasi_hari);
                        }
                        $member->tgl_expired = $newExpired;
                        $member->save();
                    }
                }
            }

            // Buat transaksi utama
            $transaction = Transaction::create([
                'id_user' => auth()->id(),
                'id_member' => $memberId,
                'nomor_unik' => Transaction::generateNomorUnik(),
                'jenis_transaksi' => $request->jenis_transaksi, // BARU
                'total_harga' => $request->total_harga,
                'uang_bayar' => $request->uang_bayar,
                'uang_kembali' => $request->uang_kembali,
                'metode_bayar' => $request->metode_bayar,
                'status_transaksi' => 'success',
                'catatan' => $request->catatan,
                'data_tambahan' => !empty($dataTambahan) ? $dataTambahan : null, // BARU
            ]);

            // Simpan detail produk
            if (in_array($request->jenis_transaksi, ['produk', 'produk_visit', 'produk_membership']) && !empty($request->items)) {
                foreach ($request->items as $item) {
                    $product = Product::find($item['product_id']);
                    
                    TransactionDetail::create([
                        'id_transaction' => $transaction->id,
                        'id_product' => $item['product_id'],
                        'qty' => $item['qty'],
                        'harga_satuan' => $product->harga,
                        'subtotal' => $product->harga * $item['qty'],
                    ]);

                    // Update stok
                    $product->stok -= $item['qty'];
                    $product->save();

                    StokLog::create([
                        'id_product' => $item['product_id'],
                        'tipe' => 'keluar',
                        'qty' => $item['qty'],
                        'keterangan' => 'Penjualan transaksi ' . $transaction->nomor_unik,
                        'id_user' => auth()->id(),
                    ]);
                }
            }

            // Log aktivitas
            $jenisLabels = [
                'produk' => 'Pembelian Produk',
                'visit' => 'Visit',
                'membership' => 'Membership',
                'produk_visit' => 'Produk + Visit',
                'produk_membership' => 'Produk + Membership'
            ];

            Log::create([
                'id_user' => auth()->id(),
                'role_user' => auth()->user()->role,
                'activity' => 'Create Transaction',
                'keterangan' => $jenisLabels[$request->jenis_transaksi] . ': ' . $transaction->nomor_unik . ' dengan total Rp ' . number_format($transaction->total_harga, 0, ',', '.'),
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Transaksi berhasil disimpan',
                'transaction_id' => $transaction->id,
                'nomor_unik' => $transaction->nomor_unik,
                'jenis_transaksi' => $transaction->jenis_transaksi
            ]);
            
        } catch (\Exception $e) {
            DB::rollback();
            
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    public function show($id)
    {
        $transaction = Transaction::with([
            'user', 
            'member', 
            'details.product.category'
        ])->findOrFail($id);
        
        if ($transaction->id_user != auth()->id()) {
            abort(403, 'Anda tidak memiliki akses ke transaksi ini');
        }
        
        return view('kasir.transaksi.show', compact('transaction'));
    }

    public function struk($id)
    {
        $transaction = Transaction::with([
            'user', 
            'member', 
            'details.product'
        ])->findOrFail($id);
        
        if ($transaction->id_user != auth()->id()) {
            abort(403, 'Anda tidak memiliki akses ke transaksi ini');
        }
        
        $gymSettings = GymSetting::first();
        
        return view('kasir.transaksi.struk', compact('transaction', 'gymSettings'));
    }

    public function cariProduk(Request $request)
    {
        $search = $request->input('search', '');
        
        $products = Product::where('status', true)
            ->where(function($query) use ($search) {
                $query->where('nama_produk', 'like', "%{$search}%")
                      ->orWhere('deskripsi', 'like', "%{$search}%");
            })
            ->where('stok', '>', 0)
            ->take(10)
            ->get()
            ->map(function($product) {
                return [
                    'id' => $product->id,
                    'nama' => $product->nama_produk,
                    'harga' => $product->harga,
                    'stok' => $product->stok,
                    'kategori' => $product->category->nama_kategori ?? '-',
                    'harga_formatted' => 'Rp ' . number_format($product->harga, 0, ',', '.'),
                ];
            });
        
        return response()->json($products);
    }

    public function cariMember(Request $request)
    {
        $search = $request->input('search', '');
        
        $members = Member::with('package')
            ->where('status', 'active')
            ->where('tgl_expired', '>=', now())
            ->where(function($query) use ($search) {
                $query->where('nama', 'like', "%{$search}%")
                      ->orWhere('kode_member', 'like', "%{$search}%")
                      ->orWhere('telepon', 'like', "%{$search}%");
            })
            ->take(10)
            ->get()
            ->map(function($member) {
                return [
                    'id' => $member->id,
                    'kode' => $member->kode_member,
                    'nama' => $member->nama,
                    'status' => 'Aktif',
                    'expired' => $member->tgl_expired->format('d/m/Y'),
                    'sisa_hari' => $member->sisa_hari,
                    'is_active' => $member->is_active,
                ];
            });
        
        return response()->json($members);
    }

    public function getHargaVisit()
{
    $gymSettings = GymSetting::first();
    return response()->json([
        'harga_visit' => $gymSettings->harga_visit ?? 25000
    ]);
}
}