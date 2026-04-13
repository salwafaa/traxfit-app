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
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class MembershipTransactionController extends Controller
{
    public function create(Request $request)
    {
        $nomorUnik = $this->generateNomorUnik();
        $membershipPackages = MembershipPackage::where('status', true)->get();
        $products = Product::with('category')->where('stok', '>', 0)->get();
        $gymSettings = GymSetting::first();

        $preloadMember = null;
        $isRenewMode = false;

        if ($request->has('member_id') && $request->has('mode') && $request->mode === 'renew') {
            $member = Member::with('package')->find($request->member_id);
            if ($member) {
                $isRenewMode = true;
                $preloadMember = [
                    'id'              => $member->id,
                    'kode_member'     => $member->kode_member,
                    'nama'            => $member->nama,
                    'telepon'         => $member->telepon ?? '',
                    'alamat'          => $member->alamat ?? '',
                    'tgl_lahir'       => $member->tgl_lahir ? Carbon::parse($member->tgl_lahir)->format('Y-m-d') : '',
                    'jenis_identitas' => $member->jenis_identitas ?? '',
                    'no_identitas'    => $member->no_identitas ?? '',
                    'foto_identitas'  => $member->foto_identitas ?? null,
                    'tgl_expired'     => $member->tgl_expired ? Carbon::parse($member->tgl_expired)->format('d/m/Y') : '-',
                    'paket_lama'      => $member->package ? $member->package->nama_paket : '-',
                ];
            }
        }

        Log::create([
            'id_user'    => auth()->id(),
            'role_user'  => auth()->user()->role,
            'activity'   => $isRenewMode ? 'Open Renew Membership' : 'Open Membership Transaction',
            'keterangan' => $isRenewMode
                ? 'Kasir membuka halaman perpanjangan membership untuk member: ' . ($preloadMember['nama'] ?? '')
                : 'Kasir membuka halaman transaksi membership',
        ]);

        return view('kasir.transaksi.membership.create', compact(
            'nomorUnik',
            'membershipPackages',
            'products',
            'gymSettings',
            'preloadMember',
            'isRenewMode'
        ));
    }

    public function store(Request $request)
    {
        try {
            $isRenew = $request->filled('existing_member_id');

            $rules = [
                'jenis_transaksi' => 'required|in:membership,produk_membership',
                'id_paket'        => 'required|exists:membership_packages,id',
                'tgl_mulai'       => 'required|date',
                'total_harga'     => 'required|numeric|min:0',
                'uang_bayar'      => 'required|numeric|min:0',
                'uang_kembali'    => 'required|numeric|min:0',
                'catatan'         => 'nullable|string',
            ];

            if ($isRenew) {
                $rules['existing_member_id'] = 'required|exists:members,id';
                $rules['nama']               = 'required|string|max:255';
                $rules['telepon']            = 'required|string|max:20';
                $rules['alamat']             = 'required|string';
                $rules['jenis_identitas']    = 'required|in:KTP,SIM';
                $rules['no_identitas']       = 'required|string|max:50';
                $rules['tgl_lahir']          = 'required|date';
            } else {
                $rules['nama']            = 'required|string|max:255';
                $rules['telepon']         = 'required|string|max:20';
                $rules['alamat']          = 'required|string';
                $rules['jenis_identitas'] = 'required|in:KTP,SIM';
                $rules['no_identitas']    = 'required|string|max:50';
                $rules['tgl_lahir']       = 'required|date';
                $rules['foto_identitas']  = 'nullable|image|max:2048';
            }

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validasi gagal: ' . $validator->errors()->first()
                ], 422);
            }

            DB::beginTransaction();

            $package  = MembershipPackage::findOrFail($request->id_paket);
            $tglExpired = date('Y-m-d H:i:s', strtotime($request->tgl_mulai . ' + ' . $package->durasi_hari . ' days'));

            if ($isRenew) {
                $member = Member::findOrFail($request->existing_member_id);

                $fotoPath = $member->foto_identitas;
                if ($request->hasFile('foto_identitas') && $request->file('foto_identitas')->isValid()) {
                    $fotoPath = $request->file('foto_identitas')->store('identitas', 'public');
                }

                Member::withoutEvents(function () use ($member, $request, $package, $tglExpired, $fotoPath) {
                    $member->update([
                        'nama'            => $request->nama,
                        'telepon'         => $request->telepon,
                        'alamat'          => $request->alamat,
                        'jenis_identitas' => $request->jenis_identitas,
                        'no_identitas'    => $request->no_identitas,
                        'tgl_lahir'       => $request->tgl_lahir,
                        'foto_identitas'  => $fotoPath,
                        'id_paket'        => $request->id_paket,
                        'tgl_expired'     => $tglExpired,
                        'status'          => 'active',
                    ]);
                });

                $logActivity = 'Renew Membership Transaction';
                $logKeterangan = 'Perpanjangan membership: ' . $member->nama . ' (' . $member->kode_member . ')';

            } else {
                $fotoPath = null;
                if ($request->hasFile('foto_identitas') && $request->file('foto_identitas')->isValid()) {
                    $fotoPath = $request->file('foto_identitas')->store('identitas', 'public');
                }

                $kodeMember = $this->generateKodeMember();

                $member = Member::create([
                    'kode_member'     => $kodeMember,
                    'nama'            => $request->nama,
                    'telepon'         => $request->telepon,
                    'alamat'          => $request->alamat,
                    'jenis_member'    => 'regular',
                    'id_paket'        => $request->id_paket,
                    'no_identitas'    => $request->no_identitas,
                    'jenis_identitas' => $request->jenis_identitas,
                    'tgl_lahir'       => $request->tgl_lahir,
                    'foto_identitas'  => $fotoPath,
                    'tgl_daftar'      => now(),
                    'tgl_expired'     => $tglExpired,
                    'status'          => 'active',
                ]);

                $logActivity    = 'Create Membership Transaction';
                $logKeterangan  = 'Transaksi membership baru: ' . $member->nama . ' (' . $member->kode_member . ')';
            }

            $totalHarga     = (float) $package->harga;
            $subtotalProduk = 0;
            $items          = [];

            if ($request->jenis_transaksi === 'produk_membership' && $request->has('items')) {
                $itemsArray = is_string($request->items)
                    ? json_decode($request->items, true)
                    : $request->items;

                if (is_array($itemsArray)) {
                    foreach ($itemsArray as $item) {
                        if (!isset($item['product_id'], $item['qty'])) continue;

                        $product = Product::findOrFail($item['product_id']);

                        if ($product->stok < $item['qty']) {
                            throw new \Exception("Stok produk {$product->nama_produk} tidak mencukupi. Tersedia: {$product->stok}");
                        }

                        $product->decrement('stok', $item['qty']);

                        $subtotal        = (float) $product->harga * (int) $item['qty'];
                        $subtotalProduk += $subtotal;

                        $items[] = [
                            'product_id'   => $product->id,
                            'nama_produk'  => $product->nama_produk,
                            'harga_satuan' => (float) $product->harga,
                            'qty'          => (int) $item['qty'],
                            'subtotal'     => $subtotal,
                        ];
                    }
                }

                $totalHarga += $subtotalProduk;
            }

            $dataTambahan = [
                'paket_membership' => [
                    'id_paket'    => $package->id,
                    'nama'        => $package->nama_paket,
                    'durasi_hari' => $package->durasi_hari,
                    'harga'       => (float) $package->harga,
                ],
                'tgl_mulai'       => $request->tgl_mulai,
                'tgl_selesai'     => $tglExpired,
                'subtotal_produk' => $subtotalProduk,
                'produk'          => $items,
                'is_renewal'      => $isRenew,
            ];

            $transaction = Transaction::create([
                'nomor_unik'        => $this->generateNomorUnik(),
                'id_user'           => auth()->id(),
                'id_member'         => $member->id,
                'jenis_transaksi'   => $request->jenis_transaksi,
                'total_harga'       => (float) $totalHarga,
                'uang_bayar'        => (float) $request->uang_bayar,
                'uang_kembali'      => (float) $request->uang_kembali,
                'metode_bayar'      => 'cash',
                'status_transaksi'  => 'success',
                'catatan'           => $request->catatan ?? null,
                'data_tambahan'     => $dataTambahan,
            ]);

            foreach ($items as $item) {
                $transaction->details()->create([
                    'id_transaction' => $transaction->id,
                    'id_product'     => $item['product_id'],
                    'qty'            => $item['qty'],
                    'harga_satuan'   => $item['harga_satuan'],
                    'subtotal'       => $item['subtotal'],
                ]);
            }

            Log::create([
                'id_user'    => auth()->id(),
                'role_user'  => auth()->user()->role,
                'activity'   => $logActivity,
                'keterangan' => $logKeterangan . ' | No. Transaksi: ' . $transaction->nomor_unik,
            ]);

            DB::commit();

            return response()->json([
                'success'        => true,
                'message'        => $isRenew ? 'Perpanjangan membership berhasil!' : 'Transaksi membership berhasil!',
                'transaction_id' => $transaction->id,
                'nomor_unik'     => $transaction->nomor_unik,
                'is_renewal'     => $isRenew,
                'member'         => [
                    'id'   => $member->id,
                    'kode' => $member->kode_member,
                    'nama' => $member->nama,
                ],
            ]);

        } catch (\Exception $e) {
            DB::rollback();

            \Log::error('Membership Transaction Error: ' . $e->getMessage());
            \Log::error($e->getTraceAsString());

            return response()->json([
                'success' => false,
                'message' => 'Gagal memproses transaksi: ' . $e->getMessage()
            ], 500);
        }
    }
}