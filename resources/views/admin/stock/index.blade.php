@extends('layouts.app')

@section('title', 'Kelola Stok')
@section('page-title', 'Kelola Stok Produk')

@section('sidebar')
@include('admin.partials.sidebar')
@endsection

@section('content')
<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition-all duration-300">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500 mb-1">Total Produk</p>
                <p class="text-2xl font-bold text-gray-800">{{ $products->count() }}</p>
            </div>
            <div class="w-12 h-12 bg-purple-50 rounded-xl flex items-center justify-center">
                <i class="fas fa-boxes text-[#27124A] text-xl"></i>
            </div>
        </div>
        <div class="mt-4 flex items-center text-xs text-gray-500">
            <span class="text-purple-500 mr-1">📦</span> Semua produk dalam inventaris
        </div>
    </div>
    
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition-all duration-300">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500 mb-1">Total Stok</p>
                <p class="text-2xl font-bold text-gray-800">{{ number_format($totalStock, 0, ',', '.') }}</p>
            </div>
            <div class="w-12 h-12 bg-blue-50 rounded-xl flex items-center justify-center">
                <i class="fas fa-box-open text-[#27124A] text-xl"></i>
            </div>
        </div>
        <div class="mt-4 flex items-center text-xs text-gray-500">
            <span class="text-blue-500 mr-1">📊</span> Semua stok terkumpul
        </div>
    </div>
    
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition-all duration-300">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500 mb-1">Stok Rendah</p>
                <p class="text-2xl font-bold text-gray-800">{{ $lowStock }}</p>
            </div>
            <div class="w-12 h-12 bg-yellow-50 rounded-xl flex items-center justify-center">
                <i class="fas fa-exclamation-triangle text-[#27124A] text-xl"></i>
            </div>
        </div>
        <div class="mt-4 flex items-center text-xs text-gray-500">
            <span class="text-yellow-500 mr-1">⚠️</span> Perlu segera di-restock
        </div>
    </div>
    
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition-all duration-300">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500 mb-1">Stok Habis</p>
                <p class="text-2xl font-bold text-gray-800">{{ $outOfStock }}</p>
            </div>
            <div class="w-12 h-12 bg-red-50 rounded-xl flex items-center justify-center">
                <i class="fas fa-times-circle text-[#27124A] text-xl"></i>
            </div>
        </div>
        <div class="mt-4 flex items-center text-xs text-gray-500">
            <span class="text-red-500 mr-1">🚫</span> Stok kosong, segera isi
        </div>
    </div>
</div>

@if($totalValue > 0)
<div class="bg-gradient-to-r from-[#27124A] to-[#3a1d6b] rounded-2xl shadow-sm p-6 mb-8">
    <div class="flex items-center justify-between flex-wrap gap-4">
        <div class="flex items-center min-w-0 flex-1">
            <div class="bg-white/10 p-4 rounded-xl flex-shrink-0">
                <i class="fas fa-money-bill-wave text-white text-2xl"></i>
            </div>
            <div class="ml-5 min-w-0 flex-1">
                <h3 class="text-white text-sm font-medium opacity-90 break-words">Nilai Total Stok</h3>
                <p class="text-white text-3xl font-bold break-words">Rp {{ number_format($totalValue, 0, ',', '.') }}</p>
            </div>
        </div>
        <div class="text-right">
            <div class="text-white text-sm opacity-90 break-words">Rata-rata per Produk</div>
            <div class="text-white text-xl font-bold break-words">
                Rp {{ number_format($products->count() > 0 ? $totalValue / $products->count() : 0, 0, ',', '.') }}
            </div>
        </div>
    </div>
</div>
@endif

