<?php

namespace App\Http\Controllers\Kasir;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\MemberCheckin;
use App\Models\Log;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function transaksi(Request $request)
    {
        $transactions = Transaction::with(['user', 'member'])
            ->where('id_user', auth()->id())
            ->when($request->filled('start_date'), function($query) use ($request) {
                $query->whereDate('created_at', '>=', $request->start_date);
            })
            ->when($request->filled('end_date'), function($query) use ($request) {
                $query->whereDate('created_at', '<=', $request->end_date);
            })
            ->when($request->filled('search'), function($query) use ($request) {
                $query->where(function($q) use ($request) {
                    $q->where('nomor_unik', 'like', "%{$request->search}%")
                      ->orWhereHas('member', function($q) use ($request) {
                          $q->where('nama', 'like', "%{$request->search}%")
                            ->orWhere('kode_member', 'like', "%{$request->search}%");
                      });
                });
            })
            ->latest()
            ->paginate(20);
            
        $totalTransaksi = $transactions->sum('total_harga');

        // LOG: Kasir melihat laporan transaksi
        try {
            $filterDesc = '';
            if ($request->filled('start_date') && $request->filled('end_date')) {
                $filterDesc = ' periode ' . $request->start_date . ' s/d ' . $request->end_date;
            } elseif ($request->filled('search')) {
                $filterDesc = ' pencarian "' . $request->search . '"';
            }
            
            Log::create([
                'id_user' => auth()->id(),
                'role_user' => auth()->user()->role,
                'activity' => 'View Transaction Report',
                'keterangan' => 'Kasir melihat laporan transaksi' . $filterDesc,
            ]);
        } catch (\Exception $e) {
            \Log::error('Gagal menyimpan log: ' . $e->getMessage());
        }
        
        return view('kasir.report.transaksi', compact('transactions', 'totalTransaksi'));
    }

    public function cetakUlang(Request $request)
    {
        $transactions = Transaction::with(['user', 'member'])
            ->where('id_user', auth()->id())
            ->when($request->filled('search'), function($query) use ($request) {
                $query->where(function($q) use ($request) {
                    $q->where('nomor_unik', 'like', "%{$request->search}%")
                      ->orWhereHas('member', function($q) use ($request) {
                          $q->where('nama', 'like', "%{$request->search}%")
                            ->orWhere('kode_member', 'like', "%{$request->search}%");
                      });
                });
            })
            ->latest()
            ->paginate(20);

        // LOG: Kasir melihat halaman cetak ulang struk
        try {
            Log::create([
                'id_user' => auth()->id(),
                'role_user' => auth()->user()->role,
                'activity' => 'View Reprint Page',
                'keterangan' => 'Kasir melihat halaman cetak ulang struk',
            ]);
        } catch (\Exception $e) {
            \Log::error('Gagal menyimpan log: ' . $e->getMessage());
        }
            
        return view('kasir.report.cetak_ulang', compact('transactions'));
    }
}