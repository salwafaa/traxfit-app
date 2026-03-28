<?php

namespace App\Http\Controllers\Kasir;

use App\Http\Controllers\Controller;
use App\Models\Member;
use App\Models\MemberCheckin;
use App\Models\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CheckinController extends Controller
{
public function index()
{
    $today = now()->startOfDay();
    
    // Ambil data check-in hari ini
    $todayCheckins = MemberCheckin::with(['member.package', 'kasir'])
        ->whereDate('tanggal', $today)
        ->latest()
        ->get();

    // Statistik - PASTIKAN QUERYNYA BENAR
    $activeMembersCount = Member::where('status', 'active')
        ->whereDate('tgl_expired', '>=', $today)
        ->count();
        
    $almostExpiredCount = Member::where('status', 'active')
        ->whereDate('tgl_expired', '>=', $today)
        ->whereDate('tgl_expired', '<=', $today->copy()->addDays(7))
        ->count();
        
    $expiredCount = Member::where('status', 'expired')
        ->orWhereDate('tgl_expired', '<', $today)
        ->count();

    // LOG untuk debugging
    \Log::info('Active Members Count: ' . $activeMembersCount);
    \Log::info('Almost Expired Count: ' . $almostExpiredCount);
    \Log::info('Expired Count: ' . $expiredCount);
        
    return view('kasir.checkin.index', compact(
        'todayCheckins', 
        'activeMembersCount', 
        'almostExpiredCount', 
        'expiredCount'
    ));
}

    public function cariMember(Request $request)
{
    $search = $request->input('search', '');
    
    if (empty($search) || strlen($search) < 2) {
        return response()->json([]);
    }
    
    \Log::info('Check-in Search: ' . $search); // Untuk debugging
    
    $today = now()->startOfDay();
    
    $members = Member::with('package')
        ->where('status', 'active') // Hanya status active
        ->whereDate('tgl_expired', '>=', $today) // Belum expired
        ->where(function($query) use ($search) {
            $query->where('nama', 'like', "%{$search}%")
                  ->orWhere('kode_member', 'like', "%{$search}%")
                  ->orWhere('telepon', 'like', "%{$search}%");
        })
        ->orderBy('nama')
        ->limit(20)
        ->get();
    
    \Log::info('Check-in Results: ' . $members->count()); // Untuk debugging
    
    if ($members->isEmpty()) {
        return response()->json([]);
    }
    
    $result = $members->map(function($member) use ($today) {
        $expired = Carbon::parse($member->tgl_expired)->startOfDay();
        $sisaHari = $today->diffInDays($expired);
        
        // Cek apakah sudah check-in hari ini
        $checkedIn = MemberCheckin::where('id_member', $member->id)
            ->whereDate('tanggal', $today)
            ->exists();
        
        return [
            'id' => $member->id,
            'kode' => $member->kode_member,
            'nama' => $member->nama,
            'telepon' => $member->telepon ?? '-',
            'paket' => $member->package ? $member->package->nama_paket : '-',
            'expired' => $member->tgl_expired->format('d/m/Y'),
            'sisa_hari' => $sisaHari,
            'checked_in' => $checkedIn,
            'status_class' => $checkedIn ? 'bg-yellow-100 text-yellow-700 border-yellow-200' : 'bg-green-100 text-green-700 border-green-200',
            'status_icon' => $checkedIn ? 'fa-check-circle' : 'fa-clock',
            'status_text' => $checkedIn ? 'Sudah Check-in' : 'Siap Check-in',
        ];
    });
    
    return response()->json($result);
}

    /**
     * Proses check-in member
     */
    public function store(Request $request)
    {
        $request->validate([
            'member_id' => 'required|exists:members,id',
        ]);

        DB::beginTransaction();
        try {
            $member = Member::findOrFail($request->member_id);
            $today = now()->startOfDay();
            
            // Cek apakah member aktif
            if (!$member->is_active) {
                return response()->json([
                    'success' => false,
                    'message' => 'Member tidak aktif. Silakan perpanjang membership terlebih dahulu.'
                ], 400);
            }

            // Cek apakah sudah check-in hari ini
            $alreadyCheckedIn = MemberCheckin::where('id_member', $member->id)
                ->whereDate('tanggal', $today)
                ->exists();
                
            if ($alreadyCheckedIn) {
                return response()->json([
                    'success' => false,
                    'message' => 'Member sudah melakukan check-in hari ini'
                ], 400);
            }

            // Simpan check-in
            $checkin = MemberCheckin::create([
                'id_member' => $member->id,
                'tanggal' => now(),
                'jam_masuk' => now(),
                'id_kasir' => auth()->id(),
            ]);

            // Log
            Log::create([
                'id_user' => auth()->id(),
                'role_user' => auth()->user()->role,
                'activity' => 'Member Check-in',
                'keterangan' => 'Member ' . $member->nama . ' (' . $member->kode_member . ') check-in pada ' . now()->format('d/m/Y H:i'),
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Check-in berhasil',
                'checkin' => [
                    'nama' => $member->nama,
                    'kode' => $member->kode_member,
                    'waktu' => now()->format('H:i'),
                    'paket' => $member->package ? $member->package->nama_paket : '-',
                    'expired' => $member->tgl_expired->format('d/m/Y'),
                    'sisa_hari' => $member->sisa_hari,
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
     * Menampilkan riwayat check-in
     */
    public function riwayat(Request $request)
    {
        $query = MemberCheckin::with(['member.package', 'kasir']);
        
        if ($request->filled('start_date')) {
            $query->whereDate('tanggal', '>=', $request->start_date);
        }
        
        if ($request->filled('end_date')) {
            $query->whereDate('tanggal', '<=', $request->end_date);
        }
        
        if ($request->filled('member')) {
            $query->where('id_member', $request->member);
        }
        
        $checkins = $query->latest()->paginate(20)->withQueryString();
        
        $members = Member::orderBy('nama')->get(['id', 'kode_member', 'nama']);

        // Log
        try {
            $filterDesc = '';
            if ($request->filled('start_date') && $request->filled('end_date')) {
                $filterDesc = ' periode ' . $request->start_date . ' s/d ' . $request->end_date;
            }
            
            Log::create([
                'id_user' => auth()->id(),
                'role_user' => auth()->user()->role,
                'activity' => 'View Check-in History',
                'keterangan' => 'Kasir melihat riwayat check-in' . $filterDesc,
            ]);
        } catch (\Exception $e) {
            \Log::error('Gagal menyimpan log: ' . $e->getMessage());
        }
        
        return view('kasir.checkin.riwayat', compact('checkins', 'members'));
    }

    /**
     * Ekspor riwayat check-in ke CSV
     */
    public function export(Request $request)
    {
        $query = MemberCheckin::with(['member.package', 'kasir']);
        
        if ($request->filled('start_date')) {
            $query->whereDate('tanggal', '>=', $request->start_date);
        }
        
        if ($request->filled('end_date')) {
            $query->whereDate('tanggal', '<=', $request->end_date);
        }
        
        if ($request->filled('member')) {
            $query->where('id_member', $request->member);
        }
        
        $checkins = $query->latest()->get();
        
        $filename = 'checkin_riwayat_' . now()->format('Ymd_His') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];
        
        $columns = ['Tanggal', 'Waktu', 'Member', 'Kode Member', 'Paket', 'Kasir'];
        
        $callback = function() use ($checkins, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);
            
            foreach ($checkins as $checkin) {
                fputcsv($file, [
                    $checkin->tanggal->format('d/m/Y'),
                    $checkin->jam_masuk->format('H:i'),
                    $checkin->member->nama ?? '-',
                    $checkin->member->kode_member ?? '-',
                    $checkin->member->package->nama_paket ?? '-',
                    $checkin->kasir->nama ?? '-',
                ]);
            }
            
            fclose($file);
        };
        
        return response()->stream($callback, 200, $headers);
    }
}