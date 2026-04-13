<?php

namespace App\Http\Controllers\Kasir;

use App\Http\Controllers\Controller;
use App\Models\Member;
use App\Models\MemberCheckin;
use App\Models\MembershipPackage;
use App\Models\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class MemberController extends Controller
{
    public function cek()
    {
        $today = now()->startOfDay();

        $totalActive = Member::where('status', 'active')
            ->whereDate('tgl_expired', '>=', $today)
            ->count();

        $expiredToday = Member::whereDate('tgl_expired', $today)
            ->where('status', 'active')
            ->count();

        $almostExpired = Member::where('status', 'active')
            ->whereDate('tgl_expired', '>=', $today)
            ->whereDate('tgl_expired', '<=', $today->copy()->addDays(7))
            ->count();

        $allMembers = Member::with('package')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('kasir.member.cek', compact('totalActive', 'expiredToday', 'almostExpired', 'allMembers'));
    }

    public function cari(Request $request)
    {
        $search = $request->input('search', '');

        if (empty($search) || strlen($search) < 2) {
            return response()->json([]);
        }

        $today = now()->startOfDay();

        $members = Member::with('package')
            ->where(function ($query) use ($search) {
                $query->where('nama', 'like', "%{$search}%")
                    ->orWhere('kode_member', 'like', "%{$search}%")
                    ->orWhere('telepon', 'like', "%{$search}%");
            })
            ->orderBy('nama')
            ->get();

        $result = $members->map(function ($member) use ($today) {
            $expired = $member->tgl_expired
                ? Carbon::parse($member->tgl_expired)->startOfDay()
                : null;

            $sisaHari = $expired ? $today->diffInDays($expired, false) : 0;

            if ($member->status == 'active' && $expired && $expired >= $today) {
                $status   = $sisaHari <= 7 ? 'Akan Expired' : 'Aktif';
                $isActive = true;
            } else {
                $status   = 'Expired';
                $isActive = false;
            }

            return [
                'id'           => $member->id,
                'kode'         => $member->kode_member,
                'nama'         => $member->nama,
                'telepon'      => $member->telepon ?? '-',
                'paket'        => $member->package ? $member->package->nama_paket : '-',
                'tgl_daftar'   => $member->tgl_daftar ? Carbon::parse($member->tgl_daftar)->format('d/m/Y') : '-',
                'tgl_expired'  => $member->tgl_expired ? Carbon::parse($member->tgl_expired)->format('d/m/Y') : '-',
                'status'       => $status,
                'sisa_hari'    => $sisaHari >= 0 ? $sisaHari : abs($sisaHari),
                'is_active'    => $isActive,
                'jenis_member' => $member->jenis_member ?? 'Regular',
            ];
        });

        return response()->json($result);
    }

    public function getMember($id)
    {
        try {
            $member  = Member::with('package')->findOrFail($id);
            $today   = now()->startOfDay();
            $expired = $member->tgl_expired
                ? Carbon::parse($member->tgl_expired)->startOfDay()
                : null;

            if ($member->status == 'active' && $expired && $expired >= $today) {
                $sisaHari = $today->diffInDays($expired);
                $status   = $sisaHari <= 7 ? 'Akan Expired' : 'Aktif';
                $isActive = true;
            } else {
                $sisaHari = $expired ? abs($today->diffInDays($expired, false)) : 0;
                $status   = 'Expired';
                $isActive = false;
            }

            return response()->json([
                'id'           => $member->id,
                'kode'         => $member->kode_member,
                'nama'         => $member->nama,
                'telepon'      => $member->telepon ?? '-',
                'paket'        => $member->package ? $member->package->nama_paket : '-',
                'tgl_daftar'   => $member->tgl_daftar ? Carbon::parse($member->tgl_daftar)->format('d/m/Y') : '-',
                'tgl_expired'  => $member->tgl_expired ? Carbon::parse($member->tgl_expired)->format('d/m/Y') : '-',
                'status'       => $status,
                'sisa_hari'    => $sisaHari,
                'is_active'    => $isActive,
                'jenis_member' => $member->jenis_member ?? 'Regular',
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Member tidak ditemukan'], 404);
        }
    }

    public function getPackages()
    {
        try {
            $packages = MembershipPackage::where('status', true)
                ->orderBy('nama_paket')
                ->get(['id', 'nama_paket', 'durasi_hari', 'harga']);

            return response()->json($packages);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function perpanjang(Request $request, $id)
    {
        $request->validate([
            'id_paket' => 'required|exists:membership_packages,id',
        ]);

        DB::beginTransaction();
        try {
            $member  = Member::findOrFail($id);
            $package = MembershipPackage::findOrFail($request->id_paket);

            $today   = now()->startOfDay();
            $expired = $member->tgl_expired
                ? Carbon::parse($member->tgl_expired)->startOfDay()
                : null;

            if ($member->status == 'active' && $expired && $expired >= $today) {
                $baseDate = Carbon::parse($member->tgl_expired);
            } else {
                $baseDate = now();
            }

            $tglExpiredBaru = $baseDate->copy()->addDays($package->durasi_hari);

            Member::withoutEvents(function () use ($member, $request, $tglExpiredBaru) {
                $member->update([
                    'id_paket'    => $request->id_paket,
                    'tgl_expired' => $tglExpiredBaru,
                    'status'      => 'active',
                ]);
            });

            $checkinOtomatis = MemberCheckin::buatCheckinOtomatis($member->id, auth()->id());

            Log::create([
                'id_user'    => auth()->id(),
                'role_user'  => auth()->user()->role,
                'activity'   => 'Renew Member',
                'keterangan' => 'Kasir memperpanjang member: ' . $member->nama
                    . ' (' . $member->kode_member . ') dengan paket ' . $package->nama_paket
                    . ($checkinOtomatis ? ' | Auto check-in dibuat.' : ' | Check-in sudah ada sebelumnya.'),
            ]);

            DB::commit();

            return response()->json([
                'success'          => true,
                'message'          => 'Member berhasil diperpanjang hingga ' . $tglExpiredBaru->format('d/m/Y')
                                    . '. Check-in hari ini otomatis tercatat. ✅',
                'auto_checkin'     => $checkinOtomatis !== null,
                'member'           => [
                    'id'      => $member->id,
                    'kode'    => $member->kode_member,
                    'nama'    => $member->nama,
                    'expired' => $tglExpiredBaru->format('d/m/Y'),
                ],
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function daftarBaru(Request $request)
    {
        $request->validate([
            'nama'     => 'required|string|max:255',
            'telepon'  => 'nullable|string|max:20',
            'id_paket' => 'required|exists:membership_packages,id',
        ]);

        DB::beginTransaction();
        try {
            $package    = MembershipPackage::findOrFail($request->id_paket);
            $tglExpired = now()->addDays($package->durasi_hari);

            $member = null;
            Member::withoutEvents(function () use ($request, $tglExpired, &$member) {
                $member = Member::create([
                    'nama'         => $request->nama,
                    'telepon'      => $request->telepon,
                    'alamat'       => $request->alamat ?? null,
                    'jenis_member' => $request->jenis_member ?? 'Regular',
                    'id_paket'     => $request->id_paket,
                    'tgl_daftar'   => now(),
                    'tgl_expired'  => $tglExpired,
                    'status'       => 'active',
                    'created_by'   => auth()->id(),
                ]);
            });

            if (empty($member->kode_member)) {
                $year  = date('Y');
                $month = date('m');
                $last  = Member::whereYear('created_at', $year)
                    ->whereMonth('created_at', $month)
                    ->where('id', '!=', $member->id)
                    ->orderBy('id', 'desc')
                    ->first();
                $num = $last
                    ? str_pad(intval(substr($last->kode_member, -4)) + 1, 4, '0', STR_PAD_LEFT)
                    : '0001';
                $member->kode_member = 'MBR-' . $year . $month . '-' . $num;
                $member->saveQuietly();
            }

            MemberCheckin::buatCheckinOtomatis($member->id, auth()->id());

            Log::create([
                'id_user'    => auth()->id(),
                'role_user'  => auth()->user()->role,
                'activity'   => 'Register New Member',
                'keterangan' => 'Kasir mendaftarkan member baru: ' . $member->nama
                    . ' (' . $member->kode_member . ') | Auto check-in dibuat.',
            ]);

            DB::commit();

            return response()->json([
                'success'      => true,
                'message'      => 'Member berhasil didaftarkan. Check-in hari ini otomatis tercatat. ✅',
                'auto_checkin' => true,
                'member'       => [
                    'id'      => $member->id,
                    'kode'    => $member->kode_member,
                    'nama'    => $member->nama,
                    'expired' => $tglExpired->format('d/m/Y'),
                ],
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage(),
            ], 500);
        }
    }
}