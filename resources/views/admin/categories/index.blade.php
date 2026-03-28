@extends('layouts.app')

@section('title', 'Kelola Kategori')
@section('page-title', 'Kelola Kategori Produk')

@section('sidebar')
@include('admin.partials.sidebar')
@endsection

@section('content')
<!-- Header Stats - Updated with dashboard style -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
    <!-- Total Kategori -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500 mb-1">Total Kategori</p>
                <p class="text-2xl font-bold text-gray-800">{{ $categories->count() }}</p>
            </div>
            <div class="w-12 h-12 bg-purple-50 rounded-xl flex items-center justify-center">
                <i class="fas fa-tags text-[#27124A] text-xl"></i>
            </div>
        </div>
        <div class="mt-4 flex items-center text-xs text-gray-500">
            <span class="text-green-500 mr-1">↑</span> Total kategori tersedia
        </div>
    </div>
    
    <!-- Total Produk -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500 mb-1">Total Produk</p>
                <p class="text-2xl font-bold text-gray-800">{{ $categories->sum('products_count') }}</p>
            </div>
            <div class="w-12 h-12 bg-blue-50 rounded-xl flex items-center justify-center">
                <i class="fas fa-boxes text-[#27124A] text-xl"></i>
            </div>
        </div>
        <div class="mt-4 flex items-center text-xs text-gray-500">
            <span class="text-blue-500 mr-1">📦</span> Total produk dalam kategori
        </div>
    </div>
    
    <!-- Rata-rata Produk -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500 mb-1">Rata-rata Produk</p>
                <p class="text-2xl font-bold text-gray-800">{{ number_format($categories->avg('products_count'), 1) }}</p>
            </div>
            <div class="w-12 h-12 bg-green-50 rounded-xl flex items-center justify-center">
                <i class="fas fa-chart-bar text-[#27124A] text-xl"></i>
            </div>
        </div>
        <div class="mt-4 flex items-center text-xs text-gray-500">
            <span class="text-green-500 mr-1">📊</span> Rata-rata produk/kategori
        </div>
    </div>
    
    <!-- Kategori Populer -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500 mb-1">Kategori Populer</p>
                <p class="text-2xl font-bold text-gray-800">{{ $categories->max('products_count') }} produk</p>
            </div>
            <div class="w-12 h-12 bg-pink-50 rounded-xl flex items-center justify-center">
                <i class="fas fa-star text-[#27124A] text-xl"></i>
            </div>
        </div>
        <div class="mt-4 flex items-center text-xs text-gray-500">
            <span class="text-yellow-500 mr-1">⭐</span> Kategori dengan produk terbanyak
        </div>
    </div>
</div>

