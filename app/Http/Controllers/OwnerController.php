<?php

namespace App\Http\Controllers;

use App\Models\Log;
use App\Models\Member;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\GymSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class OwnerController extends Controller
{
    public function dashboard()
    {
        // Get current month data
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;
        $today = Carbon::now()->toDateString();

        // 1. Pendapatan Bulan Ini (total transaksi bulan ini)
        $pendapatanBulanIni = Transaction::whereMonth('created_at', $currentMonth)
            ->whereYear('created_at', $currentYear)
            ->whereIn('status_transaksi', ['success', 'completed'])
            ->sum('total_harga');

        // 2. Member Aktif (member dengan status active dan belum expired)
        $memberAktif = Member::where('status', 'active')
            ->whereDate('tgl_expired', '>=', $today)
            ->count();

        // 3. Transaksi Bulan Ini
        $transaksiBulanIni = Transaction::whereMonth('created_at', $currentMonth)
            ->whereYear('created_at', $currentYear)
            ->count();

        // 4. Produk Tersedia (produk dengan stok > 0 dan status aktif)
        $produkTersedia = Product::where('status', 1)
            ->where('stok', '>', 0)
            ->count();

        // Data tambahan untuk grafik dan statistik lainnya
        $totalMember = Member::count();
        $memberExpired = Member::where('status', 'expired')
            ->orWhereDate('tgl_expired', '<', $today)
            ->count();

        // Data transaksi 7 hari terakhir untuk grafik
        $last7Days = collect();
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $last7Days->push([
                'date' => $date->format('d/m'),
                'total' => Transaction::whereDate('created_at', $date->toDateString())
                    ->whereIn('status_transaksi', ['success', 'completed'])
                    ->sum('total_harga')
            ]);
        }

        // Top products
        $topProducts = DB::table('transaction_details')
            ->join('products', 'transaction_details.id_product', '=', 'products.id')
            ->join('transactions', 'transaction_details.id_transaction', '=', 'transactions.id')
            ->whereIn('transactions.status_transaksi', ['success', 'completed'])
            ->select(
                'products.nama_produk',
                DB::raw('SUM(transaction_details.qty) as total_qty'),
                DB::raw('SUM(transaction_details.subtotal) as total_penjualan')
            )
            ->groupBy('products.id', 'products.nama_produk')
            ->orderBy('total_qty', 'desc')
            ->limit(5)
            ->get();

        // Recent transactions
        $recentTransactions = Transaction::with(['user', 'member'])
            ->whereIn('status_transaksi', ['success', 'completed'])
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        // Data visit hari ini
        $visitHariIni = Transaction::whereDate('created_at', $today)
            ->where('jenis_transaksi', 'visit')
            ->count();

        // Membership baru bulan ini
        $membershipBaru = Member::whereMonth('tgl_daftar', $currentMonth)
            ->whereYear('tgl_daftar', $currentYear)
            ->count();

        // LOG: Owner melihat dashboard
        try {
            Log::create([
                'id_user' => auth()->id(),
                'role_user' => auth()->user()->role,
                'activity' => 'View Dashboard',
                'keterangan' => 'Owner melihat dashboard',
            ]);
        } catch (\Exception $e) {
            \Log::error('Gagal menyimpan log: ' . $e->getMessage());
        }
        
        return view('owner.dashboard', compact(
            'pendapatanBulanIni',
            'memberAktif',
            'transaksiBulanIni',
            'produkTersedia',
            'totalMember',
            'memberExpired',
            'last7Days',
            'topProducts',
            'recentTransactions',
            'visitHariIni',
            'membershipBaru'
        ));
    }
}