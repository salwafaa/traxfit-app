@extends('layouts.app')

@section('title', 'Tambah Kategori')
@section('page-title', 'Tambah Kategori Baru')

@section('sidebar')
@include('admin.partials.sidebar')
@endsection

@section('content')
<div class="bg-gradient-to-r from-primary to-primary-dark text-white rounded-xl shadow-lg overflow-hidden mb-6">
    <div class="px-6 py-4">
        <h3 class="text-lg font-bold">Form Tambah Kategori</h3>
        <p class="text-sm opacity-90">Isi form di bawah untuk menambahkan kategori produk baru</p>
    </div>
</div>

<div class="bg-white rounded-xl shadow-lg border border-gray-200 overflow-hidden">
    <div class="p-6">
        <form action="{{ route('admin.categories.store') }}" method="POST">
            @csrf
            
            <div class="max-w-md mx-auto">
                <!-- Nama Kategori -->
                <div class="mb-8">
                    <label class="block text-gray-800 font-semibold mb-3" for="nama_kategori">
                        <i class="fas fa-tag text-primary mr-2"></i>Nama Kategori <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <input type="text" name="nama_kategori" id="nama_kategori" required
                               value="{{ old('nama_kategori') }}"
                               class="w-full px-4 py-3 pl-11 border-2 border-gray-300 rounded-lg focus:outline-none focus:border-primary transition-all duration-300"
                               placeholder="Contoh: Suplemen, Pakaian, Aksesoris">
                        <div class="absolute left-3 top-1/2 transform -translate-y-1/2">
                            <i class="fas fa-folder text-gray-400"></i>
                        </div>
                    </div>
                    @error('nama_kategori')
                        <div class="mt-2 text-sm text-red-600 bg-red-50 p-3 rounded-lg border border-red-200">
                            <i class="fas fa-exclamation-circle mr-2"></i>{{ $message }}
                        </div>
                    @enderror
                </div>
                
                <div class="mt-10 pt-6 border-t border-gray-200">
                    <div class="flex justify-end space-x-4">
                        <a href="{{ route('admin.categories.index') }}" 
                           class="px-6 py-3 bg-gradient-to-r from-gray-200 to-gray-300 hover:from-gray-300 hover:to-gray-400 text-gray-800 font-semibold rounded-lg transition-all duration-300 transform hover:-translate-y-1 shadow-md hover:shadow-lg flex items-center">
                            <i class="fas fa-times mr-2"></i> Batal
                        </a>
                        <button type="submit"
                                class="px-6 py-3 bg-gradient-to-r from-primary to-secondary hover:from-primary-light hover:to-accent text-white font-semibold rounded-lg transition-all duration-300 transform hover:-translate-y-1 shadow-md hover:shadow-lg flex items-center group">
                            <i class="fas fa-save mr-2 group-hover:rotate-12 transition-transform"></i> Simpan Kategori
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection