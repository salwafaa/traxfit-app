@extends('layouts.app')

@section('title', 'Kelola Produk')
@section('page-title', 'Kelola Produk')

@section('sidebar')
@include('admin.partials.sidebar')
@endsection

@section('content')
<!-- Stats Cards -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
    <!-- Total Produk -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
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
    
    <!-- Produk Aktif -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500 mb-1">Produk Aktif</p>
                <p class="text-2xl font-bold text-gray-800">{{ $products->where('status', true)->count() }}</p>
            </div>
            <div class="w-12 h-12 bg-green-50 rounded-xl flex items-center justify-center">
                <i class="fas fa-check-circle text-[#27124A] text-xl"></i>
            </div>
        </div>
        <div class="mt-4 flex items-center text-xs text-gray-500">
            <span class="text-green-500 mr-1">✅</span> Siap dijual
        </div>
    </div>
    
    <!-- Total Stok -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500 mb-1">Total Stok</p>
                <p class="text-2xl font-bold text-gray-800">{{ number_format($products->sum('stok'), 0, ',', '.') }}</p>
            </div>
            <div class="w-12 h-12 bg-blue-50 rounded-xl flex items-center justify-center">
                <i class="fas fa-warehouse text-[#27124A] text-xl"></i>
            </div>
        </div>
        <div class="mt-4 flex items-center text-xs text-gray-500">
            <span class="text-blue-500 mr-1">📊</span> Semua item dalam stok
        </div>
    </div>
    
    <!-- Nilai Stok -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500 mb-1">Nilai Stok</p>
                <p class="text-2xl font-bold text-gray-800">Rp {{ number_format($products->sum(function($p) { return $p->harga * $p->stok; }), 0, ',', '.') }}</p>
            </div>
            <div class="w-12 h-12 bg-pink-50 rounded-xl flex items-center justify-center">
                <i class="fas fa-money-bill-wave text-[#27124A] text-xl"></i>
            </div>
        </div>
        <div class="mt-4 flex items-center text-xs text-gray-500">
            <span class="text-pink-500 mr-1">💰</span> Total nilai inventaris
        </div>
    </div>
</div>

