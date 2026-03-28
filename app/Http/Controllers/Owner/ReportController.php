<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use App\Models\Product;
use App\Models\StokLog;
use App\Models\User;
use App\Models\Member;
use App\Models\Log;
use App\Models\MemberCheckin;
use App\Models\MembershipPackage;
use App\Models\ProductCategory;
use App\Models\GymSetting;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ReportController extends Controller
{
    /**
     * Laporan Transaksi
     */
    public function transaksi(Request $request)
    {
        $query = Transaction::with(['user', 'member', 'details.product'])
            ->orderBy('created_at', 'desc');
        
        // Filter berdasarkan tanggal
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $start = Carbon::parse($request->start_date)->startOfDay();
            $end = Carbon::parse($request->end_date)->endOfDay();
            $query->whereBetween('created_at', [$start, $end]);
        } elseif ($request->filled('period')) {
            switch ($request->period) {
                case 'today':
                    $query->whereDate('created_at', Carbon::today());
                    break;
                case 'week':
                    $query->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]);
                    break;
                case 'month':
                    $query->whereMonth('created_at', Carbon::now()->month)
                          ->whereYear('created_at', Carbon::now()->year);
                    break;
                case 'year':
                    $query->whereYear('created_at', Carbon::now()->year);
                    break;
            }
        }
        
        // Filter berdasarkan metode pembayaran
        if ($request->filled('payment_method')) {
            $query->where('metode_bayar', $request->payment_method);
        }
        
        $transactions = $query->paginate(15)->withQueryString();
        
        // Statistik
        $totalTransaksi = Transaction::count();
        $totalPendapatan = Transaction::sum('total_harga');
        $totalPendapatanTunai = Transaction::where('metode_bayar', 'cash')->sum('total_harga');
        $totalPendapatanNonTunai = Transaction::where('metode_bayar', 'qris')->sum('total_harga');
        
        $rataRataTransaksi = $totalTransaksi > 0 ? $totalPendapatan / $totalTransaksi : 0;
        
        return view('owner.laporan.transaksi', compact(
            'transactions', 
            'totalTransaksi', 
            'totalPendapatan',
            'totalPendapatanTunai',
            'totalPendapatanNonTunai',
            'rataRataTransaksi'
        ));
    }
    
    /**
     * Detail Transaksi untuk Owner
     */
    public function transaksiShow($id)
    {
        $transaction = Transaction::with(['user', 'member', 'details.product.category'])
            ->findOrFail($id);
        
        // LOG: Owner melihat detail transaksi
        try {
            Log::create([
                'id_user' => auth()->id(),
                'role_user' => auth()->user()->role,
                'activity' => 'View Transaction Detail',
                'keterangan' => 'Owner melihat detail transaksi: ' . $transaction->nomor_unik,
            ]);
        } catch (\Exception $e) {
            \Log::error('Gagal menyimpan log: ' . $e->getMessage());
        }
        
        return view('owner.laporan.transaksi-show', compact('transaction'));
    }
    
    /**
     * Cetak Struk Transaksi untuk Owner
     */
    public function transaksiStruk($id)
    {
        $transaction = Transaction::with(['user', 'member', 'details.product'])
            ->findOrFail($id);
            
        $gymSettings = GymSetting::first();
        
        return view('owner.laporan.transaksi-struk', compact('transaction', 'gymSettings'));
    }
    
    /**
     * Laporan Stok
     */
    public function stok(Request $request)
    {
        $query = Product::with(['category', 'stockLogs' => function($q) {
                $q->latest()->limit(5);
            }])
            ->withCount('stockLogs');
        
        // Filter berdasarkan kategori
        if ($request->filled('category')) {
            $query->where('kategori', $request->category);
        }
        
        // Filter stok menipis
        if ($request->filled('stock_status')) {
            if ($request->stock_status == 'low') {
                $query->where('stok', '<=', 5)->where('stok', '>', 0);
            } elseif ($request->stock_status == 'out') {
                $query->where('stok', 0);
            } elseif ($request->stock_status == 'available') {
                $query->where('stok', '>', 5);
            }
        }
        
        // Filter status produk
        if ($request->filled('product_status')) {
            if ($request->product_status == 'active') {
                $query->where('status', true);
            } elseif ($request->product_status == 'inactive') {
                $query->where('status', false);
            }
        }
        
        $products = $query->orderBy('stok', 'asc')->paginate(15)->withQueryString();
        
        // Statistik stok
        $totalProduk = Product::count();
        $totalStok = Product::sum('stok');
        $totalNilaiStok = Product::sum(DB::raw('stok * harga'));
        $produkHampirHabis = Product::where('stok', '<=', 5)->where('stok', '>', 0)->count();
        $produkHabis = Product::where('stok', 0)->count();
        
        // Kategori untuk filter
        $categories = ProductCategory::all();
        
        // Membership packages
        $membershipPackages = MembershipPackage::all();
        
        // Riwayat stok terbaru
        $recentStockLogs = StokLog::with(['user', 'product'])
            ->latest()
            ->limit(20)
            ->get();
        
        return view('owner.laporan.stok', compact(
            'products',
            'totalProduk',
            'totalStok',
            'totalNilaiStok',
            'produkHampirHabis',
            'produkHabis',
            'recentStockLogs',
            'categories',
            'membershipPackages'
        ));
    }
    
    /**
     * Laporan Aktivitas
     */
    public function aktivitas(Request $request)
    {
        // Default periode: 30 hari terakhir
        $startDate = $request->filled('start_date') 
            ? Carbon::parse($request->start_date)->startOfDay() 
            : Carbon::now()->subDays(30)->startOfDay();
            
        $endDate = $request->filled('end_date') 
            ? Carbon::parse($request->end_date)->endOfDay() 
            : Carbon::now()->endOfDay();

        // Query log dengan filter
        $query = Log::with('user')
            ->whereBetween('created_at', [$startDate, $endDate]);

        // Filter berdasarkan role
        if ($request->filled('role')) {
            $query->where('role_user', $request->role);
        }

        // Filter berdasarkan aktivitas (search)
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('activity', 'like', '%' . $request->search . '%')
                  ->orWhere('keterangan', 'like', '%' . $request->search . '%');
            });
        }

        // Urutkan terbaru
        $logs = $query->latest()->paginate(50)->withQueryString();

        // Statistik per user
        $userStats = User::whereIn('role', ['admin', 'kasir'])
            ->withCount(['logs' => function($q) use ($startDate, $endDate) {
                $q->whereBetween('created_at', [$startDate, $endDate]);
            }])
            ->with(['logs' => function($q) use ($startDate, $endDate) {
                $q->whereBetween('created_at', [$startDate, $endDate])
                  ->select('id_user', 'activity', DB::raw('count(*) as total'))
                  ->groupBy('id_user', 'activity');
            }])
            ->get();

        // Ringkasan aktivitas
        $summary = [
            'total_logs' => Log::whereBetween('created_at', [$startDate, $endDate])->count(),
            'total_login' => Log::whereBetween('created_at', [$startDate, $endDate])
                ->where('activity', 'Login')->count(),
            'total_logout' => Log::whereBetween('created_at', [$startDate, $endDate])
                ->where('activity', 'Logout')->count(),
            'total_create' => Log::whereBetween('created_at', [$startDate, $endDate])
                ->where('activity', 'like', 'Create%')->count(),
            'total_update' => Log::whereBetween('created_at', [$startDate, $endDate])
                ->where('activity', 'like', 'Update%')->count(),
            'total_delete' => Log::whereBetween('created_at', [$startDate, $endDate])
                ->where('activity', 'like', 'Delete%')->count(),
            'total_view' => Log::whereBetween('created_at', [$startDate, $endDate])
                ->where('activity', 'like', 'View%')->count(),
        ];

        // Aktivitas terbaru (untuk ditampilkan di bawah)
        $recentActivities = Log::with('user')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->latest()
            ->limit(50)
            ->get();

        // LOG: Owner melihat laporan aktivitas
        try {
            Log::create([
                'id_user' => auth()->id(),
                'role_user' => auth()->user()->role,
                'activity' => 'View Activity Report',
                'keterangan' => 'Owner melihat laporan aktivitas user periode ' . $startDate->format('d/m/Y') . ' - ' . $endDate->format('d/m/Y'),
            ]);
        } catch (\Exception $e) {
            \Log::error('Gagal menyimpan log: ' . $e->getMessage());
        }

        return view('owner.laporan.aktivitas', compact(
            'logs',
            'userStats',
            'summary',
            'recentActivities',
            'startDate',
            'endDate'
        ));
    }
    
    /**
     * Laporan Member Aktif
     */
    public function member(Request $request)
    {
        $query = Member::with(['package', 'checkins' => function($q) {
                $q->latest();
            }])
            ->withCount('checkins');
        
        // Filter berdasarkan status member
        if ($request->filled('status')) {
            if ($request->status == 'active') {
                $query->where('status', 'active')
                      ->where('tgl_expired', '>=', Carbon::now()->format('Y-m-d'));
            } elseif ($request->status == 'expired') {
                $query->where('status', 'expired')
                      ->orWhere('tgl_expired', '<', Carbon::now()->format('Y-m-d'));
            } elseif ($request->status == 'pending') {
                $query->where('status', 'pending');
            }
        } else {
            // Default: tampilkan member aktif
            $query->where('status', 'active')
                  ->where('tgl_expired', '>=', Carbon::now()->format('Y-m-d'));
        }
        
        // Filter berdasarkan paket
        if ($request->filled('package')) {
            $query->where('id_paket', $request->package);
        }
        
        // Filter berdasarkan tanggal daftar
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $start = Carbon::parse($request->start_date)->startOfDay();
            $end = Carbon::parse($request->end_date)->endOfDay();
            $query->whereBetween('tgl_daftar', [$start, $end]);
        }
        
        $members = $query->orderBy('created_at', 'desc')->paginate(15)->withQueryString();
        
        // Paket untuk filter
        $packages = MembershipPackage::all();
        
        // Statistik member
        $totalMember = Member::count();
        $memberAktif = Member::where('status', 'active')
            ->where('tgl_expired', '>=', Carbon::now()->format('Y-m-d'))
            ->count();
        $memberExpired = Member::where('status', 'expired')
            ->orWhere('tgl_expired', '<', Carbon::now()->format('Y-m-d'))
            ->count();
        $memberPending = Member::where('status', 'pending')->count();
        
        // Member dengan check-in terbanyak bulan ini
        $topCheckins = Member::withCount(['checkins' => function($q) {
                $q->whereMonth('created_at', Carbon::now()->month)
                  ->whereYear('created_at', Carbon::now()->year);
            }])
            ->having('checkins_count', '>', 0)
            ->orderBy('checkins_count', 'desc')
            ->limit(10)
            ->get();
        
        // Member yang akan expired dalam 7 hari
        $expiringSoon = Member::where('status', 'active')
            ->where('tgl_expired', '>=', Carbon::now()->format('Y-m-d'))
            ->where('tgl_expired', '<=', Carbon::now()->addDays(7)->format('Y-m-d'))
            ->count();
        
        return view('owner.laporan.member', compact(
            'members',
            'totalMember',
            'memberAktif',
            'memberExpired',
            'memberPending',
            'topCheckins',
            'expiringSoon',
            'packages'
        ));
    }
}