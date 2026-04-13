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
    /**
     * Menampilkan halaman utama check-in dengan semua member
     */
    public function index()
    {
        $today = Carbon::today();

        // Ambil semua member dengan paketnya, diurutkan berdasarkan status (aktif dulu)
        $allMembers = Member::with('package')
            ->orderByRaw("CASE 
                WHEN status = 'active' AND tgl_expired >= NOW() THEN 1
                WHEN status = 'expired' OR tgl_expired < NOW() THEN 3
                ELSE 2
            END")
            ->orderBy('nama', 'asc')
            ->get();

        // Proses setiap member untuk menambah info tambahan
        $membersWithStatus = $allMembers->map(function ($member) use ($today) {
            $expired  = $member->tgl_expired ? Carbon::parse($member->tgl_expired)->startOfDay() : null;
            $isActive = $member->status === 'active' && $expired && $expired >= $today;

            // Hitung sisa hari
            if ($expired && $isActive) {
                $sisaHari     = $today->diffInDays($expired);
                $sisaHariText = $this->getSisaHariText($sisaHari);
            } elseif ($expired && !$isActive) {
                $sisaHari     = abs($today->diffInDays($expired, false));
                $sisaHariText = 'Expired ' . $sisaHari . ' hari yang lalu';
            } else {
                $sisaHari     = 0;
                $sisaHariText = '-';
            }

            // Cek apakah sudah check-in hari ini
            // sudahCheckinHariIni() sudah mencakup pengecekan transaksi hari ini
            $checkedInToday = MemberCheckin::sudahCheckinHariIni($member->id);

            // Cek apakah check-in hari ini via transaksi (untuk label badge)
            $checkinRecord = MemberCheckin::where('id_member', $member->id)
                ->whereDate('tanggal', $today)
                ->first();
            $viaTransaksi = $checkinRecord && $checkinRecord->via_transaksi;

            // Tentukan status untuk tampilan
            if (!$isActive) {
                $statusClass = 'expired';
                $statusBadge = 'danger';
                $statusIcon  = 'fa-times-circle';
                $statusText  = 'Expired';
            } elseif ($checkedInToday) {
                $statusClass = 'checked-in';
                $statusBadge = 'success';
                $statusIcon  = 'fa-check-circle';
                $statusText  = $viaTransaksi ? 'Check-in (Transaksi)' : 'Sudah Check-in';
            } elseif ($sisaHari <= 7) {
                $statusClass = 'almost-expired';
                $statusBadge = 'warning';
                $statusIcon  = 'fa-exclamation-triangle';
                $statusText  = 'Akan Expired';
            } else {
                $statusClass = 'active';
                $statusBadge = 'info';
                $statusIcon  = 'fa-clock';
                $statusText  = 'Aktif';
            }

            return [
                'id'              => $member->id,
                'kode_member'     => $member->kode_member,
                'nama'            => $member->nama,
                'telepon'         => $member->telepon ?? '-',
                'paket'           => $member->package ? $member->package->nama_paket : '-',
                'tgl_expired'     => $member->tgl_expired,
                'expired_formatted' => $member->tgl_expired ? $expired->format('d/m/Y') : '-',
                'sisa_hari'       => $sisaHari,
                'sisa_hari_text'  => $sisaHariText,
                'checked_in_today' => $checkedInToday,
                'via_transaksi'   => $viaTransaksi,
                'is_active'       => $isActive,
                'can_checkin'     => $isActive && !$checkedInToday,
                'status_class'    => $statusClass,
                'status_badge'    => $statusBadge,
                'status_icon'     => $statusIcon,
                'status_text'     => $statusText,
            ];
        });

        // Statistik
        $activeCount       = $membersWithStatus->filter(fn($m) => $m['is_active'] && !$m['checked_in_today'])->count();
        $checkedInCount    = $membersWithStatus->filter(fn($m) => $m['checked_in_today'])->count();
        $expiredCount      = $membersWithStatus->filter(fn($m) => !$m['is_active'])->count();
        $almostExpiredCount = $membersWithStatus->filter(fn($m) => $m['is_active'] && !$m['checked_in_today'] && $m['sisa_hari'] <= 7 && $m['sisa_hari'] > 0)->count();

        // Check-in hari ini untuk sidebar/ringkasan
        $todayCheckins = MemberCheckin::with(['member.package', 'kasir'])
            ->whereDate('tanggal', $today)
            ->latest('jam_masuk')
            ->get();

        return view('kasir.checkin.index', compact(
            'membersWithStatus',
            'todayCheckins',
            'activeCount',
            'checkedInCount',
            'expiredCount',
            'almostExpiredCount'
        ));
    }

    /**
     * API untuk mencari member (live search)
     */
    public function cariMember(Request $request)
    {
        $search = $request->input('search', '');

        if (empty($search) || strlen($search) < 2) {
            return response()->json([]);
        }

        $today = Carbon::today();

        $members = Member::with('package')
            ->where(function ($query) use ($search) {
                $query->where('nama', 'like', "%{$search}%")
                    ->orWhere('kode_member', 'like', "%{$search}%")
                    ->orWhere('telepon', 'like', "%{$search}%");
            })
            ->orderBy('nama')
            ->limit(20)
            ->get();

        $result = $members->map(function ($member) use ($today) {
            $expired        = $member->tgl_expired ? Carbon::parse($member->tgl_expired)->startOfDay() : null;
            $isActive       = $member->status === 'active' && $expired && $expired >= $today;
            $checkedInToday = MemberCheckin::sudahCheckinHariIni($member->id);

            return [
                'id'              => $member->id,
                'kode_member'     => $member->kode_member,
                'nama'            => $member->nama,
                'telepon'         => $member->telepon ?? '-',
                'paket'           => $member->package ? $member->package->nama_paket : '-',
                'expired_formatted' => $expired ? $expired->format('d/m/Y') : '-',
                'can_checkin'     => $isActive && !$checkedInToday,
                'checked_in_today' => $checkedInToday,
                'is_active'       => $isActive,
            ];
        });

        return response()->json($result);
    }

    /**
     * Proses check-in member (manual)
     */
    public function store(Request $request)
    {
        $request->validate([
            'member_id' => 'required|exists:members,id',
        ]);

        DB::beginTransaction();
        try {
            $member = Member::with('package')->findOrFail($request->member_id);
            $today  = Carbon::today();
            $now    = Carbon::now();

            // Cek apakah member aktif (belum expired)
            $expired = $member->tgl_expired ? Carbon::parse($member->tgl_expired)->startOfDay() : null;

            if (!$expired || $member->status !== 'active' || $expired->lt($today)) {
                DB::rollback();
                return response()->json([
                    'success' => false,
                    'message' => 'Member sudah expired. Silakan perpanjang membership terlebih dahulu.',
                ]);
            }

            // Cek apakah sudah check-in hari ini (termasuk via transaksi)
            if (MemberCheckin::sudahCheckinHariIni($member->id)) {
                DB::rollback();
                return response()->json([
                    'success' => false,
                    'message' => 'Member sudah melakukan check-in hari ini.',
                ]);
            }

            // Simpan check-in manual
            MemberCheckin::create([
                'id_member'     => $member->id,
                'tanggal'       => $now->toDateString(),
                'jam_masuk'     => $now,
                'id_kasir'      => auth()->id(),
                'via_transaksi' => false,
            ]);

            Log::create([
                'id_user'    => auth()->id(),
                'role_user'  => auth()->user()->role,
                'activity'   => 'Member Check-in',
                'keterangan' => 'Member ' . $member->nama . ' (' . $member->kode_member . ') check-in pada ' . $now->format('d/m/Y H:i:s'),
            ]);

            DB::commit();

            $sisaHari     = $today->diffInDays($expired);
            $sisaHariText = $sisaHari <= 7 ? $sisaHari . ' hari lagi (segera expired)' : $sisaHari . ' hari lagi';

            return response()->json([
                'success' => true,
                'message' => 'Check-in berhasil! Selamat berlatih! 💪',
                'checkin' => [
                    'id'          => $member->id,
                    'nama'        => $member->nama,
                    'kode_member' => $member->kode_member,
                    'waktu'       => $now->format('H:i:s'),
                    'tanggal'     => $now->format('d/m/Y'),
                    'paket'       => $member->package ? $member->package->nama_paket : '-',
                    'expired'     => $expired->format('d/m/Y'),
                    'sisa_hari'   => $sisaHariText,
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

    /**
     * Menampilkan riwayat check-in
     */
    public function riwayat(Request $request)
    {
        $applyFilters = function ($q) use ($request) {
            if ($request->filled('start_date')) {
                $q->whereDate('tanggal', '>=', $request->start_date);
            }
            if ($request->filled('end_date')) {
                $q->whereDate('tanggal', '<=', $request->end_date);
            }
            if ($request->filled('member')) {
                $q->where('id_member', $request->member);
            }
            return $q;
        };

        $query    = $applyFilters(MemberCheckin::with(['member.package', 'kasir']));
        $checkins = $query->latest('jam_masuk')->paginate(20)->withQueryString();

        $totalCheckins = $applyFilters(MemberCheckin::query())->count();
        $uniqueMembers = $applyFilters(MemberCheckin::query())->distinct('id_member')->count('id_member');
        $uniqueDays    = $applyFilters(MemberCheckin::query())
                            ->selectRaw('COUNT(DISTINCT DATE(tanggal)) as total')
                            ->value('total') ?? 0;
        $avgHarian     = $uniqueDays > 0 ? round($totalCheckins / $uniqueDays, 1) : 0;

        $members = Member::orderBy('nama')->get(['id', 'kode_member', 'nama']);

        try {
            $filterDesc = '';
            if ($request->filled('start_date') && $request->filled('end_date')) {
                $filterDesc = ' periode ' . $request->start_date . ' s/d ' . $request->end_date;
            }
            Log::create([
                'id_user'    => auth()->id(),
                'role_user'  => auth()->user()->role,
                'activity'   => 'View Check-in History',
                'keterangan' => 'Kasir melihat riwayat check-in' . $filterDesc,
            ]);
        } catch (\Exception $e) {
            \Log::error('Gagal menyimpan log: ' . $e->getMessage());
        }

        return view('kasir.checkin.riwayat', compact(
            'checkins',
            'members',
            'totalCheckins',
            'uniqueMembers',
            'avgHarian'
        ));
    }

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

        $checkins = $query->latest('jam_masuk')->get();

        $pdf = PDF::loadView('kasir.checkin.export_pdf', [
            'checkins'   => $checkins,
            'start_date' => $request->start_date,
            'end_date'   => $request->end_date,
        ]);

        return $pdf->download('riwayat_checkin_' . now()->format('Ymd_His') . '.pdf');
    }

    /**
     * Helper: Mendapatkan teks sisa hari
     */
    private function getSisaHariText($sisaHari)
    {
        if ($sisaHari <= 0) {
            return 'Expired';
        } elseif ($sisaHari <= 7) {
            return '⚠️ ' . $sisaHari . ' hari lagi (segera expired)';
        } else {
            return $sisaHari . ' hari lagi';
        }
    }
}