@extends('layouts.app')

@section('title', 'Edit Kategori')
@section('page-title', 'Edit Kategori')

@section('sidebar')
@include('admin.partials.sidebar')
@endsection

@section('content')
<div class="bg-gradient-to-r from-primary to-primary-dark text-white rounded-xl shadow-lg overflow-hidden mb-6">
    <div class="px-6 py-4">
        <div class="flex justify-between items-center">
            <div>
                <h3 class="text-lg font-bold">Form Edit Kategori</h3>
                <p class="text-sm opacity-90">Perbarui informasi kategori produk</p>
            </div>
            <div class="bg-white bg-opacity-20 px-3 py-1 rounded-lg">
                <span class="font-mono text-sm">ID: {{ $category->id }}</span>
            </div>
        </div>
    </div>
</div>

<div class="bg-white rounded-xl shadow-lg border border-gray-200 overflow-hidden">
    <div class="p-6">
        <form action="{{ route('admin.categories.update', $category->id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="max-w-md mx-auto">
                <div class="mb-8">
                    <label class="block text-gray-800 font-semibold mb-3" for="nama_kategori">
                        <i class="fas fa-tag text-primary mr-2"></i>Nama Kategori <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <input type="text" name="nama_kategori" id="nama_kategori" required
                               value="{{ old('nama_kategori', $category->nama_kategori) }}"
                               class="w-full px-4 py-3 pl-11 border-2 border-gray-300 rounded-lg focus:outline-none focus:border-primary transition-all duration-300">
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
                
                @if($category->products_count > 0)
                <div class="mb-8 bg-gradient-to-r from-yellow-50 to-amber-50 border border-yellow-200 rounded-xl p-5">
                    <div class="flex items-start">
                        <div class="flex-shrink-0 bg-gradient-to-r from-yellow-400 to-amber-400 p-3 rounded-lg shadow-md">
                            <i class="fas fa-exclamation-triangle text-white text-xl"></i>
                        </div>
                        <div class="ml-5">
                            <h4 class="font-bold text-yellow-800 mb-2">Perhatian Penting!</h4>
                            <div class="space-y-2 text-yellow-700">
                                <div class="flex items-start">
                                    <i class="fas fa-box text-yellow-500 mt-1 mr-2"></i>
                                    <p>Kategori ini digunakan oleh <span class="font-bold bg-yellow-100 px-2 py-1 rounded">{{ $category->products_count }} produk</span></p>
                                </div>
                                <div class="flex items-start">
                                    <i class="fas fa-sync-alt text-yellow-500 mt-1 mr-2"></i>
                                    <p>Mengubah nama kategori akan mempengaruhi semua produk yang terkait</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
                
                <div class="mt-10 pt-6 border-t border-gray-200">
                    <div class="flex justify-end space-x-4">
                        <a href="{{ route('admin.categories.index') }}" 
                           class="px-6 py-3 bg-gradient-to-r from-gray-200 to-gray-300 hover:from-gray-300 hover:to-gray-400 text-gray-800 font-semibold rounded-lg transition-all duration-300 transform hover:-translate-y-1 shadow-md hover:shadow-lg flex items-center">
                            <i class="fas fa-times mr-2"></i> Batal
                        </a>
                        <button type="submit"
                                class="px-6 py-3 bg-gradient-to-r from-primary to-secondary hover:from-primary-light hover:to-accent text-white font-semibold rounded-lg transition-all duration-300 transform hover:-translate-y-1 shadow-md hover:shadow-lg flex items-center group">
                            <i class="fas fa-sync-alt mr-2 group-hover:rotate-180 transition-transform"></i> Update Kategori
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

@if($category->products_count > 0)
<div class="mt-8 bg-white rounded-xl shadow-lg border border-gray-200 overflow-hidden">
    <div class="bg-gradient-to-r from-primary to-primary-dark px-6 py-4">
        <div class="flex justify-between items-center">
            <h3 class="text-lg font-bold text-white">Produk dalam Kategori "{{ $category->nama_kategori }}"</h3>
            <span class="bg-white bg-opacity-20 px-3 py-1 rounded-lg text-white text-sm font-semibold">
                {{ $category->products_count }} Produk
            </span>
        </div>
    </div>
    
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">No</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Nama Produk</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Harga</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Stok</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Status</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($category->products as $product)
                <tr class="hover:bg-gray-50 transition-colors duration-150">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center justify-center w-8 h-8 bg-gray-100 rounded-full text-gray-700 font-semibold">
                            {{ $loop->iteration }}
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="font-medium text-gray-900">{{ $product->nama_produk }}</div>
                        <div class="text-sm text-gray-500 mt-1">{{ Str::limit($product->deskripsi, 50) }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="font-bold text-primary">Rp {{ number_format($product->harga, 0, ',', '.') }}</span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-3 py-1 rounded-full text-sm font-medium
                            {{ $product->stok > 10 ? 'bg-green-100 text-green-800 border border-green-200' : 
                               ($product->stok > 0 ? 'bg-yellow-100 text-yellow-800 border border-yellow-200' : 
                               'bg-red-100 text-red-800 border border-red-200') }}">
                            {{ $product->stok }} pcs
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-3 py-1 rounded-full text-sm font-medium
                            {{ $product->status ? 'bg-green-100 text-green-800 border border-green-200' : 
                               'bg-red-100 text-red-800 border border-red-200' }}">
                            {{ $product->status ? 'Aktif' : 'Nonaktif' }}
                        </span>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endif
@endsection