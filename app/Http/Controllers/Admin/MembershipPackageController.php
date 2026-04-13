<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MembershipPackage;
use App\Models\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;


class MembershipPackageController extends Controller
{
    public function index()
    {
        $packages = MembershipPackage::latest()->get();
        return view('admin.packages.index', compact('packages'));
    }

    public function create()
    {
        return view('admin.packages.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_paket' => 'required|unique:membership_packages',
            'durasi_hari' => 'required|integer|min:1',
            'harga' => 'required|numeric|min:0',
        ]);

        DB::beginTransaction();
        try {
            $package = MembershipPackage::create([
                'nama_paket' => $request->nama_paket,
                'durasi_hari' => $request->durasi_hari,
                'harga' => $request->harga,
                'status' => $request->has('status'),
            ]);

            try {
                Log::create([
                    'id_user' => Auth::id(),
                    'role_user' => Auth::user()->role,
                    'activity' => 'Create Membership Package',
                    'keterangan' => 'Menambahkan paket membership: ' . $package->nama_paket,
                ]);
            } catch (\Exception $e) {
                Log::error('Gagal menyimpan log: ' . $e->getMessage());
            }

            DB::commit();

            return redirect()->route('admin.packages.index')
                ->with('success', 'Paket membership berhasil ditambahkan.');
                
        } catch (\Exception $e) {
            DB::rollback();
            
            return redirect()->route('admin.packages.create')
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function edit($id)
    {
        $package = MembershipPackage::findOrFail($id);
        return view('admin.packages.edit', compact('package'));
    }

    public function update(Request $request, $id)
    {
        $package = MembershipPackage::findOrFail($id);
        
        $request->validate([
            'nama_paket' => 'required|unique:membership_packages,nama_paket,' . $id,
            'durasi_hari' => 'required|integer|min:1',
            'harga' => 'required|numeric|min:0',
        ]);

        DB::beginTransaction();
        try {
            $package->update([
                'nama_paket' => $request->nama_paket,
                'durasi_hari' => $request->durasi_hari,
                'harga' => $request->harga,
                'status' => $request->has('status'),
            ]);

            try {
                Log::create([
                    'id_user' => Auth::id(),
                    'role_user' => Auth::user()->role,
                    'activity' => 'Update Membership Package',
                    'keterangan' => 'Mengupdate paket membership: ' . $package->nama_paket,
                ]);
            } catch (\Exception $e) {
                Log::error('Gagal menyimpan log: ' . $e->getMessage());
            }

            DB::commit();

            return redirect()->route('admin.packages.index')
                ->with('success', 'Paket membership berhasil diupdate.');
                
        } catch (\Exception $e) {
            DB::rollback();
            
            return redirect()->route('admin.packages.edit', $id)
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function destroy($id)
    {
        $package = MembershipPackage::findOrFail($id);

        if ($package->members()->count() > 0) {
            return redirect()->route('admin.packages.index')
                ->with('error', 'Paket tidak dapat dihapus karena masih digunakan oleh member.');
        }

        DB::beginTransaction();
        try {
            $namaPackage = $package->nama_paket;
            $package->delete();

            try {
                Log::create([
                     'id_user' => Auth::id(),
                    'role_user' => Auth::user()->role,
                    'activity' => 'Delete Membership Package',
                    'keterangan' => 'Menghapus paket membership: ' . $namaPackage,
                ]);
            } catch (\Exception $e) {
                Log::error('Gagal menyimpan log: ' . $e->getMessage());
            }

            DB::commit();

            return redirect()->route('admin.packages.index')
                ->with('success', 'Paket membership berhasil dihapus.');
                
        } catch (\Exception $e) {
            DB::rollback();
            
            return redirect()->route('admin.packages.index')
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function toggleStatus($id)
    {
        $package = MembershipPackage::findOrFail($id);

        DB::beginTransaction();
        try {
            $oldStatus = $package->status;
            $package->status = !$package->status;
            $package->save();

            try {
                Log::create([
                    'id_user' => Auth::id(),
                    'role_user' => Auth::user()->role,
                    'activity' => 'Toggle Package Status',
                    'keterangan' => 'Mengubah status paket ' . $package->nama_paket . ' dari ' . ($oldStatus ? 'aktif' : 'nonaktif') . ' menjadi ' . ($package->status ? 'aktif' : 'nonaktif'),
                ]);
            } catch (\Exception $e) {
                Log::error('Gagal menyimpan log: ' . $e->getMessage());
            }

            DB::commit();

            return redirect()->route('admin.packages.index')
                ->with('success', 'Status paket berhasil diubah.');
                
        } catch (\Exception $e) {
            DB::rollback();
            
            return redirect()->route('admin.packages.index')
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}