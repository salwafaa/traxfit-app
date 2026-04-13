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
use PDF;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\TransactionExport;
use App\Exports\StockExport;
use App\Exports\ActivityExport;
use App\Exports\MemberExport;

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
        
        // CEK APAKAH EXPORT
        if ($request->has('export')) {
            $allTransactions = $query->get();
            
            if ($request->export == 'pdf') {
                return $this->exportTransaksiPDF($allTransactions, $request);
            } elseif ($request->export == 'excel') {
                return $this->exportTransaksiExcel($allTransactions, $request);
            }
        }
        
        $transactions = $query->paginate(15)->withQueryString();
        
        // Statistik
        $totalTransaksi = $query->count();
        $totalPendapatan = $query->sum('total_harga');
        $totalPendapatanTunai = (clone $query)->where('metode_bayar', 'cash')->sum('total_harga');
        $totalPendapatanNonTunai = (clone $query)->where('metode_bayar', 'qris')->sum('total_harga');
        
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
     * Export Transaksi ke PDF
     */
    private function exportTransaksiPDF($transactions, $request)
    {
        $data = [
            'transactions' => $transactions,
            'title' => 'LAPORAN TRANSAKSI',
            'date' => Carbon::now()->format('d F Y H:i:s'),
            'periode' => $this->getPeriodeText($request),
            'totalTransaksi' => $transactions->count(),
            'totalPendapatan' => $transactions->sum('total_harga'),
            'totalPendapatanTunai' => $transactions->where('metode_bayar', 'cash')->sum('total_harga'),
            'totalPendapatanNonTunai' => $transactions->where('metode_bayar', 'qris')->sum('total_harga'),
        ];
        
        $pdf = PDF::loadView('owner.laporan.transaksi-pdf', $data);
        $pdf->setPaper('A4', 'landscape');
        
        return $pdf->download('laporan_transaksi_' . Carbon::now()->format('Ymd_His') . '.pdf');
    }
    
    /**
     * Export Transaksi ke Excel
     */
    private function exportTransaksiExcel($transactions, $request)
    {
        $filterInfo = $this->getPeriodeText($request);
        return Excel::download(
            new TransactionExport($transactions, $filterInfo),
            'laporan_transaksi_' . Carbon::now()->format('Ymd_His') . '.xlsx'
        );
    }
    
    /**
     * Get text description of period filter
     */
    private function getPeriodeText($request)
    {
        if ($request->filled('start_date') && $request->filled('end_date')) {
            return Carbon::parse($request->start_date)->format('d/m/Y') . ' - ' . Carbon::parse($request->end_date)->format('d/m/Y');
        } elseif ($request->filled('period')) {
            switch ($request->period) {
                case 'today':
                    return 'Hari Ini (' . Carbon::now()->format('d/m/Y') . ')';
                case 'week':
                    return 'Minggu Ini (' . Carbon::now()->startOfWeek()->format('d/m/Y') . ' - ' . Carbon::now()->endOfWeek()->format('d/m/Y') . ')';
                case 'month':
                    return 'Bulan ' . Carbon::now()->format('F Y');
                case 'year':
                    return 'Tahun ' . Carbon::now()->format('Y');
                default:
                    return 'Semua Periode';
            }
        }
        return 'Semua Periode';
    }
    
    /**
     * Detail Transaksi untuk Owner
     */
    public function transaksiShow($id)
    {
        $transaction = Transaction::with(['user', 'member', 'details.product.category'])
            ->findOrFail($id);
        
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
        
        // CEK APAKAH EXPORT STOK
        if ($request->has('export')) {
            $allProducts = $query->orderBy('stok', 'asc')->get();
            
            if ($request->export == 'pdf') {
                return $this->exportStokPDF($allProducts, $request);
            } elseif ($request->export == 'excel') {
                return $this->exportStokExcel($allProducts, $request);
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
     * Export Stok ke PDF
     */
    private function exportStokPDF($products, $request)
    {
        // Hitung statistik untuk PDF
        $totalProduk = $products->count();
        $totalStok = $products->sum('stok');
        $totalNilaiStok = $products->sum(function($product) {
            return $product->stok * $product->harga;
        });
        $produkHampirHabis = $products->where('stok', '<=', 5)->where('stok', '>', 0)->count();
        $produkHabis = $products->where('stok', 0)->count();
        
        $data = [
            'products' => $products,
            'title' => 'LAPORAN STOK PRODUK',
            'date' => Carbon::now()->format('d F Y H:i:s'),
            'filterText' => $this->getStokFilterText($request),
            'totalProduk' => $totalProduk,
            'totalStok' => $totalStok,
            'totalNilaiStok' => $totalNilaiStok,
            'produkHampirHabis' => $produkHampirHabis,
            'produkHabis' => $produkHabis,
            'produkTersedia' => $products->where('stok', '>', 5)->count(),
        ];
        
        $pdf = PDF::loadView('owner.laporan.stok-pdf', $data);
        $pdf->setPaper('A4', 'landscape');
        
        return $pdf->download('laporan_stok_' . Carbon::now()->format('Ymd_His') . '.pdf');
    }
    
    /**
     * Export Stok ke Excel
     */
    private function exportStokExcel($products, $request)
    {
        return Excel::download(new StockExport($products), 'laporan_stok_' . Carbon::now()->format('Ymd_His') . '.xlsx');
    }
    
    /**
     * Get text description of stock filter
     */
    private function getStokFilterText($request)
    {
        $filters = [];
        
        if ($request->filled('category')) {
            $category = ProductCategory::find($request->category);
            $filters[] = 'Kategori: ' . ($category->nama_kategori ?? 'Semua');
        }
        
        if ($request->filled('stock_status')) {
            $statusMap = [
                'available' => 'Stok Tersedia (>5)',
                'low' => 'Stok Menipis (1-5)',
                'out' => 'Stok Habis (0)'
            ];
            $filters[] = $statusMap[$request->stock_status] ?? 'Semua Stok';
        }
        
        if ($request->filled('product_status')) {
            $statusMap = [
                'active' => 'Produk Aktif',
                'inactive' => 'Produk Non-Aktif'
            ];
            $filters[] = $statusMap[$request->product_status] ?? 'Semua Produk';
        }
        
        return empty($filters) ? 'Semua Data' : implode(' | ', $filters);
    }
    
    /**
     * Laporan Aktivitas
     */
    public function aktivitas(Request $request)
    {
        $startDate = $request->filled('start_date') 
            ? Carbon::parse($request->start_date)->startOfDay() 
            : Carbon::now()->subDays(30)->startOfDay();
            
        $endDate = $request->filled('end_date') 
            ? Carbon::parse($request->end_date)->endOfDay() 
            : Carbon::now()->endOfDay();

        $query = Log::with('user')
            ->whereBetween('created_at', [$startDate, $endDate]);

        if ($request->filled('role')) {
            $query->where('role_user', $request->role);
        }

        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('activity', 'like', '%' . $request->search . '%')
                  ->orWhere('keterangan', 'like', '%' . $request->search . '%');
            });
        }

        // CEK APAKAH EXPORT AKTIVITAS
        if ($request->has('export')) {
            $allLogs = $query->latest()->get();
            
            if ($request->export == 'pdf') {
                return $this->exportAktivitasPDF($allLogs, $request, $startDate, $endDate);
            } elseif ($request->export == 'excel') {
                return $this->exportAktivitasExcel($allLogs, $request);
            }
        }

        $logs = $query->latest()->paginate(50)->withQueryString();

        $userStats = User::whereIn('role', ['admin', 'kasir', 'owner'])
            ->withCount(['logs' => function($q) use ($startDate, $endDate) {
                $q->whereBetween('created_at', [$startDate, $endDate]);
            }])
            ->with(['logs' => function($q) use ($startDate, $endDate) {
                $q->whereBetween('created_at', [$startDate, $endDate])
                  ->select('id_user', 'activity', DB::raw('count(*) as total'))
                  ->groupBy('id_user', 'activity');
            }])
            ->get();

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

        $recentActivities = Log::with('user')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->latest()
            ->limit(50)
            ->get();

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
     * Export Aktivitas ke PDF
     */
    private function exportAktivitasPDF($logs, $request, $startDate, $endDate)
    {
        // Hitung statistik untuk PDF
        $totalLogs = $logs->count();
        $totalLogin = $logs->where('activity', 'Login')->count();
        $totalLogout = $logs->where('activity', 'Logout')->count();
        $totalCreate = $logs->filter(function($log) {
            return str_contains($log->activity, 'Create');
        })->count();
        $totalUpdate = $logs->filter(function($log) {
            return str_contains($log->activity, 'Update');
        })->count();
        $totalDelete = $logs->filter(function($log) {
            return str_contains($log->activity, 'Delete');
        })->count();
        $totalView = $logs->filter(function($log) {
            return str_contains($log->activity, 'View');
        })->count();
        
        // Statistik per user
        $userStats = $logs->groupBy('user.nama')->map(function($group) {
            return [
                'nama' => $group->first()->user->nama ?? 'Unknown',
                'role' => $group->first()->role_user ?? '-',
                'total' => $group->count()
            ];
        })->sortByDesc('total')->take(10);
        
        $data = [
            'logs' => $logs,
            'title' => 'LAPORAN AKTIVITAS USER',
            'date' => Carbon::now()->format('d F Y H:i:s'),
            'periode' => $startDate->format('d/m/Y') . ' - ' . $endDate->format('d/m/Y'),
            'filterText' => $this->getAktivitasFilterText($request),
            'totalLogs' => $totalLogs,
            'totalLogin' => $totalLogin,
            'totalLogout' => $totalLogout,
            'totalCreate' => $totalCreate,
            'totalUpdate' => $totalUpdate,
            'totalDelete' => $totalDelete,
            'totalView' => $totalView,
            'userStats' => $userStats,
        ];
        
        $pdf = PDF::loadView('owner.laporan.aktivitas-pdf', $data);
        $pdf->setPaper('A4', 'landscape');
        
        return $pdf->download('laporan_aktivitas_' . Carbon::now()->format('Ymd_His') . '.pdf');
    }
    
    /**
     * Export Aktivitas ke Excel
     */
    private function exportAktivitasExcel($logs, $request)
    {
        return Excel::download(new ActivityExport($logs), 'laporan_aktivitas_' . Carbon::now()->format('Ymd_His') . '.xlsx');
    }
    
    /**
     * Get text description of activity filter
     */
    private function getAktivitasFilterText($request)
    {
        $filters = [];
        
        if ($request->filled('role')) {
            $roleMap = [
                'admin' => 'Admin',
                'kasir' => 'Kasir',
                'owner' => 'Owner'
            ];
            $filters[] = 'Role: ' . ($roleMap[$request->role] ?? $request->role);
        }
        
        if ($request->filled('search')) {
            $filters[] = 'Pencarian: "' . $request->search . '"';
        }
        
        return empty($filters) ? 'Semua Data' : implode(' | ', $filters);
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
        
        // Filter berdasarkan status
        if ($request->filled('status')) {
            if ($request->status == 'active') {
                $query->where('status', 'active')
                      ->where('tgl_expired', '>=', Carbon::now()->format('Y-m-d'));
            } elseif ($request->status == 'expired') {
                $query->where(function($q) {
                    $q->where('status', 'expired')
                      ->orWhere('tgl_expired', '<', Carbon::now()->format('Y-m-d'));
                });
            } elseif ($request->status == 'pending') {
                $query->where('status', 'pending');
            }
        } else {
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
        
        // CEK APAKAH EXPORT MEMBER
        if ($request->has('export')) {
            $allMembers = $query->orderBy('created_at', 'desc')->get();
            
            // Hitung statistik tambahan untuk export
            $exportStats = [
                'totalMember' => $allMembers->count(),
                'memberAktif' => $allMembers->filter(function($member) {
                    return $member->status == 'active' && $member->tgl_expired >= Carbon::now()->format('Y-m-d');
                })->count(),
                'memberExpired' => $allMembers->filter(function($member) {
                    return $member->status == 'expired' || $member->tgl_expired < Carbon::now()->format('Y-m-d');
                })->count(),
                'memberPending' => $allMembers->where('status', 'pending')->count(),
                'expiringSoon' => $allMembers->filter(function($member) {
                    return $member->status == 'active' && 
                           $member->tgl_expired >= Carbon::now()->format('Y-m-d') && 
                           $member->tgl_expired <= Carbon::now()->addDays(7)->format('Y-m-d');
                })->count(),
                'totalCheckins' => $allMembers->sum('checkins_count'),
            ];
            
            if ($request->export == 'pdf') {
                return $this->exportMemberPDF($allMembers, $request, $exportStats);
            } elseif ($request->export == 'excel') {
                return $this->exportMemberExcel($allMembers, $request);
            }
        }
        
        $members = $query->orderBy('created_at', 'desc')->paginate(15)->withQueryString();
        
        // Statistik untuk view
        $totalMember = Member::count();
        $memberAktif = Member::where('status', 'active')
            ->where('tgl_expired', '>=', Carbon::now()->format('Y-m-d'))
            ->count();
        $memberExpired = Member::where(function($q) {
            $q->where('status', 'expired')
              ->orWhere('tgl_expired', '<', Carbon::now()->format('Y-m-d'));
        })->count();
        $memberPending = Member::where('status', 'pending')->count();
        
        $topCheckins = Member::withCount(['checkins' => function($q) {
                $q->whereMonth('created_at', Carbon::now()->month)
                  ->whereYear('created_at', Carbon::now()->year);
            }])
            ->having('checkins_count', '>', 0)
            ->orderBy('checkins_count', 'desc')
            ->limit(10)
            ->get();
        
        $expiringSoon = Member::where('status', 'active')
            ->where('tgl_expired', '>=', Carbon::now()->format('Y-m-d'))
            ->where('tgl_expired', '<=', Carbon::now()->addDays(7)->format('Y-m-d'))
            ->count();
        
        $packages = MembershipPackage::all();
        
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
    
    /**
     * Export Member ke PDF
     */
    private function exportMemberPDF($members, $request, $stats)
    {
        $data = [
            'members' => $members,
            'title' => 'LAPORAN MEMBER GYM',
            'date' => Carbon::now()->format('d F Y H:i:s'),
            'filterText' => $this->getMemberFilterText($request),
            'totalMember' => $stats['totalMember'],
            'memberAktif' => $stats['memberAktif'],
            'memberExpired' => $stats['memberExpired'],
            'memberPending' => $stats['memberPending'],
            'expiringSoon' => $stats['expiringSoon'],
            'totalCheckins' => $stats['totalCheckins'],
            'avgCheckins' => $stats['totalMember'] > 0 ? round($stats['totalCheckins'] / $stats['totalMember'], 1) : 0,
            'activePercentage' => $stats['totalMember'] > 0 ? round(($stats['memberAktif'] / $stats['totalMember']) * 100, 1) : 0,
        ];
        
        $pdf = PDF::loadView('owner.laporan.member-pdf', $data);
        $pdf->setPaper('A4', 'landscape');
        
        return $pdf->download('laporan_member_' . Carbon::now()->format('Ymd_His') . '.pdf');
    }
    
    /**
     * Export Member ke Excel
     */
    private function exportMemberExcel($members, $request)
    {
        return Excel::download(new MemberExport($members), 'laporan_member_' . Carbon::now()->format('Ymd_His') . '.xlsx');
    }
    
    /**
     * Get text description of member filter
     */
    private function getMemberFilterText($request)
    {
        $filters = [];
        
        if ($request->filled('status')) {
            $statusMap = [
                'active' => 'Member Aktif',
                'expired' => 'Member Expired',
                'pending' => 'Member Pending'
            ];
            $filters[] = 'Status: ' . ($statusMap[$request->status] ?? $request->status);
        }
        
        if ($request->filled('package')) {
            $package = MembershipPackage::find($request->package);
            $filters[] = 'Paket: ' . ($package->nama_paket ?? 'Semua Paket');
        }
        
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $filters[] = 'Periode Daftar: ' . Carbon::parse($request->start_date)->format('d/m/Y') . ' - ' . Carbon::parse($request->end_date)->format('d/m/Y');
        }
        
        return empty($filters) ? 'Semua Data' : implode(' | ', $filters);
    }
}