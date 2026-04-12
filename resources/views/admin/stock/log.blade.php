@extends('layouts.app')

@section('title', 'Log Stok')
@section('page-title', 'Log Pergerakan Stok')

@section('sidebar')
@include('admin.partials.sidebar')
@endsection

@section('content')
<!-- Stats Cards -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <!-- Total Stok Masuk -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition-all duration-300">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500 mb-1">Total Stok Masuk</p>
                <p class="text-2xl font-bold text-gray-800">{{ number_format($totalMasuk, 0, ',', '.') }}</p>
            </div>
            <div class="w-12 h-12 bg-green-50 rounded-xl flex items-center justify-center">
                <i class="fas fa-arrow-down text-[#27124A] text-xl"></i>
            </div>
        </div>
        <div class="mt-4 flex items-center text-xs text-gray-500">
            <span class="text-green-500 mr-1">📥</span> Total barang masuk ke gudang
        </div>
    </div>
    
    <!-- Total Stok Keluar -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition-all duration-300">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500 mb-1">Total Stok Keluar</p>
                <p class="text-2xl font-bold text-gray-800">{{ number_format($totalKeluar, 0, ',', '.') }}</p>
            </div>
            <div class="w-12 h-12 bg-red-50 rounded-xl flex items-center justify-center">
                <i class="fas fa-arrow-up text-[#27124A] text-xl"></i>
            </div>
        </div>
        <div class="mt-4 flex items-center text-xs text-gray-500">
            <span class="text-red-500 mr-1">📤</span> Total barang keluar dari gudang
        </div>
    </div>
    
    <!-- Netto Stok -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition-all duration-300">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500 mb-1">Netto Stok</p>
                <p class="text-2xl font-bold text-gray-800">{{ number_format($totalMasuk - $totalKeluar, 0, ',', '.') }}</p>
            </div>
            <div class="w-12 h-12 bg-purple-50 rounded-xl flex items-center justify-center">
                <i class="fas fa-exchange-alt text-[#27124A] text-xl"></i>
            </div>
        </div>
        <div class="mt-4 flex items-center text-xs text-gray-500">
            @if(($totalMasuk - $totalKeluar) > 0)
                <span class="text-green-500 mr-1">📈</span> Pertumbuhan positif
            @elseif(($totalMasuk - $totalKeluar) < 0)
                <span class="text-red-500 mr-1">📉</span> Stok berkurang
            @else
                <span class="text-gray-500 mr-1">⚖️</span> Stabil
            @endif
        </div>
    </div>
</div>

<!-- Alert Messages -->
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

