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
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 bg-green-50 rounded-xl flex items-center justify-center">
                <i class="fas fa-arrow-down text-green-600 text-xl"></i>
            </div>
            <span class="text-3xl font-light text-gray-800">{{ number_format($totalMasuk, 0, ',', '.') }}</span>
        </div>
        <h3 class="text-gray-500 text-sm font-medium uppercase tracking-wider">Total Stok Masuk</h3>
        <div class="mt-3">
            <span class="text-xs text-gray-400">pcs</span>
        </div>
    </div>
    
    <!-- Total Stok Keluar -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition-all duration-300">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 bg-red-50 rounded-xl flex items-center justify-center">
                <i class="fas fa-arrow-up text-red-600 text-xl"></i>
            </div>
            <span class="text-3xl font-light text-gray-800">{{ number_format($totalKeluar, 0, ',', '.') }}</span>
        </div>
        <h3 class="text-gray-500 text-sm font-medium uppercase tracking-wider">Total Stok Keluar</h3>
        <div class="mt-3">
            <span class="text-xs text-gray-400">pcs</span>
        </div>
    </div>
    
    <!-- Netto Stok -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition-all duration-300">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 bg-purple-50 rounded-xl flex items-center justify-center">
                <i class="fas fa-exchange-alt text-[#27124A] text-xl"></i>
            </div>
            <span class="text-3xl font-light text-gray-800">{{ number_format($totalMasuk - $totalKeluar, 0, ',', '.') }}</span>
        </div>
        <h3 class="text-gray-500 text-sm font-medium uppercase tracking-wider">Netto Stok</h3>
        <div class="mt-3 flex items-center text-xs">
            @if(($totalMasuk - $totalKeluar) > 0)
                <span class="text-green-600 font-medium">Pertumbuhan positif</span>
            @elseif(($totalMasuk - $totalKeluar) < 0)
                <span class="text-red-600 font-medium">Stok berkurang</span>
            @else
                <span class="text-gray-400">Stabil</span>
            @endif
        </div>
    </div>
</div>

<!-- Main Content -->
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden mb-8">
    <!-- Header with Buttons -->
    <div class="p-6 border-b border-gray-100">
        <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-4">
            <div>
                <h3 class="text-xl font-bold text-gray-800">Log Pergerakan Stok</h3>
                <p class="text-gray-600 mt-1">Catatan semua transaksi stok masuk dan keluar</p>
            </div>
            <div class="flex flex-wrap gap-3">
                <!-- Export Button -->
                <a href="{{ route('admin.stock.log') }}?export=excel&{{ http_build_query(request()->except('export')) }}" 
                   class="px-4 py-2.5 bg-green-600 hover:bg-green-700 text-white font-semibold rounded-xl transition-all duration-300 transform hover:-translate-y-1 shadow-sm hover:shadow-md flex items-center">
                    <i class="fas fa-file-excel mr-2"></i> Export Excel
                </a>
                
                <!-- Stock Button -->
                <a href="{{ route('admin.stock.index') }}" 
                   class="px-4 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-800 font-semibold rounded-xl transition-all duration-300 transform hover:-translate-y-1 shadow-sm hover:shadow-md flex items-center border border-gray-200">
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
                        @foreach(App\Models\Product::all() as $p)
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
                        class="px-5 py-2.5 bg-[#27124A] hover:bg-[#3a1d6e] text-white font-semibold rounded-xl transition-all duration-300 transform hover:-translate-y-1 shadow-sm hover:shadow-md flex items-center">
                    <i class="fas fa-filter mr-2"></i> Filter
                </button>
                <a href="{{ route('admin.stock.log') }}" 
                   class="px-5 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-800 font-semibold rounded-xl transition-all duration-300 transform hover:-translate-y-1 shadow-sm hover:shadow-md flex items-center border border-gray-200">
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
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider w-20">No</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Tanggal</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Produk</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Tipe</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Jumlah</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Keterangan</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">User</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-100">
                @foreach($logs as $log)
                <tr class="hover:bg-gray-50 transition-colors duration-150">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center justify-center w-10 h-10 bg-purple-50 rounded-xl text-[#27124A] font-bold">
                            {{ $loop->iteration + ($logs->currentPage() - 1) * $logs->perPage() }}
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-normal break-words">
                        <div class="text-sm text-gray-900 break-words">{{ $log->created_at->format('d/m/Y') }}</div>
                        <div class="text-xs text-gray-500 break-words">{{ $log->created_at->format('H:i:s') }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-normal break-words">
                        <div class="flex items-start">
                            <div class="flex-shrink-0 w-10 h-10 bg-purple-50 rounded-xl flex items-center justify-center mr-3">
                                <i class="fas fa-box text-[#27124A]"></i>
                            </div>
                            <div class="min-w-0 flex-1">
                                <div class="font-medium text-gray-900 break-words">{{ $log->product->nama_produk }}</div>
                                <div class="text-xs text-gray-500 break-words">{{ $log->product->category->nama_kategori ?? '-' }}</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-normal break-words">
                        <span class="px-3 py-1.5 rounded-xl text-sm font-semibold 
                            {{ $log->tipe == 'masuk' ? 'bg-green-50 text-green-700 border border-green-200' : 'bg-red-50 text-red-700 border border-red-200' }} inline-block break-words">
                            {{ ucfirst($log->tipe) }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-normal break-words">
                        <div class="font-bold {{ $log->tipe == 'masuk' ? 'text-green-600' : 'text-red-600' }} break-words">
                            {{ $log->tipe == 'masuk' ? '+' : '-' }}{{ $log->qty }} pcs
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-normal break-words">
                        <div class="text-sm text-gray-900 break-words">{{ $log->keterangan }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-normal break-words">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 w-8 h-8 bg-blue-50 rounded-full flex items-center justify-center mr-3">
                                <i class="fas fa-user text-blue-600 text-sm"></i>
                            </div>
                            <div class="min-w-0 flex-1">
                                <div class="text-sm text-gray-900 break-words">{{ $log->user->nama ?? '-' }}</div>
                                <div class="text-xs text-gray-500 break-words">{{ $log->user->role ?? '-' }}</div>
                            </div>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    
    <!-- Pagination -->
    @if($logs->hasPages())
    <div class="p-6 border-t border-gray-100">
        <div class="flex justify-center">
            {{ $logs->withQueryString()->links('pagination::tailwind') }}
        </div>
    </div>
    @endif
    
    @if($logs->isEmpty())
    <div class="p-12 text-center">
        <div class="inline-flex items-center justify-center w-20 h-20 bg-purple-50 rounded-full mb-6">
            <i class="fas fa-history text-3xl text-[#27124A]"></i>
        </div>
        <h4 class="text-xl font-bold text-gray-700 mb-3">Belum Ada Data Log Stok</h4>
        <p class="text-gray-500 mb-6">Stok masuk/keluar akan tercatat di sini</p>
    </div>
    @endif
</div>
@endsection

@push('styles')
<style>
    /* Custom scrollbar for table */
    .overflow-x-auto {
        scrollbar-width: thin;
        scrollbar-color: #cbd5e1 #f1f5f9;
    }
    
    .overflow-x-auto::-webkit-scrollbar {
        height: 6px;
    }
    
    .overflow-x-auto::-webkit-scrollbar-track {
        background: #f1f5f9;
        border-radius: 3px;
    }
    
    .overflow-x-auto::-webkit-scrollbar-thumb {
        background-color: #cbd5e1;
        border-radius: 3px;
    }
    
    /* Smooth transitions */
    table tbody tr {
        transition: all 0.2s ease;
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