<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden mb-8">
    <div class="p-6 border-b border-gray-100">
        <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-4">
            <div>
                <h3 class="text-xl font-bold text-gray-800">Stok Produk</h3>
                <p class="text-gray-600 mt-1">Kelola stok semua produk dalam inventaris gym</p>
            </div>
            <div class="flex flex-wrap gap-3">
                <a href="{{ route('admin.stock.log') }}" 
                   class="px-4 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-800 font-semibold rounded-xl transition-all duration-300 transform hover:-translate-y-1 shadow-sm hover:shadow-md flex items-center border border-gray-200">
                    <i class="fas fa-history mr-2"></i> Log Stok
                </a>
            </div>
        </div>
    </div>
    
    @if(session('success'))
    <div class="mx-6 mt-6 mb-4 bg-green-50 border-l-4 border-green-500 rounded-lg p-4 shadow-sm">
        <div class="flex items-center">
            <div class="flex-shrink-0">
                <i class="fas fa-check-circle text-green-500 text-lg"></i>
            </div>
            <div class="ml-3">
                <p class="text-green-700 font-medium">{{ session('success') }}</p>
            </div>
            <button type="button" class="ml-auto text-green-400 hover:text-green-600" onclick="this.closest('.mx-6').style.display='none'">
                <i class="fas fa-times"></i>
            </button>
        </div>
    </div>
    @endif
    
    @if(session('error'))
    <div class="mx-6 mt-6 mb-4 bg-red-50 border-l-4 border-red-500 rounded-lg p-4 shadow-sm">
        <div class="flex items-center">
            <div class="flex-shrink-0">
                <i class="fas fa-exclamation-circle text-red-500 text-lg"></i>
            </div>
            <div class="ml-3">
                <p class="text-red-700 font-medium">{{ session('error') }}</p>
            </div>
            <button type="button" class="ml-auto text-red-400 hover:text-red-600" onclick="this.closest('.mx-6').style.display='none'">
                <i class="fas fa-times"></i>
            </button>
        </div>
    </div>
    @endif
    
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-100">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-16">No</th>
                    <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Produk</th>
                    <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kategori</th>
                    <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Harga</th>
                    <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Stok</th>
                    <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status Stok</th>
                    <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nilai Stok</th>
                    <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-100">
                @foreach($products as $product)
                @php
                    $nilaiStok = $product->harga * $product->stok;
                    $statusStok = $product->stok <= 0 ? 'habis' : ($product->stok <= 10 ? 'rendah' : 'aman');
                    $statusColor = [
                        'aman' => 'bg-green-50 text-green-700 border-green-200',
                        'rendah' => 'bg-yellow-50 text-yellow-700 border-yellow-200',
                        'habis' => 'bg-red-50 text-red-700 border-red-200'
                    ][$statusStok];
                @endphp
                <tr class="hover:bg-gray-50 transition-colors duration-150">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center justify-center w-8 h-8 bg-gray-100 rounded-lg text-gray-600 font-medium text-sm">
                            {{ $loop->iteration }}
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-normal break-words">
                        <div class="flex items-start">
                            <div class="flex-shrink-0 w-10 h-10 bg-purple-50 rounded-xl flex items-center justify-center mr-3">
                                <i class="fas fa-box text-[#27124A]"></i>
                            </div>
                            <div class="min-w-0 flex-1">
                                <h4 class="font-medium text-gray-800 break-words">{{ $product->nama_produk }}</h4>
                                @if($product->deskripsi)
                                    <p class="text-xs text-gray-400 mt-1 break-words">{{ Str::limit($product->deskripsi, 50) }}</p>
                                @endif
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-normal break-words">
                        <span class="px-3 py-1.5 bg-purple-50 rounded-lg text-sm font-medium inline-flex items-center border border-purple-100">
                            <i class="fas fa-tag mr-2 text-xs text-[#27124A]"></i>
                            <span>{{ $product->category->nama_kategori ?? 'Tidak Berkategori' }}</span>
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-normal break-words">
                        <div class="bg-green-50 border border-green-100 rounded-xl p-3">
                            <div class="font-bold text-[#27124A] break-words">Rp {{ number_format($product->harga, 0, ',', '.') }}</div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-normal break-words">
                        <div class="flex items-center">
                            <div class="w-8 h-8 {{ $product->stok > 10 ? 'bg-green-50' : ($product->stok > 0 ? 'bg-yellow-50' : 'bg-red-50') }} rounded-lg flex items-center justify-center mr-2">
                                <i class="fas fa-cubes {{ $product->stok > 10 ? 'text-green-600' : ($product->stok > 0 ? 'text-yellow-600' : 'text-red-600') }} text-sm"></i>
                            </div>
                            <div>
                                <div class="text-sm font-medium text-gray-700">{{ number_format($product->stok, 0, ',', '.') }} pcs</div>
                                @if($product->stok <= 10 && $product->stok > 0)
                                    <div class="text-xs text-yellow-600">Stok menipis</div>
                                @elseif($product->stok == 0)
                                    <div class="text-xs text-red-600">Stok habis</div>
                                @endif
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-normal break-words">
                        @if($statusStok == 'aman')
                            <div class="flex items-center text-green-600">
                                <div class="w-2 h-2 bg-green-500 rounded-full mr-2"></div>
                                <span class="font-medium">Aman</span>
                            </div>
                        @elseif($statusStok == 'rendah')
                            <div class="flex items-center text-yellow-600">
                                <div class="w-2 h-2 bg-yellow-500 rounded-full mr-2 animate-pulse"></div>
                                <span class="font-medium">Rendah</span>
                            </div>
                        @else
                            <div class="flex items-center text-red-600">
                                <div class="w-2 h-2 bg-red-500 rounded-full mr-2"></div>
                                <span class="font-medium">Habis</span>
                            </div>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-normal break-words">
                        <div class="font-bold text-purple-600 break-words">Rp {{ number_format($nilaiStok, 0, ',', '.') }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center space-x-2">
                            <a href="{{ route('admin.stock.create', $product->id) }}" 
                               class="p-2 bg-green-50 hover:bg-green-100 text-green-600 rounded-lg transition-all duration-300 border border-green-100"
                               title="Kelola Stok">
                                <i class="fas fa-warehouse text-sm"></i>
                            </a>
                            <a href="{{ route('admin.products.edit', $product->id) }}" 
                               class="p-2 bg-blue-50 hover:bg-blue-100 text-blue-600 rounded-lg transition-all duration-300 border border-blue-100"
                               title="Edit Produk">
                                <i class="fas fa-edit text-sm"></i>
                            </a>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    
    @if($products->isEmpty())
    <div class="p-12 text-center">
        <div class="inline-flex items-center justify-center w-20 h-20 bg-purple-50 rounded-full mb-4">
            <i class="fas fa-boxes text-3xl text-[#27124A]"></i>
        </div>
        <h4 class="text-lg font-semibold text-gray-800 mb-2">Belum Ada Produk</h4>
        <p class="text-gray-400 text-sm mb-6">Mulai dengan menambahkan produk ke inventaris gym</p>
        <a href="{{ route('admin.products.create') }}" 
           class="inline-flex items-center px-5 py-2.5 bg-[#27124A] hover:bg-[#3a1d6b] text-white font-medium rounded-xl transition-all duration-300 shadow-sm hover:shadow-md">
            <i class="fas fa-plus mr-2"></i> Tambah Produk
        </a>
    </div>
    @endif
</div>

@php
    $lowStockProducts = $products->filter(function($product) {
        return $product->stok <= 10;
    });
@endphp

@if($lowStockProducts->count() > 0)
<div class="bg-yellow-50 border border-yellow-200 rounded-2xl shadow-sm overflow-hidden">
    <div class="p-6 border-b border-yellow-200">
        <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-4">
            <div class="flex items-center min-w-0 flex-1">
                <div class="w-10 h-10 bg-yellow-100 rounded-xl flex items-center justify-center mr-4 flex-shrink-0">
                    <i class="fas fa-exclamation-triangle text-yellow-600"></i>
                </div>
                <div class="min-w-0 flex-1">
                    <h3 class="text-lg font-semibold text-yellow-800 break-words">Produk dengan Stok Rendah/Habis</h3>
                    <p class="text-sm text-yellow-700 break-words">Segera restock produk berikut untuk menjaga ketersediaan</p>
                </div>
            </div>
            <span class="px-4 py-2 bg-yellow-100 text-yellow-800 rounded-xl text-sm font-semibold border border-yellow-200 flex-shrink-0">
                {{ $lowStockProducts->count() }} Produk
            </span>
        </div>
    </div>
    
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-yellow-200">
            <thead class="bg-yellow-100">
                <tr>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-yellow-800 uppercase tracking-wider">Produk</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-yellow-800 uppercase tracking-wider">Stok</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-yellow-800 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-yellow-800 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-yellow-50 divide-y divide-yellow-200">
                @foreach($lowStockProducts->sortBy('stok') as $product)
                <tr class="hover:bg-yellow-100 transition-colors duration-150">
                    <td class="px-6 py-4 whitespace-normal break-words">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 w-10 h-10 bg-purple-50 rounded-xl flex items-center justify-center mr-3">
                                <i class="fas fa-box text-[#27124A]"></i>
                            </div>
                            <div class="min-w-0 flex-1">
                                <div class="font-medium text-yellow-900 break-words">{{ $product->nama_produk }}</div>
                                <div class="text-xs text-yellow-700 break-words">{{ $product->category->nama_kategori ?? '-' }}</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-normal break-words">
                        <span class="px-3 py-1.5 rounded-lg text-sm font-medium
                            {{ $product->stok == 0 ? 'bg-red-100 text-red-700 border border-red-200' : 'bg-yellow-100 text-yellow-700 border border-yellow-200' }} inline-block">
                            {{ number_format($product->stok, 0, ',', '.') }} pcs
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-normal break-words">
                        @if($product->stok == 0)
                            <div class="flex items-center text-red-600">
                                <div class="w-2 h-2 bg-red-500 rounded-full mr-2"></div>
                                <span class="font-medium">Habis</span>
                            </div>
                        @else
                            <div class="flex items-center text-yellow-600">
                                <div class="w-2 h-2 bg-yellow-500 rounded-full mr-2 animate-pulse"></div>
                                <span class="font-medium">Rendah</span>
                            </div>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <a href="{{ route('admin.stock.create', $product->id) }}" 
                           class="inline-flex items-center px-3 py-1.5 bg-[#27124A] hover:bg-[#3a1d6e] text-white font-medium rounded-lg transition-all duration-300 shadow-sm hover:shadow-md text-sm">
                            <i class="fas fa-plus-circle mr-1"></i> Tambah Stok
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endif
@endsection

@push('styles')
<style>
    .overflow-x-auto {
        scrollbar-width: thin;
        scrollbar-color: #27124A #e5e7eb;
    }
    
    .overflow-x-auto::-webkit-scrollbar {
        height: 6px;
    }
    
    .overflow-x-auto::-webkit-scrollbar-track {
        background: #e5e7eb;
        border-radius: 3px;
    }
    
    .overflow-x-auto::-webkit-scrollbar-thumb {
        background-color: #422b66;
        border-radius: 3px;
    }
    
    table tbody tr {
        transition: all 0.2s ease;
    }
    
    .break-words {
        word-break: break-word;
        overflow-wrap: break-word;
        hyphens: auto;
    }
    
    td {
        max-width: 300px;
    }
    
    [onclick*="this.closest"]:hover {
        opacity: 0.7;
    }
    
    .progress-bar {
        transition: width 0.6s ease;
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const alerts = document.querySelectorAll('.border-l-4');
        alerts.forEach(alert => {
            setTimeout(() => {
                if (alert) {
                    alert.style.opacity = '0';
                    alert.style.transition = 'opacity 0.5s ease';
                    setTimeout(() => {
                        if (alert) alert.style.display = 'none';
                    }, 500);
                }
            }, 5000);
        });
    });
</script>
@endpush