<?php

namespace App\Http\Controllers\Owner;

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
        $users = User::whereIn('role', ['admin', 'kasir'])->orderBy('created_at', 'desc')->get();
        return view('owner.users.index', compact('users'));
    }

    public function create()
    {
        return view('owner.users.create');
    }

   public function store(Request $request)
{
    $currentUser = auth()->user();
    
    if ($currentUser->role !== 'admin') {
        return redirect()->route('admin.dashboard')->with('error', 'Anda tidak memiliki akses.');
    }
    
    $request->validate([
        'username' => 'required|unique:users|min:3',
        'password' => 'required|min:6',
        'nama' => 'required',
    ]);

    DB::beginTransaction();
    try {
        $user = User::create([
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'nama' => $request->nama,
            'role' => 'kasir', 
            'status' => $request->has('status'),
        ]);

        try {
            Log::create([
                'id_user' => auth()->id(),
                'role_user' => auth()->user()->role,
                'activity' => 'Create User',
                'keterangan' => 'Menambahkan user baru (Kasir): ' . $user->nama,
            ]);
        } catch (\Exception $e) {
            \Log::error('Gagal menyimpan log: ' . $e->getMessage());
        }

        DB::commit();

        return redirect()->route('admin.users.index')
            ->with('success', 'User Kasir berhasil ditambahkan.');
            
    } catch (\Exception $e) {
        DB::rollback();
        
        return redirect()->route('admin.users.create')
            ->with('error', 'Terjadi kesalahan: ' . $e->getMessage())
            ->withInput();
    }
}

    public function edit($id)
    {
        $user = User::whereIn('role', ['admin', 'kasir'])->findOrFail($id);
        return view('owner.users.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $user = User::whereIn('role', ['admin', 'kasir'])->findOrFail($id);
        
        $request->validate([
            'username' => 'required|unique:users,username,' . $id . '|min:3',
            'nama' => 'required',
            'role' => 'required|in:admin,kasir',
            'password' => 'nullable|min:6',
            'status' => 'nullable|boolean',
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

            try {
                Log::create([
                    'id_user' => auth()->id(),
                    'role_user' => auth()->user()->role,
                    'activity' => 'Update User',
                    'keterangan' => 'Mengupdate user: ' . $user->nama . ' (Role: ' . $user->role . ')',
                ]);
            } catch (\Exception $e) {
                \Log::error('Gagal menyimpan log update: ' . $e->getMessage());
            }

            DB::commit();

            return redirect()->route('owner.users.index')
                ->with('success', 'User berhasil diupdate.');
                
        } catch (\Exception $e) {
            DB::rollback();
            
            return redirect()->route('owner.users.edit', $id)
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function destroy($id)
    {
        $user = User::whereIn('role', ['admin', 'kasir'])->findOrFail($id);
        
        if ($user->id == auth()->id()) {
            return redirect()->route('owner.users.index')
                ->with('error', 'Tidak dapat menghapus akun sendiri.');
        }

        DB::beginTransaction();
        try {
            $namaUser = $user->nama;
            $roleUser = $user->role;
            
            Log::where('id_user', $user->id)->delete();
            
            $user->delete();

            try {
                Log::create([
                    'id_user' => auth()->id(),
                    'role_user' => auth()->user()->role,
                    'activity' => 'Delete User',
                    'keterangan' => 'Menghapus user: ' . $namaUser . ' (Role: ' . $roleUser . ')',
                ]);
            } catch (\Exception $e) {
                \Log::error('Gagal menyimpan log delete: ' . $e->getMessage());
            }

            DB::commit();

            return redirect()->route('owner.users.index')
                ->with('success', 'User berhasil dihapus.');
                
        } catch (\Exception $e) {
            DB::rollback();
            
            return redirect()->route('owner.users.index')
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function toggleStatus($id)
    {
        $user = User::whereIn('role', ['admin', 'kasir'])->findOrFail($id);
        
        if ($user->id == auth()->id() && $user->status) {
            return redirect()->route('owner.users.index')
                ->with('error', 'Tidak dapat menonaktifkan akun sendiri.');
        }

        DB::beginTransaction();
        try {
            $oldStatus = $user->status;
            $user->status = !$user->status;
            $user->save();

            try {
                Log::create([
                    'id_user' => auth()->id(),
                    'role_user' => auth()->user()->role,
                    'activity' => 'Toggle User Status',
                    'keterangan' => 'Mengubah status user ' . $user->nama . ' (Role: ' . $user->role . ') dari ' . ($oldStatus ? 'aktif' : 'nonaktif') . ' menjadi ' . ($user->status ? 'aktif' : 'nonaktif'),
                ]);
            } catch (\Exception $e) {
                \Log::error('Gagal menyimpan log toggle status: ' . $e->getMessage());
            }

            DB::commit();

            return redirect()->route('owner.users.index')
                ->with('success', 'Status user berhasil diubah.');
                
        } catch (\Exception $e) {
            DB::rollback();
            
            return redirect()->route('owner.users.index')
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function restore($id)
    {
        $user = User::withTrashed()->whereIn('role', ['admin', 'kasir'])->findOrFail($id);
        
        DB::beginTransaction();
        try {
            Log::withTrashed()->where('id_user', $user->id)->restore();
            
            $user->restore();

            DB::commit();

            return redirect()->route('owner.users.index')
                ->with('success', 'User berhasil direstore.');
                
        } catch (\Exception $e) {
            DB::rollback();
            
            return redirect()->route('owner.users.index')
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function forceDelete($id)
    {
        $user = User::withTrashed()->whereIn('role', ['admin', 'kasir'])->findOrFail($id);
        
        if ($user->id == auth()->id()) {
            return redirect()->route('owner.users.index')
                ->with('error', 'Tidak dapat menghapus akun sendiri.');
        }

        DB::beginTransaction();
        try {
            $namaUser = $user->nama;
            $roleUser = $user->role;
            
            Log::where('id_user', $user->id)->forceDelete();
            
            $user->forceDelete();

            DB::commit();

            return redirect()->route('owner.users.index')
                ->with('success', 'User berhasil dihapus permanen.');
                
        } catch (\Exception $e) {
            DB::rollback();
            
            return redirect()->route('owner.users.index')
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}