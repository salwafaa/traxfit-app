<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Member;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    /**
     * Display admin dashboard
     */
    public function dashboard()
    {
        // Hitung semua statistik
        $stats = [
            'total_users' => User::count(),
            'total_members' => Member::count(),
            'total_products' => Product::count(),
            'active_members' => Member::where('status', 'active')->count(),
            'expired_members' => Member::where('status', 'expired')->count(),
            'today_transactions' => Transaction::whereDate('created_at', today())->count(),
            'today_revenue' => Transaction::whereDate('created_at', today())->sum('total_harga'),
            'available_products' => Product::where('stok', '>', 0)->count(),
            'out_of_stock' => Product::where('stok', '<=', 0)->count(),
            'new_members' => Member::whereMonth('created_at', now()->month)->count(),
        ];

        // Ambil 5 member terbaru
        $recentMembers = Member::latest()->take(5)->get();

        // Ambil 5 transaksi terbaru dengan relasi user dan member
        $recentTransactions = Transaction::with(['user', 'member'])
            ->latest()
            ->take(5)
            ->get();

        // Data grafik untuk 7 hari terakhir (default)
        $chartData = $this->getChartData('week');

        // LOG: Admin melihat dashboard
        try {
            Log::create([
                'id_user' => auth()->id(),
                'role_user' => auth()->user()->role,
                'activity' => 'View Dashboard',
                'keterangan' => 'Admin melihat dashboard dengan statistik: ' . $stats['total_members'] . ' member, ' . $stats['total_products'] . ' produk',
            ]);
        } catch (\Exception $e) {
            \Log::error('Gagal menyimpan log: ' . $e->getMessage());
        }

        return view('admin.dashboard', compact('stats', 'recentMembers', 'recentTransactions', 'chartData'));
    }

    /**
     * Get chart data based on period
     */
    public function getChartData($period)
    {
        if ($period == 'week') {
            // Data 7 hari terakhir
            $labels = [];
            $values = [];
            
            for ($i = 6; $i >= 0; $i--) {
                $date = now()->subDays($i);
                
                // Format label: Sen, Sel, Rab, etc
                $days = ['Min', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab'];
                $labels[] = $days[$date->dayOfWeek];
                
                // Hitung total transaksi per hari
                $total = Transaction::whereDate('created_at', $date)
                    ->sum('total_harga');
                
                $values[] = $total ?: 0;
            }
        } else {
            // Data per minggu dalam 1 bulan
            $labels = [];
            $values = [];
            
            $startOfMonth = now()->startOfMonth();
            $endOfMonth = now()->endOfMonth();
            
            $weekStart = $startOfMonth->copy();
            $weekNumber = 1;
            
            while ($weekStart <= $endOfMonth) {
                $weekEnd = $weekStart->copy()->addDays(6);
                if ($weekEnd > $endOfMonth) {
                    $weekEnd = $endOfMonth->copy();
                }
                
                $labels[] = 'Minggu ' . $weekNumber;
                
                $total = Transaction::whereBetween('created_at', [
                    $weekStart->format('Y-m-d 00:00:00'), 
                    $weekEnd->format('Y-m-d 23:59:59')
                ])->sum('total_harga');
                
                $values[] = $total ?: 0;
                
                $weekStart->addDays(7);
                $weekNumber++;
            }
        }
        
        // Cari max value untuk height calculation
        $maxValue = count($values) > 0 ? max($values) : 1;
        
        return [
            'labels' => $labels,
            'values' => $values,
            'maxValue' => $maxValue,
            'period' => $period
        ];
    }

    /**
     * API endpoint for chart data
     */
    public function chartData(Request $request, $period)
    {
        $chartData = $this->getChartData($period);
        
        // LOG: Admin melihat chart data
        try {
            Log::create([
                'id_user' => auth()->id(),
                'role_user' => auth()->user()->role,
                'activity' => 'View Chart',
                'keterangan' => 'Admin melihat grafik periode: ' . $period,
            ]);
        } catch (\Exception $e) {
            \Log::error('Gagal menyimpan log: ' . $e->getMessage());
        }
        
        return response()->json($chartData);
    }
}