<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AuthController extends Controller
{
    public function showLogin()
    {
        // Jika user sudah login, redirect ke dashboard sesuai role
        if (Auth::check()) {
            return $this->redirectToDashboard(Auth::user());
        }
        
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        // Mulai transaksi untuk menjaga konsistensi data
        DB::beginTransaction();
        try {
            // Cari user berdasarkan username
            $user = User::where('username', $request->username)->first();

            // Validasi user
            if (!$user) {
                return back()->withErrors([
                    'message' => 'Username atau password salah.',
                ])->withInput($request->only('username'));
            }

            // Validasi password
            if (!Hash::check($request->password, $user->password)) {
                return back()->withErrors([
                    'message' => 'Username atau password salah.',
                ])->withInput($request->only('username'));
            }

            // Validasi status akun
            if (!$user->status) {
                return back()->withErrors([
                    'message' => 'Akun dinonaktifkan. Silahkan hubungi administrator.',
                ])->withInput($request->only('username'));
            }

            // Update last_login dengan waktu sekarang
            $user->last_login = Carbon::now('Asia/Jakarta');
            $user->save();

            // Login user dengan remember token jika dicentang
            Auth::login($user, $request->has('remember'));

            // Log aktivitas login
            try {
                Log::create([
                    'id_user' => $user->id,
                    'role_user' => $user->role,
                    'activity' => 'Login',
                    'keterangan' => 'User berhasil login ke sistem',
                    'created_at' => Carbon::now('Asia/Jakarta'),
                ]);
            } catch (\Exception $e) {
                \Illuminate\Support\Facades\Log::error('Gagal membuat log login: ' . $e->getMessage());
            }

            DB::commit();

            // Redirect berdasarkan role
            return $this->redirectToDashboard($user);

        } catch (\Exception $e) {
            DB::rollback();
            
            return back()->withErrors([
                'message' => 'Terjadi kesalahan saat login. Silahkan coba lagi.',
            ])->withInput($request->only('username'));
        }
    }

    public function logout(Request $request)
    {
        // Simpan data user sebelum logout untuk logging
        $userId = Auth::id();
        $userRole = Auth::user() ? Auth::user()->role : null;
        
        // Log aktivitas logout sebelum logout
        if ($userId && $userRole) {
            try {
                Log::create([
                    'id_user' => $userId,
                    'role_user' => $userRole,
                    'activity' => 'Logout',
                    'keterangan' => 'User logout dari sistem',
                    'created_at' => Carbon::now('Asia/Jakarta'),
                ]);
            } catch (\Exception $e) {
                \Illuminate\Support\Facades\Log::error('Gagal membuat log logout: ' . $e->getMessage());
            }
        }

        // Logout user
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('status', 'Anda telah berhasil logout.');
    }

    /**
     * Redirect user ke dashboard berdasarkan role
     */
    private function redirectToDashboard($user)
    {
        switch ($user->role) {
            case 'admin':
                return redirect()->route('admin.dashboard')
                    ->with('success', 'Selamat datang, ' . $user->nama . '!');
            case 'kasir':
                return redirect()->route('kasir.dashboard')
                    ->with('success', 'Selamat datang, ' . $user->nama . '!');
            case 'owner':
                return redirect()->route('owner.dashboard')
                    ->with('success', 'Selamat datang, ' . $user->nama . '!');
            default:
                return redirect('/')
                    ->with('success', 'Selamat datang, ' . $user->nama . '!');
        }
    }
}