<!-- Main Content -->
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden mb-8">
    <!-- Header -->
    <div class="p-6 border-b border-gray-100">
        <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-4">
            <div>
                <h3 class="text-lg font-semibold text-gray-800">Daftar Produk</h3>
                <p class="text-sm text-gray-500 mt-1">Kelola produk yang tersedia untuk penjualan di gym</p>
            </div>
            <div class="flex flex-wrap gap-3">
                <a href="{{ route('admin.categories.index') }}" 
                   class="px-4 py-2.5 bg-gray-700 hover:bg-gray-800 text-white font-medium rounded-xl transition-all duration-300 flex items-center shadow-sm hover:shadow-md">
                    <i class="fas fa-tags mr-2"></i> Kelola Kategori
                </a>
                <a href="{{ route('admin.products.create') }}" 
                   class="px-4 py-2.5 bg-[#27124A] hover:bg-[#3a1d6b] text-white font-medium rounded-xl transition-all duration-300 flex items-center shadow-sm hover:shadow-md">
                    <i class="fas fa-plus mr-2"></i> Tambah Produk
                </a>
            </div>
        </div>
    </div>
    
    <!-- Alert Messages with consistent spacing and close button -->
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
    
    @if(session('warning'))
    <div class="mx-6 mt-6 mb-4 bg-yellow-50 border-l-4 border-yellow-500 rounded-lg p-4 shadow-sm">
        <div class="flex items-center">
            <div class="flex-shrink-0">
                <i class="fas fa-exclamation-triangle text-yellow-500 text-lg"></i>
            </div>
            <div class="ml-3">
                <p class="text-yellow-700 font-medium">{{ session('warning') }}</p>
            </div>
            <button type="button" class="ml-auto text-yellow-400 hover:text-yellow-600" onclick="this.closest('.mx-6').style.display='none'">
                <i class="fas fa-times"></i>
            </button>
        </div>
    </div>
    @endif

    <!-- Table -->
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-100">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-16">No</th>
                    <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Produk</th>
                    <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kategori</th>
                    <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Harga</th>
                    <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Stok</th>
                    <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-100">
                @forelse($products as $product)
                <tr class="hover:bg-gray-50 transition-colors duration-150">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center justify-center w-8 h-8 bg-gray-100 rounded-lg text-gray-600 font-medium text-sm">
                            {{ $loop->iteration }}
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 w-10 h-10 bg-[#27124A]/10 rounded-xl flex items-center justify-center mr-3">
                                <i class="fas fa-box text-[#27124A]"></i>
                            </div>
                            <div>
                                <h4 class="font-medium text-gray-800">{{ $product->nama_produk }}</h4>
                                @if($product->deskripsi)
                                    <p class="text-xs text-gray-400 mt-1">{{ Str::limit($product->deskripsi, 50) }}</p>
                                @endif
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <span class="px-3 py-1.5 bg-purple-50 rounded-lg text-sm font-medium inline-flex items-center border border-purple-100">
                            <i class="fas fa-tag mr-2 text-xs text-[#27124A]"></i>
                            <span>{{ $product->category->nama_kategori ?? 'Tidak Berkategori' }}</span>
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        <div class="bg-green-50 border border-green-100 rounded-xl p-3">
                            <div class="font-bold text-[#27124A]">Rp {{ number_format($product->harga, 0, ',', '.') }}</div>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center">
                            <div class="w-8 h-8 {{ $product->stok > 10 ? 'bg-green-50' : ($product->stok > 0 ? 'bg-yellow-50' : 'bg-red-50') }} rounded-lg flex items-center justify-center mr-2">
                                <i class="fas fa-cubes {{ $product->stok > 10 ? 'text-green-600' : ($product->stok > 0 ? 'text-yellow-600' : 'text-red-600') }} text-sm"></i>
                            </div>
                            <div>
                                <div class="text-sm font-medium text-gray-700">{{ $product->stok }} pcs</div>
                                @if($product->stok <= 10 && $product->stok > 0)
                                    <div class="text-xs text-yellow-600">Stok menipis</div>
                                @elseif($product->stok == 0)
                                    <div class="text-xs text-red-600">Stok habis</div>
                                @endif
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <form action="{{ route('admin.products.toggleStatus', $product->id) }}" method="POST" class="inline">
                            @csrf
                            @method('PUT')
                            <button type="submit" 
                                    class="px-3 py-1.5 rounded-lg text-sm font-medium transition-all duration-300 
                                    {{ $product->status ? 
                                       'bg-green-100 text-green-700 border border-green-200 hover:bg-green-200' : 
                                       'bg-red-100 text-red-700 border border-red-200 hover:bg-red-200' }}"
                                    onclick="return confirm('Yakin ingin {{ $product->status ? 'nonaktifkan' : 'aktifkan' }} produk {{ $product->nama_produk }}?')">
                                <i class="fas {{ $product->status ? 'fa-toggle-on' : 'fa-toggle-off' }} mr-1"></i>
                                {{ $product->status ? 'Aktif' : 'Nonaktif' }}
                            </button>
                        </form>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center space-x-2">
                            <a href="{{ route('admin.products.edit', $product->id) }}" 
                               class="p-2 bg-blue-50 hover:bg-blue-100 text-blue-600 rounded-lg transition-all duration-300 border border-blue-100"
                               title="Edit Produk">
                                <i class="fas fa-edit text-sm"></i>
                            </a>
                            
                            <a href="{{ route('admin.stock.create', $product->id) }}" 
                               class="p-2 bg-green-50 hover:bg-green-100 text-green-600 rounded-lg transition-all duration-300 border border-green-100"
                               title="Kelola Stok">
                                <i class="fas fa-warehouse text-sm"></i>
                            </a>
                            
                            <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        class="p-2 bg-red-50 hover:bg-red-100 text-red-600 rounded-lg transition-all duration-300 border border-red-100"
                                        onclick="return confirm('Yakin ingin menghapus produk {{ $product->nama_produk }}? Tindakan ini tidak dapat dibatalkan.')"
                                        title="Hapus Produk">
                                    <i class="fas fa-trash text-sm"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-6 py-12 text-center">
                        <div class="inline-flex items-center justify-center w-20 h-20 bg-purple-50 rounded-full mb-4">
                            <i class="fas fa-box text-3xl text-[#27124A]"></i>
                        </div>
                        <h4 class="text-lg font-semibold text-gray-800 mb-2">Belum Ada Produk</h4>
                        <p class="text-gray-400 text-sm mb-6">Mulai dengan menambahkan produk pertama ke inventaris gym</p>
                        <a href="{{ route('admin.products.create') }}" 
                           class="inline-flex items-center px-5 py-2.5 bg-[#27124A] hover:bg-[#3a1d6b] text-white font-medium rounded-xl transition-all duration-300 shadow-sm hover:shadow-md">
                            <i class="fas fa-plus mr-2"></i> Tambah Produk Pertama
                        </a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

@push('styles')
<style>
    /* Custom scrollbar for table */
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
    
    /* Smooth transitions */
    table tbody tr {
        transition: all 0.2s ease;
    }
    
    /* Progress bar animation */
    .progress-bar {
        transition: width 0.6s ease;
    }
    
    /* Button transitions */
    button, a {
        transition: all 0.2s ease;
    }
    
    /* Alert close button hover */
    [onclick*="this.closest"]:hover {
        opacity: 0.7;
    }
</style>
@endpush

@push('scripts')
<script>
    // Auto-hide alerts after 5 seconds
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