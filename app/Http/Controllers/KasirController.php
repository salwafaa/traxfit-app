<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\MemberCheckin;
use App\Models\Log;
use Illuminate\Http\Request;

class KasirController extends Controller
{
    public function dashboard()
    {
        $today = now()->format('Y-m-d');
        
        $stats = [
            'today_transactions' => Transaction::where('id_user', auth()->id())
                ->whereDate('created_at', $today)
                ->count(),
                
            'today_revenue' => Transaction::where('id_user', auth()->id())
                ->whereDate('created_at', $today)
                ->sum('total_harga'),
                
            'today_checkins' => MemberCheckin::where('id_kasir', auth()->id())
                ->whereDate('tanggal', $today)
                ->count(),
                
            'total_transactions' => Transaction::where('id_user', auth()->id())
                ->count(),
                
            'total_revenue' => Transaction::where('id_user', auth()->id())
                ->sum('total_harga'),
        ];
        
        $todayTransactions = Transaction::with('member')
            ->where('id_user', auth()->id())
            ->whereDate('created_at', $today)
            ->latest()
            ->take(5)
            ->get();
            
        $todayCheckins = MemberCheckin::with('member')
            ->where('id_kasir', auth()->id())
            ->whereDate('tanggal', $today)
            ->latest()
            ->take(5)
            ->get();

        try {
            Log::create([
                'id_user' => auth()->id(),
                'role_user' => auth()->user()->role,
                'activity' => 'View Dashboard',
                'keterangan' => 'Kasir melihat dashboard dengan ' . $stats['today_transactions'] . ' transaksi hari ini',
            ]);
        } catch (\Exception $e) {
            \Log::error('Gagal menyimpan log: ' . $e->getMessage());
        }

        return view('kasir.dashboard', compact('stats', 'todayTransactions', 'todayCheckins'));
    }
}