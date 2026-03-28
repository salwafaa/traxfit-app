<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProductCategory;
use App\Models\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = ProductCategory::withCount('products')->latest()->get();
        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_kategori' => 'required|unique:product_categories',
        ]);

        DB::beginTransaction();
        try {
            $category = ProductCategory::create([
                'nama_kategori' => $request->nama_kategori,
            ]);

            // Log aktivitas
            try {
                Log::create([
                    'id_user' => auth()->id(),
                    'role_user' => auth()->user()->role,
                    'activity' => 'Create Category',
                    'keterangan' => 'Menambahkan kategori baru: ' . $category->nama_kategori,
                ]);
            } catch (\Exception $e) {
                \Log::error('Gagal menyimpan log: ' . $e->getMessage());
            }

            DB::commit();

            return redirect()->route('admin.categories.index')
                ->with('success', 'Kategori berhasil ditambahkan.');
                
        } catch (\Exception $e) {
            DB::rollback();
            
            return redirect()->route('admin.categories.create')
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function edit($id)
    {
        $category = ProductCategory::findOrFail($id);
        return view('admin.categories.edit', compact('category'));
    }

    public function update(Request $request, $id)
    {
        $category = ProductCategory::findOrFail($id);
        
        $request->validate([
            'nama_kategori' => 'required|unique:product_categories,nama_kategori,' . $id,
        ]);

        DB::beginTransaction();
        try {
            $category->update([
                'nama_kategori' => $request->nama_kategori,
            ]);

            // Log aktivitas
            try {
                Log::create([
                    'id_user' => auth()->id(),
                    'role_user' => auth()->user()->role,
                    'activity' => 'Update Category',
                    'keterangan' => 'Mengupdate kategori: ' . $category->nama_kategori,
                ]);
            } catch (\Exception $e) {
                \Log::error('Gagal menyimpan log: ' . $e->getMessage());
            }

            DB::commit();

            return redirect()->route('admin.categories.index')
                ->with('success', 'Kategori berhasil diupdate.');
                
        } catch (\Exception $e) {
            DB::rollback();
            
            return redirect()->route('admin.categories.edit', $id)
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function destroy($id)
    {
        $category = ProductCategory::findOrFail($id);

        // Cek apakah kategori digunakan oleh produk
        if ($category->products()->count() > 0) {
            return redirect()->route('admin.categories.index')
                ->with('error', 'Kategori tidak dapat dihapus karena masih digunakan oleh produk.');
        }

        DB::beginTransaction();
        try {
            $namaKategori = $category->nama_kategori;
            $category->delete();

            // Log aktivitas
            try {
                Log::create([
                    'id_user' => auth()->id(),
                    'role_user' => auth()->user()->role,
                    'activity' => 'Delete Category',
                    'keterangan' => 'Menghapus kategori: ' . $namaKategori,
                ]);
            } catch (\Exception $e) {
                \Log::error('Gagal menyimpan log: ' . $e->getMessage());
            }

            DB::commit();

            return redirect()->route('admin.categories.index')
                ->with('success', 'Kategori berhasil dihapus.');
                
        } catch (\Exception $e) {
            DB::rollback();
            
            return redirect()->route('admin.categories.index')
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}