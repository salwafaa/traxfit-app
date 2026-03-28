<?php

namespace App\Http\Controllers\Kasir;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\Member;
use App\Models\MembershipPackage;
use App\Models\Product;
use App\Models\Log;
use App\Models\GymSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class MembershipTransactionController extends Controller
{
    public function create()
    {
        $nomorUnik = $this->generateNomorUnik();
        // Hapus where('is_active', true) - tampilkan semua paket
        $membershipPackages = MembershipPackage::all();
        $products = Product::with('category')->where('stok', '>', 0)->get();
        $gymSettings = GymSetting::first();
        
        // LOG: Membuka halaman transaksi membership
        Log::create([
            'id_user' => auth()->id(),
            'role_user' => auth()->user()->role,
            'activity' => 'Open Membership Transaction',
            'keterangan' => 'Kasir membuka halaman transaksi membership',
        ]);

        return view('kasir.transaksi.membership.create', compact(
            'nomorUnik', 
            'membershipPackages', 
            'products',
            'gymSettings'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            // Data Member Baru
            'nama' => 'required|string|max:255',
            'telepon' => 'required|string|max:20',
            'alamat' => 'required|string',
            'jenis_identitas' => 'required|in:KTP,SIM',
            'no_identitas' => 'required|string|max:50',
            'tgl_lahir' => 'required|date',
            'foto_identitas' => 'nullable|image|max:2048', // Max 2MB
            
            // Data Transaksi
            'jenis_transaksi' => 'required|in:membership,produk_membership',
            'id_paket' => 'required|exists:membership_packages,id',
            'tgl_mulai' => 'required|date',
            
            // Data Produk (jika produk_membership)
            'items' => 'required_if:jenis_transaksi,produk_membership|array',
            'items.*.product_id' => 'required_if:jenis_transaksi,produk_membership|exists:products,id',
            'items.*.qty' => 'required_if:jenis_transaksi,produk_membership|integer|min:1',
            
            // Pembayaran
            'total_harga' => 'required|numeric|min:0',
            'uang_bayar' => 'required|numeric|min:0',
            'uang_kembali' => 'required|numeric|min:0',
            'catatan' => 'nullable|string',
        ]);

        DB::beginTransaction();
        try {
            // 1. Upload foto identitas jika ada
            $fotoPath = null;
            if ($request->hasFile('foto_identitas')) {
                $fotoPath = $request->file('foto_identitas')->store('identitas', 'public');
            }

            // 2. Generate kode member unik
            $kodeMember = $this->generateKodeMember();

            // 3. Dapatkan paket membership
            $package = MembershipPackage::findOrFail($request->id_paket);
            
            // 4. Hitung tanggal expired
            $tglExpired = date('Y-m-d H:i:s', strtotime($request->tgl_mulai . ' + ' . $package->durasi_hari . ' days'));

            // 5. Buat member baru
            $member = Member::create([
                'kode_member' => $kodeMember,
                'nama' => $request->nama,
                'telepon' => $request->telepon,
                'alamat' => $request->alamat,
                'jenis_member' => 'regular',
                'id_paket' => $request->id_paket,
                'no_identitas' => $request->no_identitas,
                'jenis_identitas' => $request->jenis_identitas,
                'tgl_lahir' => $request->tgl_lahir,
                'foto_identitas' => $fotoPath,
                'tgl_daftar' => now(),
                'tgl_expired' => $tglExpired,
                'status' => 'active',
                'created_by' => auth()->id(),
            ]);

            // 6. Hitung total
            $totalHarga = $package->harga;
            $subtotalProduk = 0;
            $items = [];

            // 7. Proses produk jika ada
            if ($request->jenis_transaksi == 'produk_membership' && $request->has('items')) {
                foreach ($request->items as $item) {
                    $product = Product::findOrFail($item['product_id']);
                    
                    // Cek stok
                    if ($product->stok < $item['qty']) {
                        throw new \Exception("Stok produk {$product->nama_produk} tidak mencukupi. Tersedia: {$product->stok}");
                    }
                    
                    // Kurangi stok
                    $product->decrement('stok', $item['qty']);
                    
                    $subtotal = $product->harga * $item['qty'];
                    $subtotalProduk += $subtotal;
                    
                    $items[] = [
                        'product_id' => $product->id,
                        'nama_produk' => $product->nama_produk,
                        'harga_satuan' => $product->harga,
                        'qty' => $item['qty'],
                        'subtotal' => $subtotal
                    ];
                }
                
                $totalHarga += $subtotalProduk;
            }

            // ============ PERBAIKAN UTAMA ============
            // 8. Siapkan data tambahan dengan format yang benar
            $dataTambahan = [
                // Data Paket Membership (sesuai dengan yang diharapkan helper di model)
                'id_paket' => $package->id,
                'nama_paket' => $package->nama_paket,
                'durasi_hari' => $package->durasi_hari,
                'harga_paket' => $package->harga,
                'tgl_mulai' => $request->tgl_mulai,
                'tgl_selesai' => $tglExpired,
                
                // Data tambahan lainnya (opsional)
                'subtotal_produk' => $subtotalProduk,
                'produk' => $items, // untuk detail produk di data_tambahan
            ];
            // =========================================

            // 9. Buat transaksi
            $transaction = Transaction::create([
                'nomor_unik' => $this->generateNomorUnik(),
                'id_user' => auth()->id(),
                'id_member' => $member->id,
                'jenis_transaksi' => $request->jenis_transaksi,
                'total_harga' => $totalHarga,
                'uang_bayar' => $request->uang_bayar,
                'uang_kembali' => $request->uang_kembali,
                'metode_bayar' => 'cash',
                'status_transaksi' => 'success', // <--- PERBAIKAN: gunakan 'success' sesuai ENUM
                'catatan' => $request->catatan,
                'data_tambahan' => $dataTambahan, // SEKARANG FORMATNYA SUDAH BENAR
            ]);

            // 10. Simpan detail produk jika ada
            if (!empty($items)) {
                foreach ($items as $item) {
                    $transaction->details()->create([
                        'id_product' => $item['product_id'], // PERBAIKAN: 'id_product' bukan 'id_produk'
                        'qty' => $item['qty'],
                        'harga_satuan' => $item['harga_satuan'],
                        'subtotal' => $item['subtotal'],
                    ]);
                }
            }

            // 11. Log aktivitas
            Log::create([
                'id_user' => auth()->id(),
                'role_user' => auth()->user()->role,
                'activity' => 'Create Membership Transaction',
                'keterangan' => 'Transaksi membership baru: ' . $transaction->nomor_unik . ' - Member: ' . $member->nama . ' (' . $member->kode_member . ')',
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Transaksi membership berhasil!',
                'transaction_id' => $transaction->id,
                'nomor_unik' => $transaction->nomor_unik,
                'member' => [
                    'id' => $member->id,
                    'kode' => $member->kode_member,
                    'nama' => $member->nama,
                ]
            ]);

        } catch (\Exception $e) {
            DB::rollback();
            
            return response()->json([
                'success' => false,
                'message' => 'Gagal memproses transaksi: ' . $e->getMessage()
            ], 500);
        }
    }

    public function show($id)
    {
        $transaction = Transaction::with(['member', 'user', 'details.product'])
            ->where('jenis_transaksi', 'LIKE', '%membership%')
            ->findOrFail($id);
            
        $gymSettings = GymSetting::first();

        return view('kasir.transaksi.membership.show', compact('transaction', 'gymSettings'));
    }

    public function struk($id)
    {
        $transaction = Transaction::with(['member', 'user', 'details.product'])
            ->where('jenis_transaksi', 'LIKE', '%membership%')
            ->findOrFail($id);
            
        $gymSettings = GymSetting::first();

        return view('kasir.transaksi.membership.struk', compact('transaction', 'gymSettings'));
    }

    public function kartuMember($id)
    {
        $transaction = Transaction::with(['member', 'details'])
            ->where('jenis_transaksi', 'LIKE', '%membership%')
            ->findOrFail($id);
            
        $gymSettings = GymSetting::first();

        return view('kasir.transaksi.membership.kartu', compact('transaction', 'gymSettings'));
    }

    private function generateNomorUnik()
    {
        $prefix = 'TRX-' . date('Ymd') . '-';
        $lastTransaction = Transaction::where('nomor_unik', 'like', $prefix . '%')
            ->orderBy('id', 'desc')
            ->first();

        if ($lastTransaction) {
            $lastNumber = intval(substr($lastTransaction->nomor_unik, -4));
            $newNumber = str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);
        } else {
            $newNumber = '0001';
        }

        return $prefix . $newNumber;
    }

    private function generateKodeMember()
    {
        $prefix = 'MBR-' . date('Y') . '-';
        $lastMember = Member::where('kode_member', 'like', $prefix . '%')
            ->orderBy('id', 'desc')
            ->first();

        if ($lastMember) {
            $lastNumber = intval(substr($lastMember->kode_member, -4));
            $newNumber = str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);
        } else {
            $newNumber = '0001';
        }

        return $prefix . $newNumber;
    }
}