<?php

namespace App\Http\Controllers;

use App\Models\Log;
use App\Models\Member;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\GymSetting;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class OwnerController extends Controller
{
    public function dashboard()
    {
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;
        $today = Carbon::now()->toDateString();

        $pendapatanBulanIni = Transaction::whereMonth('created_at', $currentMonth)
            ->whereYear('created_at', $currentYear)
            ->whereIn('status_transaksi', ['success', 'completed'])
            ->sum('total_harga');

        $memberAktif = Member::where('status', 'active')
            ->whereDate('tgl_expired', '>=', $today)
            ->count();

        $transaksiBulanIni = Transaction::whereMonth('created_at', $currentMonth)
            ->whereYear('created_at', $currentYear)
            ->count();

        $produkTersedia = Product::where('status', 1)
            ->where('stok', '>', 0)
            ->count();

        $totalMember = Member::count();
        $memberExpired = Member::where('status', 'expired')
            ->orWhereDate('tgl_expired', '<', $today)
            ->count();

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

        $recentTransactions = Transaction::with(['user', 'member'])
            ->whereIn('status_transaksi', ['success', 'completed'])
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        $visitHariIni = Transaction::whereDate('created_at', $today)
            ->where('jenis_transaksi', 'visit')
            ->count();

        $membershipBaru = Member::whereMonth('tgl_daftar', $currentMonth)
            ->whereYear('tgl_daftar', $currentYear)
            ->count();

        try {
            Log::create([
                 'id_user' => Auth::id(),
                    'role_user' => Auth::user()->role,
                'activity' => 'View Dashboard',
                'keterangan' => 'Owner melihat dashboard',
            ]);
        } catch (\Exception $e) {
            Log::error('Gagal menyimpan log: ' . $e->getMessage());
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

    public function profile()
    {
        $user = Auth::user();

        try {
            Log::create([
                 'id_user' => Auth::id(),
                    'role_user' => Auth::user()->role,
                'activity' => 'View Profile',
                'keterangan' => 'Owner melihat halaman profil',
            ]);
        } catch (\Exception $e) {
            Log::error('Gagal menyimpan log: ' . $e->getMessage());
        }

        return view('owner.profile', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'nama'     => 'required|string|max:255',
            'username' => 'required|string|min:3|unique:users,username,' . $user->id,
            'current_password' => 'nullable|string',
            'password' => 'nullable|string|min:6|confirmed',
        ], [
            'nama.required'             => 'Nama wajib diisi.',
            'username.required'         => 'Username wajib diisi.',
            'username.min'              => 'Username minimal 3 karakter.',
            'username.unique'           => 'Username sudah digunakan.',
            'password.min'              => 'Password baru minimal 6 karakter.',
            'password.confirmed'        => 'Konfirmasi password tidak cocok.',
        ]);

        if ($request->filled('password')) {
            if (!$request->filled('current_password')) {
                return back()
                    ->withErrors(['current_password' => 'Password saat ini wajib diisi untuk mengganti password.'])
                    ->withInput();
            }

            if (!Hash::check($request->current_password, $user->password)) {
                return back()
                    ->withErrors(['current_password' => 'Password saat ini tidak sesuai.'])
                    ->withInput();
            }
        }

        DB::beginTransaction();
        try {
            $data = [
                'nama'     => $request->nama,
                'username' => $request->username,
            ];

            if ($request->filled('password')) {
                $data['password'] = Hash::make($request->password);
            }

            User::where('id', $user->id)->update($data);

            try {
                Log::create([
                     'id_user' => Auth::id(),
                    'role_user' => Auth::user()->role,
                    'activity' => 'Update Profile',
                    'keterangan' => 'Owner mengupdate profil sendiri',
                ]);
            } catch (\Exception $e) {
                Log::error('Gagal menyimpan log: ' . $e->getMessage());
            }

            DB::commit();

            return redirect()->route('owner.profile')
                ->with('success', 'Profil berhasil diperbarui.');

        } catch (\Exception $e) {
            DB::rollback();

            return redirect()->route('owner.profile')
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage())
                ->withInput();
        }
    }
}