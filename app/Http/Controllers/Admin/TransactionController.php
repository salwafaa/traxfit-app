<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\Member;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;

class TransactionController extends Controller
{
    /**
     * Display a listing of all transactions (for admin)
     */
    public function index(Request $request)
    {
        $query = Transaction::with(['user', 'member']);

        // Filter by date
        if ($request->filled('start_date')) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }
        if ($request->filled('end_date')) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }

        // Filter by kasir
        if ($request->filled('id_user')) {
            $query->where('id_user', $request->id_user);
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
        
        // Stats for dashboard
        $totalPendapatan = Transaction::sum('total_harga');
        $totalHariIni = Transaction::whereDate('created_at', today())->sum('total_harga');
        $totalBulanIni = Transaction::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->sum('total_harga');
        $totalTahunIni = Transaction::whereYear('created_at', now()->year)->sum('total_harga');
        
        $totalTransaksi = Transaction::count();
        $totalMember = Transaction::whereNotNull('id_member')->count();
        $totalNonMember = Transaction::whereNull('id_member')->count();
        
        // Kasir list for filter
        $kasirs = User::where('role', 'kasir')->get();
        
        return view('admin.transaksi.index', compact(
            'transactions', 
            'totalPendapatan',
            'totalHariIni',
            'totalBulanIni',
            'totalTahunIni',
            'totalTransaksi',
            'totalMember',
            'totalNonMember',
            'kasirs'
        ));
    }

    /**
     * Display the specified transaction
     */
    public function show($id)
    {
        $transaction = Transaction::with([
            'user', 
            'member', 
            'details.product.category'
        ])->findOrFail($id);
        
        return view('admin.transaksi.show', compact('transaction'));
    }

    /**
     * Print receipt (admin can print any transaction)
     */
    public function struk($id)
    {
        $transaction = Transaction::with([
            'user', 
            'member', 
            'details.product'
        ])->findOrFail($id);
        
        $gymSettings = \App\Models\GymSetting::first();
        
        return view('admin.transaksi.struk', compact('transaction', 'gymSettings'));
    }

    /**
     * Export transactions data
     */
    public function export(Request $request)
    {
        $query = Transaction::with(['user', 'member']);

        // Apply filters
        if ($request->filled('start_date')) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }
        if ($request->filled('end_date')) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }
        if ($request->filled('jenis_transaksi')) {
            $query->where('jenis_transaksi', $request->jenis_transaksi);
        }

        $transactions = $query->latest()->get();
        
        // Log export activity
        \App\Models\Log::create([
            'id_user' => auth()->id(),
            'role_user' => auth()->user()->role,
            'activity' => 'Export Transactions',
            'keterangan' => 'Admin mengexport data transaksi',
        ]);

        // Generate CSV
        $filename = 'transactions_' . now()->format('Ymd_His') . '.csv';
        $handle = fopen('php://output', 'w');
        
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        
        // Header CSV
        fputcsv($handle, [
            'No', 'No. Transaksi', 'Tanggal', 'Kasir', 'Member', 
            'Jenis Transaksi', 'Total', 'Metode Bayar', 'Status'
        ]);
        
        foreach ($transactions as $index => $t) {
            $jenisLabels = [
                'produk' => 'Produk Only',
                'visit' => 'Visit Only',
                'membership' => 'Membership Only',
                'produk_visit' => 'Produk + Visit',
                'produk_membership' => 'Produk + Membership'
            ];
            
            fputcsv($handle, [
                $index + 1,
                $t->nomor_unik,
                $t->created_at->format('d/m/Y H:i'),
                $t->user->nama ?? '-',
                $t->member ? $t->member->nama : 'Non-Member',
                $jenisLabels[$t->jenis_transaksi] ?? $t->jenis_transaksi,
                'Rp ' . number_format($t->total_harga, 0, ',', '.'),
                ucfirst($t->metode_bayar),
                ucfirst($t->status_transaksi)
            ]);
        }
        
        fclose($handle);
        exit;
    }

    /**
     * Get transaction statistics for dashboard
     */
    public function statistics()
    {
        $now = now();
        
        $stats = [
            'hari_ini' => [
                'total' => Transaction::whereDate('created_at', today())->count(),
                'pendapatan' => Transaction::whereDate('created_at', today())->sum('total_harga'),
            ],
            'minggu_ini' => [
                'total' => Transaction::whereBetween('created_at', [
                    $now->copy()->startOfWeek(), 
                    $now->copy()->endOfWeek()
                ])->count(),
                'pendapatan' => Transaction::whereBetween('created_at', [
                    $now->copy()->startOfWeek(), 
                    $now->copy()->endOfWeek()
                ])->sum('total_harga'),
            ],
            'bulan_ini' => [
                'total' => Transaction::whereMonth('created_at', $now->month)
                    ->whereYear('created_at', $now->year)
                    ->count(),
                'pendapatan' => Transaction::whereMonth('created_at', $now->month)
                    ->whereYear('created_at', $now->year)
                    ->sum('total_harga'),
            ],
            'tahun_ini' => [
                'total' => Transaction::whereYear('created_at', $now->year)->count(),
                'pendapatan' => Transaction::whereYear('created_at', $now->year)->sum('total_harga'),
            ],
        ];
        
        return response()->json($stats);
    }
}