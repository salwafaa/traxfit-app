<?php

namespace App\Http\Controllers\Kasir;

use App\Http\Controllers\Controller;
use App\Models\Member;
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
    
    // Hitung statistik berdasarkan tgl_expired
    $totalActive = Member::whereDate('tgl_expired', '>=', $today)->count();
        
    $expiredToday = Member::whereDate('tgl_expired', $today)->count();
        
    $almostExpired = Member::whereDate('tgl_expired', '>=', $today)
        ->whereDate('tgl_expired', '<=', $today->copy()->addDays(7))
        ->count();

    return view('kasir.member.cek', compact('totalActive', 'expiredToday', 'almostExpired'));
}

public function cari(Request $request)
{
    $search = $request->input('search', '');
    
    if (empty($search) || strlen($search) < 2) {
        return response()->json([]);
    }
    
    \Log::info('Cek Member Search: ' . $search);
    
    $today = now()->startOfDay();
    
    $members = Member::with('package')
        ->where(function($query) use ($search) {
            $query->where('nama', 'like', "%{$search}%")
                  ->orWhere('kode_member', 'like', "%{$search}%")
                  ->orWhere('telepon', 'like', "%{$search}%");
        })
        ->orderBy('nama')
        ->limit(20)
        ->get();
    
    \Log::info('Cek Member Results: ' . $members->count());
    
    $result = $members->map(function($member) use ($today) {
        $expired = $member->tgl_expired ? Carbon::parse($member->tgl_expired)->startOfDay() : null;
        
        // Tentukan status berdasarkan tgl_expired dan status di database
        if ($member->status == 'active' && $expired && $expired >= $today) {
            $sisaHari = $today->diffInDays($expired);
            $status = $sisaHari <= 7 ? 'Akan Expired' : 'Aktif';
            $isActive = true;
            $statusClass = $sisaHari <= 7 ? 'bg-yellow-100 text-yellow-700 border-yellow-200' : 'bg-green-100 text-green-700 border-green-200';
            $statusIcon = $sisaHari <= 7 ? 'fa-exclamation-triangle' : 'fa-check-circle';
        } else {
            $sisaHari = $expired ? $today->diffInDays($expired, false) : 0;
            $status = 'Expired';
            $isActive = false;
            $statusClass = 'bg-red-100 text-red-700 border-red-200';
            $statusIcon = 'fa-times-circle';
        }
        
        return [
            'id' => $member->id,
            'kode' => $member->kode_member,
            'nama' => $member->nama,
            'telepon' => $member->telepon ?? '-',
            'paket' => $member->package ? $member->package->nama_paket : '-',
            'tgl_daftar' => $member->tgl_daftar ? $member->tgl_daftar->format('d/m/Y') : '-',
            'tgl_expired' => $member->tgl_expired ? $member->tgl_expired->format('d/m/Y') : '-',
            'status' => $status,
            'status_db' => $member->status, // Untuk debugging
            'sisa_hari' => $sisaHari,
            'sisa_hari_abs' => abs($sisaHari),
            'is_active' => $isActive,
            'status_class' => $statusClass,
            'status_icon' => $statusIcon,
            'jenis_member' => $member->jenis_member ?? 'Regular',
        ];
    });

    return response()->json($result);
}

    /**
     * Mendapatkan daftar paket membership untuk form perpanjangan
     */
    public function getPackages()
    {
        try {
            $packages = MembershipPackage::where('status', true)
                ->orderBy('nama_paket')
                ->get(['id', 'nama_paket', 'durasi_hari', 'harga']);
                
            \Log::info('Mengambil packages: ' . $packages->count() . ' paket ditemukan');
            
            return response()->json($packages);
        } catch (\Exception $e) {
            \Log::error('Error fetching packages: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Proses perpanjangan member (menuju transaksi baru)
     */
    public function perpanjang(Request $request, $id)
    {
        $request->validate([
            'id_paket' => 'required|exists:membership_packages,id',
        ]);

        DB::beginTransaction();
        try {
            $member = Member::findOrFail($id);
            $package = MembershipPackage::findOrFail($request->id_paket);
            
            // Hitung tanggal expired baru
            $tglExpiredBaru = now()->addDays($package->durasi_hari);
            
            // Update member
            $member->update([
                'id_paket' => $request->id_paket,
                'tgl_daftar' => now(),
                'tgl_expired' => $tglExpiredBaru,
                'status' => 'active',
            ]);

            // Catat log
            Log::create([
                'id_user' => auth()->id(),
                'role_user' => auth()->user()->role,
                'activity' => 'Renew Member',
                'keterangan' => 'Kasir memperpanjang member: ' . $member->nama . ' (' . $member->kode_member . ') dengan paket ' . $package->nama_paket,
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Member berhasil diperpanjang hingga ' . $tglExpiredBaru->format('d/m/Y'),
                'member' => [
                    'id' => $member->id,
                    'kode' => $member->kode_member,
                    'nama' => $member->nama,
                    'expired' => $tglExpiredBaru->format('d/m/Y'),
                ]
            ]);
                
        } catch (\Exception $e) {
            DB::rollback();
            
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Proses pendaftaran member baru (transaksi baru)
     * Ini akan mengarahkan ke halaman transaksi baru dengan data member
     */
    public function daftarBaru(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'telepon' => 'nullable|string|max:20',
            'id_paket' => 'required|exists:membership_packages,id',
        ]);

        DB::beginTransaction();
        try {
            $package = MembershipPackage::findOrFail($request->id_paket);
            
            // Hitung tanggal expired
            $tglExpired = now()->addDays($package->durasi_hari);
            
            // Buat member baru
            $member = Member::create([
                'nama' => $request->nama,
                'telepon' => $request->telepon,
                'alamat' => $request->alamat ?? null,
                'jenis_member' => $request->jenis_member ?? 'Regular',
                'id_paket' => $request->id_paket,
                'tgl_daftar' => now(),
                'tgl_expired' => $tglExpired,
                'status' => 'active',
                'created_by' => auth()->id(),
            ]);

            // Catat log
            Log::create([
                'id_user' => auth()->id(),
                'role_user' => auth()->user()->role,
                'activity' => 'Register New Member',
                'keterangan' => 'Kasir mendaftarkan member baru: ' . $member->nama . ' (' . $member->kode_member . ')',
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Member berhasil didaftarkan',
                'member' => [
                    'id' => $member->id,
                    'kode' => $member->kode_member,
                    'nama' => $member->nama,
                    'expired' => $tglExpired->format('d/m/Y'),
                ]
            ]);
                
        } catch (\Exception $e) {
            DB::rollback();
            
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }
}