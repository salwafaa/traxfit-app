<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function index()
    {
        $users = User::orderBy('created_at', 'desc')->get();
        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'username' => 'required|unique:users|min:3',
            'password' => 'required|min:6',
            'nama' => 'required',
            'role' => 'required|in:admin,kasir,owner',
        ]);

        DB::beginTransaction();
        try {
            $user = User::create([
                'username' => $request->username,
                'password' => Hash::make($request->password),
                'nama' => $request->nama,
                'role' => $request->role,
                'status' => $request->has('status'),
            ]);

            // Log aktivitas
            try {
                Log::create([
                    'id_user' => auth()->id(),
                    'role_user' => auth()->user()->role,
                    'activity' => 'Create User',
                    'keterangan' => 'Menambahkan user baru: ' . $user->nama,
                ]);
            } catch (\Exception $e) {
                \Log::error('Gagal menyimpan log: ' . $e->getMessage());
            }

            DB::commit();

            return redirect()->route('admin.users.index')
                ->with('success', 'User berhasil ditambahkan.');
                
        } catch (\Exception $e) {
            DB::rollback();
            
            return redirect()->route('admin.users.create')
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        
        $request->validate([
            'username' => 'required|unique:users,username,' . $id . '|min:3',
            'nama' => 'required',
            'role' => 'required|in:admin,kasir,owner',
            'password' => 'nullable|min:6',
        ]);

        DB::beginTransaction();
        try {
            $data = [
                'username' => $request->username,
                'nama' => $request->nama,
                'role' => $request->role,
                'status' => $request->has('status'),
            ];

            if ($request->filled('password')) {
                $data['password'] = Hash::make($request->password);
            }

            $user->update($data);

            // Log aktivitas
            try {
                Log::create([
                    'id_user' => auth()->id(),
                    'role_user' => auth()->user()->role,
                    'activity' => 'Update User',
                    'keterangan' => 'Mengupdate user: ' . $user->nama,
                ]);
            } catch (\Exception $e) {
                \Log::error('Gagal menyimpan log update: ' . $e->getMessage());
            }

            DB::commit();

            return redirect()->route('admin.users.index')
                ->with('success', 'User berhasil diupdate.');
                
        } catch (\Exception $e) {
            DB::rollback();
            
            return redirect()->route('admin.users.edit', $id)
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        
        // Cek jika user mencoba menghapus dirinya sendiri
        if ($user->id == auth()->id()) {
            return redirect()->route('admin.users.index')
                ->with('error', 'Tidak dapat menghapus akun sendiri.');
        }

        DB::beginTransaction();
        try {
            $namaUser = $user->nama;
            $user->delete();

            // Log aktivitas
            try {
                Log::create([
                    'id_user' => auth()->id(),
                    'role_user' => auth()->user()->role,
                    'activity' => 'Delete User',
                    'keterangan' => 'Menghapus user: ' . $namaUser,
                ]);
            } catch (\Exception $e) {
                \Log::error('Gagal menyimpan log delete: ' . $e->getMessage());
            }

            DB::commit();

            return redirect()->route('admin.users.index')
                ->with('success', 'User berhasil dihapus.');
                
        } catch (\Exception $e) {
            DB::rollback();
            
            return redirect()->route('admin.users.index')
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function toggleStatus($id)
    {
        $user = User::findOrFail($id);
        
        // Cek jika user mencoba menonaktifkan dirinya sendiri
        if ($user->id == auth()->id() && $user->status) {
            return redirect()->route('admin.users.index')
                ->with('error', 'Tidak dapat menonaktifkan akun sendiri.');
        }

        DB::beginTransaction();
        try {
            $oldStatus = $user->status;
            $user->status = !$user->status;
            $user->save();

            // Log aktivitas
            try {
                Log::create([
                    'id_user' => auth()->id(),
                    'role_user' => auth()->user()->role,
                    'activity' => 'Toggle User Status',
                    'keterangan' => 'Mengubah status user ' . $user->nama . ' dari ' . ($oldStatus ? 'aktif' : 'nonaktif') . ' menjadi ' . ($user->status ? 'aktif' : 'nonaktif'),
                ]);
            } catch (\Exception $e) {
                \Log::error('Gagal menyimpan log toggle status: ' . $e->getMessage());
            }

            DB::commit();

            return redirect()->route('admin.users.index')
                ->with('success', 'Status user berhasil diubah.');
                
        } catch (\Exception $e) {
            DB::rollback();
            
            return redirect()->route('admin.users.index')
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}