<!-- Main Content -->
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="p-6 border-b border-gray-100">
        <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-4">
            <div>
                <h3 class="text-lg font-semibold text-gray-800">Daftar Kategori Produk</h3>
                <p class="text-sm text-gray-500 mt-1">Kelola kategori untuk pengelompokan produk yang lebih terstruktur</p>
            </div>
            <div class="flex flex-wrap gap-3">
                <a href="{{ route('admin.products.index') }}" 
                   class="px-4 py-2.5 bg-gray-50 hover:bg-gray-100 text-gray-700 font-medium rounded-xl transition-all duration-300 flex items-center border border-gray-200">
                    <i class="fas fa-box mr-2 text-[#27124A]"></i> Kelola Produk
                </a>
                <a href="{{ route('admin.categories.create') }}" 
                   class="px-4 py-2.5 bg-[#27124A] hover:bg-[#3a1d6b] text-white font-medium rounded-xl transition-all duration-300 flex items-center shadow-sm hover:shadow-md">
                    <i class="fas fa-plus mr-2"></i> Tambah Kategori
                </a>
            </div>
        </div>
    </div>
    
    @if(session('success'))
    <div class="mx-6 mt-6 bg-green-50 border border-green-200 rounded-xl p-4">
        <div class="flex items-center">
            <div class="flex-shrink-0">
                <i class="fas fa-check-circle text-green-500 text-xl"></i>
            </div>
            <div class="ml-3">
                <p class="text-green-700 font-medium">{{ session('success') }}</p>
            </div>
        </div>
    </div>
    @endif
    
    @if(session('error'))
    <div class="mx-6 mt-6 bg-red-50 border border-red-200 rounded-xl p-4">
        <div class="flex items-center">
            <div class="flex-shrink-0">
                <i class="fas fa-exclamation-circle text-red-500 text-xl"></i>
            </div>
            <div class="ml-3">
                <p class="text-red-700 font-medium">{{ session('error') }}</p>
            </div>
        </div>
    </div>
    @endif
    
    <!-- Table -->
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-100">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-20">No</th>
                    <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Kategori</th>
                    <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jumlah Produk</th>
                    <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Dibuat</th>
                    <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-100">
                @foreach($categories as $category)
                <tr class="hover:bg-gray-50 transition-colors duration-150">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center justify-center w-8 h-8 bg-gray-100 rounded-lg text-gray-600 font-medium text-sm">
                            {{ $loop->iteration }}
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-normal break-words">
                        <div class="flex items-start">
                            <div class="flex-shrink-0 w-10 h-10 bg-purple-50 rounded-xl flex items-center justify-center mr-3">
                                <i class="fas fa-folder text-[#27124A]"></i>
                            </div>
                            <div class="min-w-0 flex-1">
                                <h4 class="font-medium text-gray-800 break-words">{{ $category->nama_kategori }}</h4>
                                <p class="text-xs text-gray-400 break-words">ID: {{ $category->id }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-normal break-words">
                        <div class="flex flex-col items-start min-w-0">
                            <span class="px-2.5 py-1.5 bg-purple-50 text-[#27124A] rounded-lg text-sm font-medium inline-flex items-center break-words">
                                <i class="fas fa-box mr-1 text-xs flex-shrink-0"></i> <span class="break-words">{{ $category->products_count }} produk</span>
                            </span>
                            @if($category->products_count > 0)
                            <div class="w-32 h-1.5 bg-gray-100 rounded-full overflow-hidden mt-2">
                                @php
                                    $percentage = ($category->products_count / max(1, $categories->sum('products_count'))) * 100;
                                @endphp
                                <div class="h-full bg-[#27124A] rounded-full" 
                                     style="width: {{ $percentage }}%"></div>
                            </div>
                            @endif
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-normal break-words">
                        <div class="flex flex-col min-w-0">
                            <span class="text-sm text-gray-700 break-words">{{ $category->created_at->format('d/m/Y') }}</span>
                            <span class="text-xs text-gray-400 break-words">{{ $category->created_at->format('H:i') }}</span>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center space-x-2">
                            <a href="{{ route('admin.categories.edit', $category->id) }}" 
                               class="p-2 bg-blue-50 hover:bg-blue-100 text-blue-600 rounded-lg transition-all duration-300 border border-blue-100 flex-shrink-0"
                               title="Edit Kategori">
                                <i class="fas fa-edit text-sm"></i>
                            </a>
                            
                            <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        class="p-2 bg-red-50 hover:bg-red-100 text-red-600 rounded-lg transition-all duration-300 border border-red-100 flex-shrink-0"
                                        onclick="return confirm('Yakin ingin menghapus kategori ini? Tindakan ini akan mempengaruhi ' + {{ $category->products_count }} + ' produk terkait.')"
                                        title="Hapus Kategori">
                                    <i class="fas fa-trash text-sm"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    
    @if($categories->isEmpty())
    <div class="p-12 text-center">
        <div class="inline-flex items-center justify-center w-20 h-20 bg-purple-50 rounded-full mb-4">
            <i class="fas fa-tags text-3xl text-[#27124A]"></i>
        </div>
        <h4 class="text-lg font-semibold text-gray-800 mb-2">Belum Ada Kategori</h4>
        <p class="text-gray-400 text-sm mb-6">Mulai dengan membuat kategori pertama untuk mengelompokkan produk</p>
        <a href="{{ route('admin.categories.create') }}" 
           class="inline-flex items-center px-5 py-2.5 bg-[#27124A] hover:bg-[#3a1d6b] text-white font-medium rounded-xl transition-all duration-300 shadow-sm hover:shadow-md">
            <i class="fas fa-plus mr-2"></i> Tambah Kategori Pertama
        </a>
    </div>
    @endif
</div>

<!-- Analytics Section -->
@if($categories->isNotEmpty())
<div class="mt-8 bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="p-6 border-b border-gray-100">
        <h3 class="text-lg font-semibold text-gray-800">Distribusi Produk per Kategori</h3>
        <p class="text-sm text-gray-500 mt-1">Analisis penyebaran produk dalam setiap kategori</p>
    </div>
    
    <div class="p-6">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($categories->sortByDesc('products_count') as $category)
            <div class="bg-gray-50/50 border border-gray-100 rounded-xl p-5 hover:shadow-sm transition-shadow duration-300">
                <div class="flex justify-between items-start mb-4">
                    <div class="min-w-0 flex-1">
                        <h4 class="font-medium text-gray-800 break-words">{{ $category->nama_kategori }}</h4>
                        <div class="flex items-center mt-1 flex-wrap">
                            <span class="text-sm font-medium text-[#27124A] break-words">{{ $category->products_count }} produk</span>
                            <span class="mx-2 text-gray-300 flex-shrink-0">•</span>
                            <span class="text-sm text-gray-400 break-words">
                                {{ number_format(($category->products_count / max(1, $categories->sum('products_count'))) * 100, 1) }}%
                            </span>
                        </div>
                    </div>
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 bg-purple-50 rounded-xl flex items-center justify-center">
                            <i class="fas fa-folder text-[#27124A]"></i>
                        </div>
                    </div>
                </div>
                
                <!-- Progress Bar -->
                <div class="mb-4">
                    <div class="flex justify-between text-xs text-gray-400 mb-1 flex-wrap">
                        <span>Progress</span>
                        <span class="break-words">{{ $category->products_count }}/{{ $categories->sum('products_count') }}</span>
                    </div>
                    <div class="w-full h-1.5 bg-gray-100 rounded-full overflow-hidden">
                        @php
                            $percentage = ($category->products_count / max(1, $categories->sum('products_count'))) * 100;
                        @endphp
                        <div class="h-full bg-[#27124A] rounded-full" 
                             style="width: {{ $percentage }}%"></div>
                    </div>
                </div>
                
                @if($category->products_count > 0)
                <div class="border-t border-gray-200 pt-4 mt-4">
                    <h5 class="text-xs font-medium text-gray-500 uppercase tracking-wider mb-3">Contoh Produk:</h5>
                    <div class="space-y-2">
                        @foreach($category->products->take(3) as $product)
                        <div class="flex items-center justify-between text-sm p-2 bg-white rounded-lg border border-gray-100">
                            <span class="font-medium text-gray-700 truncate break-words flex-1 mr-2">{{ $product->nama_produk }}</span>
                            <span class="font-medium text-[#27124A] whitespace-nowrap flex-shrink-0">Rp {{ number_format($product->harga, 0, ',', '.') }}</span>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>
            @endforeach
        </div>
    </div>
</div>
@endif
@endsection

@push('styles')
<style>
    /* Custom styles for better appearance */
    table tbody tr {
        transition: all 0.2s ease;
    }
    
    table tbody tr:hover {
        background-color: #fafafa;
    }
    
    .progress-bar {
        transition: width 0.6s ease;
    }
    
    /* Custom color for #27124A */
    .bg-primary-custom {
        background-color: #27124A;
    }
    
    .text-primary-custom {
        color: #27124A;
    }
    
    .border-primary-custom {
        border-color: #27124A;
    }
    
    .hover\:bg-primary-custom:hover {
        background-color: #27124A;
    }
    
    /* Word break utilities */
    .break-words {
        word-break: break-word;
        overflow-wrap: break-word;
        hyphens: auto;
    }
    
    td {
        max-width: 300px;
    }
</style>
@endpush