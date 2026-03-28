@extends('layouts.app')

@section('title', 'Tambah Produk')
@section('page-title', 'Tambah Produk Baru')

@section('sidebar')
@include('admin.partials.sidebar')
@endsection

@section('content')
<!-- Header Card -->
<div class="bg-[#27124A] text-white rounded-2xl shadow-sm overflow-hidden mb-6">
    <div class="px-6 py-4">
        <h3 class="text-lg font-bold">Form Tambah Produk</h3>
        <p class="text-sm text-purple-200">Tambah produk baru ke dalam inventaris gym</p>
    </div>
</div>

<!-- TAMPILKAN SEMUA ERROR VALIDASI -->
@if($errors->any())
<div class="bg-red-50 border-l-4 border-red-500 rounded-xl p-4 mb-6">
    <div class="flex items-start">
        <div class="flex-shrink-0">
            <i class="fas fa-exclamation-circle text-red-500 text-xl"></i>
        </div>
        <div class="ml-3">
            <h3 class="text-sm font-medium text-red-800">Terjadi kesalahan:</h3>
            <ul class="mt-2 text-sm text-red-700 list-disc list-inside">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    </div>
</div>
@endif

<!-- TAMPILKAN SESSION ERROR -->
@if(session('error'))
<div class="bg-red-50 border-l-4 border-red-500 rounded-xl p-4 mb-6">
    <div class="flex items-start">
        <div class="flex-shrink-0">
            <i class="fas fa-exclamation-circle text-red-500 text-xl"></i>
        </div>
        <div class="ml-3">
            <p class="text-sm text-red-700">{{ session('error') }}</p>
        </div>
    </div>
</div>
@endif