<!-- Main Content -->
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden mb-8">
    <!-- Header with Buttons -->
    <div class="p-6 border-b border-gray-100">
        <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-4">
            <div>
                <h3 class="text-lg font-semibold text-gray-800">Log Pergerakan Stok</h3>
                <p class="text-sm text-gray-500 mt-1">Catatan semua transaksi stok masuk dan keluar</p>
            </div>
            <div class="flex flex-wrap gap-3">
                <!-- Export Button -->
                <form action="{{ route('admin.stock.log.export') }}" method="GET" class="inline">
                    @foreach(request()->except('export') as $key => $value)
                        <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                    @endforeach
                    <button type="submit" 
                            class="px-4 py-2.5 bg-green-600 hover:bg-green-700 text-white font-medium rounded-xl transition-all duration-300 flex items-center shadow-sm hover:shadow-md">
                        <i class="fas fa-file-excel mr-2"></i> Export Excel
                    </button>
                </form>
                
                <!-- Stock Button -->
                <a href="{{ route('admin.stock.index') }}" 
                   class="px-4 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-800 font-medium rounded-xl transition-all duration-300 flex items-center border border-gray-200 shadow-sm hover:shadow-md">
                    <i class="fas fa-warehouse mr-2"></i> Kelola Stok
                </a>
            </div>
        </div>
    </div>
    
    <!-- Filter -->
    <div class="p-6 border-b border-gray-100 bg-gray-50">
        <form method="GET" action="{{ route('admin.stock.log') }}" class="space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2" for="tipe">
                        <i class="fas fa-filter text-[#27124A] mr-2"></i>Tipe
                    </label>
                    <select name="tipe" id="tipe"
                            class="w-full px-3 py-2.5 border-2 border-gray-200 rounded-xl focus:outline-none focus:border-[#27124A] focus:ring-2 focus:ring-purple-200 transition-all duration-300 bg-white">
                        <option value="">Semua Tipe</option>
                        <option value="masuk" {{ request('tipe') == 'masuk' ? 'selected' : '' }}>Stok Masuk</option>
                        <option value="keluar" {{ request('tipe') == 'keluar' ? 'selected' : '' }}>Stok Keluar</option>
                    </select>
                </div>
                
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2" for="product">
                        <i class="fas fa-box text-[#27124A] mr-2"></i>Produk
                    </label>
                    <select name="product" id="product"
                            class="w-full px-3 py-2.5 border-2 border-gray-200 rounded-xl focus:outline-none focus:border-[#27124A] focus:ring-2 focus:ring-purple-200 transition-all duration-300 bg-white">
                        <option value="">Semua Produk</option>
                        @foreach($products as $p)
                            <option value="{{ $p->id }}" {{ request('product') == $p->id ? 'selected' : '' }}>
                                {{ $p->nama_produk }}
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2" for="start_date">
                        <i class="fas fa-calendar-alt text-[#27124A] mr-2"></i>Tanggal Mulai
                    </label>
                    <input type="date" name="start_date" value="{{ request('start_date') }}" 
                           class="w-full px-3 py-2.5 border-2 border-gray-200 rounded-xl focus:outline-none focus:border-[#27124A] focus:ring-2 focus:ring-purple-200 transition-all duration-300 bg-white">
                </div>
                
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2" for="end_date">
                        <i class="fas fa-calendar-alt text-[#27124A] mr-2"></i>Tanggal Akhir
                    </label>
                    <input type="date" name="end_date" value="{{ request('end_date') }}" 
                           class="w-full px-3 py-2.5 border-2 border-gray-200 rounded-xl focus:outline-none focus:border-[#27124A] focus:ring-2 focus:ring-purple-200 transition-all duration-300 bg-white">
                </div>
            </div>
            
            <div class="flex justify-end space-x-3">
                <button type="submit" 
                        class="px-5 py-2.5 bg-[#27124A] hover:bg-[#3a1d6e] text-white font-medium rounded-xl transition-all duration-300 flex items-center shadow-sm hover:shadow-md">
                    <i class="fas fa-filter mr-2"></i> Filter
                </button>
                <a href="{{ route('admin.stock.log') }}" 
                   class="px-5 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-800 font-medium rounded-xl transition-all duration-300 flex items-center border border-gray-200 shadow-sm hover:shadow-md">
                    <i class="fas fa-redo mr-2"></i> Reset
                </a>
            </div>
        </form>
    </div>
    
    <!-- Table -->
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-100">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-16">No</th>
                    <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                    <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Produk</th>
                    <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tipe</th>
                    <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jumlah</th>
                    <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Keterangan</th>
                    <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-100">
                @forelse($logs as $log)
                <tr class="hover:bg-gray-50 transition-colors duration-150">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center justify-center w-8 h-8 bg-gray-100 rounded-lg text-gray-600 font-medium text-sm">
                            {{ $loop->iteration + ($logs->currentPage() - 1) * $logs->perPage() }}
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div>
                            <div class="text-sm font-medium text-gray-800">{{ $log->created_at->format('d/m/Y') }}</div>
                            <div class="text-xs text-gray-400">{{ $log->created_at->format('H:i:s') }}</div>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 w-10 h-10 bg-purple-50 rounded-xl flex items-center justify-center mr-3">
                                <i class="fas fa-box text-[#27124A]"></i>
                            </div>
                            <div>
                                <div class="font-medium text-gray-800">{{ $log->product->nama_produk }}</div>
                                <div class="text-xs text-gray-400">{{ $log->product->category->nama_kategori ?? '-' }}</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <span class="px-3 py-1.5 rounded-lg text-sm font-medium inline-flex items-center 
                            {{ $log->tipe == 'masuk' ? 'bg-green-50 text-green-700 border border-green-200' : 'bg-red-50 text-red-700 border border-red-200' }}">
                            <i class="fas {{ $log->tipe == 'masuk' ? 'fa-arrow-down' : 'fa-arrow-up' }} mr-1 text-xs"></i>
                            {{ ucfirst($log->tipe) }}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        <div class="font-bold {{ $log->tipe == 'masuk' ? 'text-green-600' : 'text-red-600' }}">
                            {{ $log->tipe == 'masuk' ? '+' : '-' }}{{ number_format($log->qty, 0, ',', '.') }} pcs
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="text-sm text-gray-600 max-w-xs truncate" title="{{ $log->keterangan }}">
                            {{ Str::limit($log->keterangan, 50) }}
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 w-8 h-8 bg-blue-50 rounded-full flex items-center justify-center mr-2">
                                <i class="fas fa-user text-blue-600 text-sm"></i>
                            </div>
                            <div>
                                <div class="text-sm font-medium text-gray-800">{{ $log->user->nama ?? '-' }}</div>
                                <div class="text-xs text-gray-400">{{ $log->user->role ?? '-' }}</div>
                            </div>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-6 py-12 text-center">
                        <div class="inline-flex items-center justify-center w-20 h-20 bg-purple-50 rounded-full mb-4">
                            <i class="fas fa-history text-3xl text-[#27124A]"></i>
                        </div>
                        <h4 class="text-lg font-semibold text-gray-800 mb-2">Belum Ada Data Log Stok</h4>
                        <p class="text-gray-400 text-sm mb-6">Stok masuk/keluar akan tercatat di sini</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <!-- Pagination -->
    @if($logs->hasPages())
    <div class="px-6 py-4 border-t border-gray-100">
        {{ $logs->withQueryString()->links('pagination::tailwind') }}
    </div>
    @endif
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
    
    /* Alert close button hover */
    [onclick*="this.closest"]:hover {
        opacity: 0.7;
    }
    
    /* Truncate text */
    .truncate {
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }
    
    .max-w-xs {
        max-width: 20rem;
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