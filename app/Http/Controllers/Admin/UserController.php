<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index()
    {
        $user = Auth::user()->role;

        if ($user->role === 'owner') {
            $users = User::whereIn('role', ['admin', 'kasir'])->orderBy('created_at', 'desc')->get();
        } else {
            $users = User::where('role', 'kasir')->orderBy('created_at', 'desc')->get();
        }

        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        $user = Auth::user()->role;

        if ($user->role === 'admin') {
            return view('admin.users.create', ['allowedRoles' => ['kasir']]);
        }

        if ($user->role === 'owner') {
            return view('admin.users.create', ['allowedRoles' => ['admin', 'kasir']]);
        }

        return redirect()->route('kasir.dashboard')->with('error', 'Anda tidak memiliki akses.');
    }

    public function store(Request $request)
    {
        $currentUser = Auth::user()->role;

        $rules = [
            'username' => 'required|unique:users|min:3',
            'password' => 'required|min:6',
            'nama' => 'required',
        ];

        if ($currentUser->role === 'admin') {
            $request->merge(['role' => 'kasir']);
        } elseif ($currentUser->role === 'owner') {
            $rules['role'] = 'required|in:admin,kasir';
        } else {
            return redirect()->route('kasir.dashboard')->with('error', 'Anda tidak memiliki akses.');
        }

        $request->validate($rules);

        DB::beginTransaction();

        try {
            $user = User::create([
                'username' => $request->username,
                'password' => Hash::make($request->password),
                'nama' => $request->nama,
                'role' => $request->role,
                'status' => $request->has('status'),
            ]);

            try {
                Log::create([
                    'id_user' => Auth::id(),
                    'role_user' => Auth::user()->role,
                    'activity' => 'Create User',
                    'keterangan' => 'Menambahkan user baru: ' . $user->nama . ' (Role: ' . $user->role . ')',
                ]);
            } catch (\Exception $e) {
                Log::error('Gagal menyimpan log: ' . $e->getMessage());
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
        $currentUser = Auth::user()->role;

        if ($currentUser->role === 'owner') {
            if (!in_array($user->role, ['admin', 'kasir'])) {
                return redirect()->route('admin.users.index')
                    ->with('error', 'User tidak valid.');
            }

            return view('admin.users.edit', compact('user'));
        }

        if ($currentUser->role === 'admin') {
            if ($user->role !== 'kasir') {
                return redirect()->route('admin.users.index')
                    ->with('error', 'Anda hanya bisa mengedit user dengan role Kasir.');
            }

            return view('admin.users.edit', compact('user'));
        }

        return redirect()->route('kasir.dashboard')->with('error', 'Anda tidak memiliki akses.');
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $currentUser = Auth::user()->role;

        if ($currentUser->role === 'admin' && $user->role !== 'kasir') {
            return redirect()->route('admin.users.index')
                ->with('error', 'Anda hanya bisa mengedit user dengan role Kasir.');
        }

        if ($currentUser->role === 'owner' && !in_array($user->role, ['admin', 'kasir'])) {
            return redirect()->route('admin.users.index')
                ->with('error', 'User tidak valid.');
        }

        $rules = [
            'username' => 'required|unique:users,username,' . $id . '|min:3',
            'nama' => 'required',
            'password' => 'nullable|min:6',
        ];

        if ($currentUser->role === 'admin') {
            $rules['role'] = 'in:kasir';
        } else {
            $rules['role'] = 'required|in:admin,kasir';
        }

        $request->validate($rules);

        DB::beginTransaction();

        try {
            $data = [
                'username' => $request->username,
                'nama' => $request->nama,
                'status' => $request->has('status'),
            ];

            if ($currentUser->role === 'owner' && $request->has('role')) {
                $data['role'] = $request->role;
            }

            if ($request->filled('password')) {
                $data['password'] = Hash::make($request->password);
            }

            $user->update($data);

            try {
                Log::create([
                    'id_user' => Auth::id(),
                    'role_user' => Auth::user()->role,
                    'activity' => 'Update User',
                    'keterangan' => 'Mengupdate user: ' . $user->nama . ' (Role: ' . $user->role . ')',
                ]);
            } catch (\Exception $e) {
                Log::error('Gagal menyimpan log update: ' . $e->getMessage());
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
        $currentUser = Auth::user()->role;

        if ($user->id == Auth::id()) {
            return redirect()->route('admin.users.index')
                ->with('error', 'Tidak dapat menghapus akun sendiri.');
        }

        if ($currentUser->role === 'admin') {
            if ($user->role !== 'kasir') {
                return redirect()->route('admin.users.index')
                    ->with('error', 'Anda hanya bisa menghapus user dengan role Kasir.');
            }
        }

        if ($currentUser->role === 'owner') {
            if ($user->role === 'owner') {
                return redirect()->route('admin.users.index')
                    ->with('error', 'Tidak dapat menghapus user dengan role Owner.');
            }
        }

        DB::beginTransaction();

        try {
            $namaUser = $user->nama;
            $roleUser = $user->role;

            Log::where('id_user', $user->id)->delete();

            $user->delete();

            try {
                Log::create([
                    'id_user' => Auth::id(),
                    'role_user' => Auth::user()->role,
                    'activity' => 'Delete User',
                    'keterangan' => 'Menghapus user: ' . $namaUser . ' (Role: ' . $roleUser . ')',
                ]);
            } catch (\Exception $e) {
                Log::error('Gagal menyimpan log delete: ' . $e->getMessage());
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
        $currentUser = Auth::user()->role;

        if ($user->id == Auth::id() && $user->status) {
            return redirect()->route('admin.users.index')
                ->with('error', 'Tidak dapat menonaktifkan akun sendiri.');
        }

        if ($currentUser->role === 'admin') {
            if ($user->role !== 'kasir') {
                return redirect()->route('admin.users.index')
                    ->with('error', 'Anda hanya bisa mengubah status user dengan role Kasir.');
            }
        }

        if ($currentUser->role === 'owner') {
            if (!in_array($user->role, ['admin', 'kasir'])) {
                return redirect()->route('admin.users.index')
                    ->with('error', 'User tidak valid.');
            }
        }

        DB::beginTransaction();

        try {
            $oldStatus = $user->status;

            $user->status = !$user->status;
            $user->save();

            try {
                Log::create([
                    'id_user' => Auth::id(),
                    'role_user' => Auth::user()->role,
                    'activity' => 'Toggle User Status',
                    'keterangan' => 'Mengubah status user ' . $user->nama . ' (Role: ' . $user->role . ') dari ' . ($oldStatus ? 'aktif' : 'nonaktif') . ' menjadi ' . ($user->status ? 'aktif' : 'nonaktif'),
                ]);
            } catch (\Exception $e) {
                Log::error('Gagal menyimpan log toggle status: ' . $e->getMessage());
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

    public function restore($id)
    {
        $user = User::withTrashed()->findOrFail($id);
        $currentUser = Auth::user()->role;

        if ($currentUser->role === 'admin' && $user->role !== 'kasir') {
            return redirect()->route('admin.users.index')
                ->with('error', 'Anda hanya bisa merestore user dengan role Kasir.');
        }

        if ($currentUser->role === 'owner' && !in_array($user->role, ['admin', 'kasir'])) {
            return redirect()->route('admin.users.index')
                ->with('error', 'User tidak valid.');
        }

        DB::beginTransaction();

        try {
            Log::withTrashed()->where('id_user', $user->id)->restore();

            $user->restore();

            DB::commit();

            return redirect()->route('admin.users.index')
                ->with('success', 'User berhasil direstore.');
        } catch (\Exception $e) {
            DB::rollback();

            return redirect()->route('admin.users.index')
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function forceDelete($id)
    {
        $user = User::withTrashed()->findOrFail($id);
        $currentUser = Auth::user()->role;

        if ($user->id == Auth::id()) {
            return redirect()->route('admin.users.index')
                ->with('error', 'Tidak dapat menghapus akun sendiri.');
        }

        if ($currentUser->role === 'admin' && $user->role !== 'kasir') {
            return redirect()->route('admin.users.index')
                ->with('error', 'Anda hanya bisa menghapus permanen user dengan role Kasir.');
        }

        if ($currentUser->role === 'owner' && !in_array($user->role, ['admin', 'kasir'])) {
            return redirect()->route('admin.users.index')
                ->with('error', 'User tidak valid.');
        }

        DB::beginTransaction();

        try {
            Log::where('id_user', $user->id)->forceDelete();

            $user->forceDelete();

            DB::commit();

            return redirect()->route('admin.users.index')
                ->with('success', 'User berhasil dihapus permanen.');
        } catch (\Exception $e) {
            DB::rollback();

            return redirect()->route('admin.users.index')
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}