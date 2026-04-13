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
    public function index(Request $request)
    {
        $query = Transaction::with(['user', 'member']);

        if ($request->filled('start_date')) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }
        if ($request->filled('end_date')) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }

        if ($request->filled('id_user')) {
            $query->where('id_user', $request->id_user);
        }

        if ($request->filled('member_status')) {
            if ($request->member_status == 'member') {
                $query->whereNotNull('id_member');
            } elseif ($request->member_status == 'nonmember') {
                $query->whereNull('id_member');
            }
        }

        if ($request->filled('jenis_transaksi')) {
            $query->where('jenis_transaksi', $request->jenis_transaksi);
        }

        $transactions = $query->latest()->paginate(20);
        
        $totalPendapatan = Transaction::sum('total_harga');
        $totalHariIni = Transaction::whereDate('created_at', today())->sum('total_harga');
        $totalBulanIni = Transaction::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->sum('total_harga');
        $totalTahunIni = Transaction::whereYear('created_at', now()->year)->sum('total_harga');
        
        $totalTransaksi = Transaction::count();
        $totalMember = Transaction::whereNotNull('id_member')->count();
        $totalNonMember = Transaction::whereNull('id_member')->count();
        
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

    public function show($id)
    {
        $transaction = Transaction::with([
            'user', 
            'member', 
            'details.product.category'
        ])->findOrFail($id);
        
        return view('admin.transaksi.show', compact('transaction'));
    }

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