<!-- Main Form -->
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden mb-8">
    <div class="p-6">
        <form action="{{ route('admin.products.store') }}" method="POST">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Nama Produk -->
                <div>
                    <label class="block text-gray-800 font-semibold mb-3" for="nama_produk">
                        <i class="fas fa-box text-[#27124A] mr-2"></i>Nama Produk <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <input type="text" name="nama_produk" id="nama_produk" required
                               value="{{ old('nama_produk') }}"
                               class="w-full px-4 py-3 pl-11 border {{ $errors->has('nama_produk') ? 'border-red-300 bg-red-50' : 'border-gray-200' }} rounded-xl focus:outline-none focus:border-[#27124A] focus:ring-2 focus:ring-purple-200 transition-all duration-300"
                               placeholder="Masukkan nama produk">
                        <div class="absolute left-3 top-1/2 transform -translate-y-1/2">
                            <i class="fas fa-box text-gray-400"></i>
                        </div>
                    </div>
                    @error('nama_produk')
                        <div class="mt-2 text-sm text-red-600 bg-red-50 p-3 rounded-xl border border-red-100">
                            <i class="fas fa-exclamation-circle mr-2"></i>{{ $message }}
                        </div>
                    @enderror
                </div>
                
                <!-- Kategori -->
                <div>
                    <label class="block text-gray-800 font-semibold mb-3" for="kategori">
                        <i class="fas fa-tags text-[#27124A] mr-2"></i>Kategori <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <select name="kategori" id="kategori" required
                                class="w-full px-4 py-3 pl-11 border {{ $errors->has('kategori') ? 'border-red-300 bg-red-50' : 'border-gray-200' }} rounded-xl focus:outline-none focus:border-[#27124A] focus:ring-2 focus:ring-purple-200 transition-all duration-300 appearance-none">
                            <option value="">Pilih Kategori</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('kategori') == $category->id ? 'selected' : '' }}>
                                    {{ $category->nama_kategori }}
                                </option>
                            @endforeach
                        </select>
                        <div class="absolute left-3 top-1/2 transform -translate-y-1/2">
                            <i class="fas fa-tag text-gray-400"></i>
                        </div>
                        <div class="absolute right-3 top-1/2 transform -translate-y-1/2">
                            <i class="fas fa-chevron-down text-gray-400"></i>
                        </div>
                    </div>
                    @error('kategori')
                        <div class="mt-2 text-sm text-red-600 bg-red-50 p-3 rounded-xl border border-red-100">
                            <i class="fas fa-exclamation-circle mr-2"></i>{{ $message }}
                        </div>
                    @enderror
                </div>
                
                <!-- Harga -->
                <div>
                    <label class="block text-gray-800 font-semibold mb-3" for="harga">
                        <i class="fas fa-money-bill-wave text-[#27124A] mr-2"></i>Harga (Rp) <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <input type="number" name="harga" id="harga" required min="0"
                               value="{{ old('harga') }}"
                               class="w-full px-4 py-3 pl-11 border {{ $errors->has('harga') ? 'border-red-300 bg-red-50' : 'border-gray-200' }} rounded-xl focus:outline-none focus:border-[#27124A] focus:ring-2 focus:ring-purple-200 transition-all duration-300"
                               placeholder="Masukkan harga">
                        <div class="absolute left-3 top-1/2 transform -translate-y-1/2">
                            <i class="fas fa-money-bill text-gray-400"></i>
                        </div>
                    </div>
                    @error('harga')
                        <div class="mt-2 text-sm text-red-600 bg-red-50 p-3 rounded-xl border border-red-100">
                            <i class="fas fa-exclamation-circle mr-2"></i>{{ $message }}
                        </div>
                    @enderror
                </div>
                
                <!-- Stok -->
                <div>
                    <label class="block text-gray-800 font-semibold mb-3" for="stok">
                        <i class="fas fa-warehouse text-[#27124A] mr-2"></i>Stok Awal <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <input type="number" name="stok" id="stok" required min="0"
                               value="{{ old('stok', 0) }}"
                               class="w-full px-4 py-3 pl-11 border {{ $errors->has('stok') ? 'border-red-300 bg-red-50' : 'border-gray-200' }} rounded-xl focus:outline-none focus:border-[#27124A] focus:ring-2 focus:ring-purple-200 transition-all duration-300"
                               placeholder="Masukkan stok awal">
                        <div class="absolute left-3 top-1/2 transform -translate-y-1/2">
                            <i class="fas fa-boxes text-gray-400"></i>
                        </div>
                    </div>
                    @error('stok')
                        <div class="mt-2 text-sm text-red-600 bg-red-50 p-3 rounded-xl border border-red-100">
                            <i class="fas fa-exclamation-circle mr-2"></i>{{ $message }}
                        </div>
                    @enderror
                </div>
                
                <!-- Deskripsi -->
                <div class="md:col-span-2">
                    <label class="block text-gray-800 font-semibold mb-3" for="deskripsi">
                        <i class="fas fa-align-left text-[#27124A] mr-2"></i>Deskripsi Produk
                    </label>
                    <div class="relative">
                        <textarea name="deskripsi" id="deskripsi" rows="4"
                                  class="w-full px-4 py-3 pl-11 border {{ $errors->has('deskripsi') ? 'border-red-300 bg-red-50' : 'border-gray-200' }} rounded-xl focus:outline-none focus:border-[#27124A] focus:ring-2 focus:ring-purple-200 transition-all duration-300 resize-none"
                                  placeholder="Masukkan deskripsi produk">{{ old('deskripsi') }}</textarea>
                        <div class="absolute left-3 top-4">
                            <i class="fas fa-align-left text-gray-400"></i>
                        </div>
                    </div>
                    @error('deskripsi')
                        <div class="mt-2 text-sm text-red-600 bg-red-50 p-3 rounded-xl border border-red-100">
                            <i class="fas fa-exclamation-circle mr-2"></i>{{ $message }}
                        </div>
                    @enderror
                </div>
                
                <!-- Status -->
                <div class="md:col-span-2">
                    <div class="flex items-center p-4 bg-gray-50 rounded-xl border border-gray-100">
                        <input type="checkbox" name="status" id="status" value="1" {{ old('status', true) ? 'checked' : '' }}
                               class="h-5 w-5 text-[#27124A] focus:ring-purple-200 border-gray-300 rounded transition-all duration-300">
                        <label for="status" class="ml-3 block text-gray-800 font-semibold">
                            <i class="fas fa-toggle-on text-[#27124A] mr-2"></i>Aktifkan produk setelah dibuat
                        </label>
                    </div>
                </div>
            </div>
            
            <!-- Action Buttons -->
            <div class="mt-10 pt-8 border-t border-gray-100">
                <div class="flex flex-col md:flex-row justify-between items-center space-y-4 md:space-y-0">
                    <div class="text-sm text-gray-500">
                        <i class="fas fa-info-circle text-[#27124A] mr-2"></i>
                        Stok awal akan otomatis tercatat sebagai stok masuk di log stok
                    </div>
                    <div class="flex space-x-4">
                        <a href="{{ route('admin.products.index') }}" 
                           class="px-6 py-3 bg-gray-100 hover:bg-gray-200 text-gray-800 font-semibold rounded-xl transition-all duration-300 transform hover:-translate-y-1 shadow-sm hover:shadow-md flex items-center">
                            <i class="fas fa-times mr-2"></i> Batal
                        </a>
                        <button type="submit"
                                class="px-6 py-3 bg-[#27124A] hover:bg-[#1a0d33] text-white font-semibold rounded-xl transition-all duration-300 transform hover:-translate-y-1 shadow-sm hover:shadow-md flex items-center">
                            <i class="fas fa-save mr-2"></i> Simpan Produk
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection