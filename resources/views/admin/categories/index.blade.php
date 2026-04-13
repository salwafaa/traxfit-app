@extends('layouts.app')

@section('title', 'Kelola Kategori')
@section('page-title', 'Kelola Kategori Produk')

@section('sidebar')
@include('admin.partials.sidebar')
@endsection

@section('content')
<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
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
                @forelse($categories as $category)
                <tr class="hover:bg-gray-50 transition-colors duration-150">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center justify-center w-8 h-8 bg-gray-100 rounded-lg text-gray-600 font-medium text-sm">
                            {{ $loop->iteration }}
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 w-10 h-10 bg-purple-50 rounded-xl flex items-center justify-center mr-3">
                                <i class="fas fa-folder text-[#27124A]"></i>
                            </div>
                            <div>
                                <h4 class="font-medium text-gray-800">{{ $category->nama_kategori }}</h4>
                                <p class="text-xs text-gray-400">ID: {{ $category->id }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex flex-col items-start">
                            <span class="px-2.5 py-1.5 bg-purple-50 text-[#27124A] rounded-lg text-sm font-medium inline-flex items-center">
                                <i class="fas fa-box mr-1 text-xs"></i> {{ $category->products_count }} produk
                            </span>
                            @if($category->products_count > 0)
                            <div class="w-32 h-1.5 bg-gray-100 rounded-full overflow-hidden mt-2">
                                @php
                                    $percentage = ($category->products_count / max(1, $categories->sum('products_count'))) * 100;
                                @endphp
                                <div class="h-full bg-[#27124A] rounded-full progress-bar" 
                                     style="width: {{ $percentage }}%"></div>
                            </div>
                            @endif
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <div>
                            <span class="text-sm text-gray-700">{{ $category->created_at->format('d/m/Y') }}</span>
                            <span class="text-xs text-gray-400 block">{{ $category->created_at->format('H:i') }}</span>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center space-x-2">
                            <a href="{{ route('admin.categories.edit', $category->id) }}" 
                               class="p-2 bg-blue-50 hover:bg-blue-100 text-blue-600 rounded-lg transition-all duration-300 border border-blue-100"
                               title="Edit Kategori">
                                <i class="fas fa-edit text-sm"></i>
                            </a>
                            
                            <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        class="p-2 bg-red-50 hover:bg-red-100 text-red-600 rounded-lg transition-all duration-300 border border-red-100"
                                        onclick="return confirm('Yakin ingin menghapus kategori {{ $category->nama_kategori }}? Tindakan ini akan mempengaruhi {{ $category->products_count }} produk terkait.')"
                                        title="Hapus Kategori">
                                    <i class="fas fa-trash text-sm"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-12 text-center">
                        <div class="inline-flex items-center justify-center w-20 h-20 bg-purple-50 rounded-full mb-4">
                            <i class="fas fa-tags text-3xl text-[#27124A]"></i>
                        </div>
                        <h4 class="text-lg font-semibold text-gray-800 mb-2">Belum Ada Kategori</h4>
                        <p class="text-gray-400 text-sm mb-6">Mulai dengan membuat kategori pertama untuk mengelompokkan produk</p>
                        <a href="{{ route('admin.categories.create') }}" 
                           class="inline-flex items-center px-5 py-2.5 bg-[#27124A] hover:bg-[#3a1d6b] text-white font-medium rounded-xl transition-all duration-300 shadow-sm hover:shadow-md">
                            <i class="fas fa-plus mr-2"></i> Tambah Kategori Pertama
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
    table tbody tr {
        transition: all 0.2s ease;
    }
    
    table tbody tr:hover {
        background-color: #fafafa;
    }
    
    .progress-bar {
        transition: width 0.6s ease;
    }
    
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
    
    [onclick*="this.closest"]:hover {
        opacity: 0.7;
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