@extends('layouts.app')

@section('title', 'Laporan Transaksi')
@section('page-title', 'Laporan Transaksi')

@section('sidebar')
@include('kasir.partials.sidebar')
@endsection

@section('content')
<div class="space-y-4 md:space-y-6 w-full max-w-full overflow-hidden">
    <!-- Header Stats - Responsive Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3 md:gap-4 w-full">
        <!-- Total Transaksi -->
        <div class="bg-white rounded-xl md:rounded-2xl shadow-sm border border-gray-100 p-3 md:p-4 lg:p-5 min-w-0">
            <div class="flex items-center justify-between">
                <div class="min-w-0 flex-1 pr-2">
                    <p class="text-xs md:text-sm text-gray-500 mb-0.5 md:mb-1 truncate">Total Transaksi</p>
                    <p class="text-lg md:text-xl lg:text-2xl font-bold text-gray-800 truncate">{{ $transactions->total() }}</p>
                </div>
                <div class="w-8 h-8 md:w-10 lg:w-12 md:h-10 lg:h-12 bg-blue-50 rounded-lg md:rounded-xl flex items-center justify-center flex-shrink-0">
                    <i class="fas fa-receipt text-[#27124A] text-sm md:text-base lg:text-lg"></i>
                </div>
            </div>
            <div class="mt-1 md:mt-2 lg:mt-3 flex items-center text-xs text-gray-500">
                <span class="text-blue-500 mr-1">🧾</span>
                <span class="truncate">Total seluruh transaksi</span>
            </div>
        </div>

        <!-- Total Pendapatan -->
        <div class="bg-white rounded-xl md:rounded-2xl shadow-sm border border-gray-100 p-3 md:p-4 lg:p-5 min-w-0">
            <div class="flex items-center justify-between">
                <div class="min-w-0 flex-1 pr-2">
                    <p class="text-xs md:text-sm text-gray-500 mb-0.5 md:mb-1 truncate">Total Pendapatan</p>
                    <p class="text-lg md:text-xl lg:text-2xl font-bold text-green-600 truncate">Rp {{ number_format($totalTransaksi, 0, ',', '.') }}</p>
                </div>
                <div class="w-8 h-8 md:w-10 lg:w-12 md:h-10 lg:h-12 bg-green-50 rounded-lg md:rounded-xl flex items-center justify-center flex-shrink-0">
                    <i class="fas fa-money-bill-wave text-[#27124A] text-sm md:text-base lg:text-lg"></i>
                </div>
            </div>
            <div class="mt-1 md:mt-2 lg:mt-3 flex items-center text-xs text-gray-500">
                <span class="text-green-500 mr-1">💰</span>
                <span class="truncate">Total pendapatan</span>
            </div>
        </div>

        <!-- Transaksi Member -->
        <div class="bg-white rounded-xl md:rounded-2xl shadow-sm border border-gray-100 p-3 md:p-4 lg:p-5 min-w-0">
            <div class="flex items-center justify-between">
                <div class="min-w-0 flex-1 pr-2">
                    <p class="text-xs md:text-sm text-gray-500 mb-0.5 md:mb-1 truncate">Transaksi Member</p>
                    <p class="text-lg md:text-xl lg:text-2xl font-bold text-purple-600 truncate">{{ $transactions->where('id_member', '!=', null)->count() }}</p>
                </div>
                <div class="w-8 h-8 md:w-10 lg:w-12 md:h-10 lg:h-12 bg-purple-50 rounded-lg md:rounded-xl flex items-center justify-center flex-shrink-0">
                    <i class="fas fa-user-tag text-[#27124A] text-sm md:text-base lg:text-lg"></i>
                </div>
            </div>
            <div class="mt-1 md:mt-2 lg:mt-3 flex items-center text-xs text-gray-500">
                <span class="text-purple-500 mr-1">👥</span>
                <span class="truncate">Transaksi dari member</span>
            </div>
        </div>

        <!-- Rata-rata Transaksi -->
        <div class="bg-white rounded-xl md:rounded-2xl shadow-sm border border-gray-100 p-3 md:p-4 lg:p-5 min-w-0">
            <div class="flex items-center justify-between">
                <div class="min-w-0 flex-1 pr-2">
                    <p class="text-xs md:text-sm text-gray-500 mb-0.5 md:mb-1 truncate">Rata-rata/Transaksi</p>
                    <p class="text-lg md:text-xl lg:text-2xl font-bold text-yellow-600 truncate">
                        Rp {{ $transactions->total() > 0 ? number_format($totalTransaksi / $transactions->total(), 0, ',', '.') : 0 }}
                    </p>
                </div>
                <div class="w-8 h-8 md:w-10 lg:w-12 md:h-10 lg:h-12 bg-yellow-50 rounded-lg md:rounded-xl flex items-center justify-center flex-shrink-0">
                    <i class="fas fa-chart-line text-[#27124A] text-sm md:text-base lg:text-lg"></i>
                </div>
            </div>
            <div class="mt-1 md:mt-2 lg:mt-3 flex items-center text-xs text-gray-500">
                <span class="text-yellow-500 mr-1">📊</span>
                <span class="truncate">Rata-rata per transaksi</span>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="bg-white rounded-xl md:rounded-2xl shadow-sm border border-gray-100 overflow-hidden w-full">
        <!-- Header -->
        <div class="p-3 md:p-4 lg:p-5 border-b border-gray-100">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3">
                <div class="min-w-0 flex-1">
                    <h3 class="text-sm md:text-base lg:text-lg font-semibold text-gray-800 truncate">Laporan Transaksi</h3>
                    <p class="text-xs md:text-sm text-gray-500 mt-0.5 md:mt-1 truncate">Laporan transaksi penjualan dan pendapatan</p>
                </div>
                <div class="flex items-center gap-3">
                    <span class="px-3 py-1.5 md:px-4 md:py-2 bg-blue-50 text-[#27124A] rounded-lg md:rounded-xl text-xs md:text-sm font-medium whitespace-nowrap">
                        <i class="fas fa-user mr-1 md:mr-2"></i>{{ auth()->user()->nama }}
                    </span>
                </div>
            </div>
        </div>

        <!-- Filter Form - Responsive Grid -->
        <div class="p-3 md:p-4 lg:p-5 border-b border-gray-100 bg-gray-50/50">
            <form method="GET" action="{{ route('kasir.report.transaksi') }}" id="filterForm" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-2 md:gap-3">
                <div class="min-w-0">
                    <label class="block text-xs md:text-sm font-medium text-gray-700 mb-1">
                        <i class="fas fa-calendar-alt mr-1 text-[#27124A] text-xs"></i>Tanggal Mulai
                    </label>
                    <input type="date" id="start_date" name="start_date" value="{{ request('start_date') }}"
                           class="w-full px-2 md:px-3 py-1.5 md:py-2 text-xs md:text-sm border border-gray-200 rounded-lg md:rounded-xl focus:outline-none focus:ring-2 focus:ring-[#27124A]/20 focus:border-[#27124A] transition-all">
                </div>
                
                <div class="min-w-0">
                    <label class="block text-xs md:text-sm font-medium text-gray-700 mb-1">
                        <i class="fas fa-calendar-alt mr-1 text-[#27124A] text-xs"></i>Tanggal Akhir
                    </label>
                    <input type="date" id="end_date" name="end_date" value="{{ request('end_date') }}"
                           class="w-full px-2 md:px-3 py-1.5 md:py-2 text-xs md:text-sm border border-gray-200 rounded-lg md:rounded-xl focus:outline-none focus:ring-2 focus:ring-[#27124A]/20 focus:border-[#27124A] transition-all">
                </div>
                
                <div class="min-w-0">
                    <label class="block text-xs md:text-sm font-medium text-gray-700 mb-1">
                        <i class="fas fa-search mr-1 text-[#27124A] text-xs"></i>Pencarian
                    </label>
                    <input type="text" id="search" name="search" value="{{ request('search') }}"
                           class="w-full px-2 md:px-3 py-1.5 md:py-2 text-xs md:text-sm border border-gray-200 rounded-lg md:rounded-xl focus:outline-none focus:ring-2 focus:ring-[#27124A]/20 focus:border-[#27124A] transition-all"
                           placeholder="No. Transaksi / Member">
                </div>
                
                <div class="flex items-end gap-2">
                    <button type="submit" 
                            class="flex-1 bg-[#27124A] hover:bg-[#3a1d6b] text-white text-xs md:text-sm font-medium py-1.5 md:py-2 px-2 rounded-lg md:rounded-xl transition-all duration-300 flex items-center justify-center whitespace-nowrap">
                        <i class="fas fa-filter mr-1 text-xs"></i>
                        <span class="hidden sm:inline">Filter</span>
                    </button>
                    <a href="{{ route('kasir.report.transaksi') }}" 
                       class="flex-1 bg-gray-200 hover:bg-gray-300 text-gray-800 text-xs md:text-sm font-medium py-1.5 md:py-2 px-2 rounded-lg md:rounded-xl transition-all duration-300 flex items-center justify-center whitespace-nowrap">
                        <i class="fas fa-redo mr-1 text-xs"></i>
                        <span class="hidden sm:inline">Reset</span>
                    </a>
                </div>
            </form>
        </div>

        <!-- Results -->
        <div class="p-3 md:p-4 lg:p-5">
            @if($transactions->isEmpty())
            <div class="text-center py-8 md:py-12">
                <div class="inline-flex items-center justify-center w-14 h-14 md:w-16 md:h-16 bg-gray-100 rounded-full mb-3">
                    <i class="fas fa-receipt text-xl md:text-2xl text-gray-400"></i>
                </div>
                <h4 class="text-sm md:text-base font-semibold text-gray-800 mb-1">Tidak Ada Data Transaksi</h4>
                <p class="text-xs md:text-sm text-gray-400 max-w-md mx-auto">
                    Tidak ada data transaksi yang sesuai dengan filter yang dipilih.
                    Coba gunakan filter yang berbeda.
                </p>
            </div>
            @else
            <!-- Table - Responsive dengan overflow -->
            <div class="overflow-x-auto w-full">
                <div class="inline-block min-w-full align-middle">
                    <table class="min-w-full divide-y divide-gray-100 table-auto">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-2 md:px-3 py-2 md:py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-12">No</th>
                                <th class="px-2 md:px-3 py-2 md:py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No. Transaksi</th>
                                <th class="px-2 md:px-3 py-2 md:py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden sm:table-cell">Tanggal</th>
                                <th class="px-2 md:px-3 py-2 md:py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Member</th>
                                <th class="px-2 md:px-3 py-2 md:py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                                <th class="px-2 md:px-3 py-2 md:py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden lg:table-cell">Pembayaran</th>
                                <th class="px-2 md:px-3 py-2 md:py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden md:table-cell">Status</th>
                                <th class="px-2 md:px-3 py-2 md:py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-100">
                            @foreach($transactions as $transaction)
                            <tr class="hover:bg-gray-50 transition-colors duration-150">
                                <td class="px-2 md:px-3 py-2 md:py-3 whitespace-nowrap">
                                    <div class="flex items-center justify-center w-6 h-6 md:w-7 md:h-7 bg-gray-100 rounded-lg text-gray-600 font-medium text-xs">
                                        {{ $loop->iteration + ($transactions->currentPage() - 1) * $transactions->perPage() }}
                                    </div>
                                </td>
                                <td class="px-2 md:px-3 py-2 md:py-3 whitespace-nowrap">
                                    <a href="{{ route('kasir.transaksi.show', $transaction->id) }}"
                                        class="flex items-center font-mono font-semibold text-[#27124A] hover:text-[#3a1d6b] text-xs">
                                        <div class="w-6 h-6 md:w-7 md:h-7 bg-purple-50 rounded-lg flex items-center justify-center mr-1 flex-shrink-0">
                                            <i class="fas fa-receipt text-xs text-[#27124A]"></i>
                                        </div>
                                        <span class="truncate max-w-[70px] md:max-w-[100px]">{{ $transaction->nomor_unik }}</span>
                                    </a>
                                </td>
                                <td class="px-2 md:px-3 py-2 md:py-3 whitespace-nowrap hidden sm:table-cell">
                                    <div class="flex items-center">
                                        <div class="w-6 h-6 md:w-7 md:h-7 bg-blue-50 rounded-lg flex items-center justify-center mr-1 flex-shrink-0">
                                            <i class="fas fa-calendar-alt text-[#27124A] text-xs"></i>
                                        </div>
                                        <div>
                                            <div class="text-xs text-gray-700">{{ $transaction->created_at->format('d/m/Y') }}</div>
                                            <div class="text-xs text-gray-400">{{ $transaction->created_at->format('H:i') }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-2 md:px-3 py-2 md:py-3 whitespace-nowrap">
                                    @if($transaction->member)
                                    <div class="flex items-center">
                                        <div class="w-6 h-6 md:w-7 md:h-7 bg-green-50 rounded-full flex items-center justify-center mr-1 flex-shrink-0">
                                            <i class="fas fa-user text-[#27124A] text-xs"></i>
                                        </div>
                                        <div class="truncate max-w-[80px]">
                                            <div class="font-medium text-gray-800 text-xs truncate">{{ $transaction->member->nama }}</div>
                                            <div class="text-xs text-gray-400 truncate">{{ $transaction->member->kode_member }}</div>
                                        </div>
                                    </div>
                                    @else
                                    <span class="px-2 py-1 bg-gray-100 text-gray-600 rounded-lg text-xs whitespace-nowrap">Non-Member</span>
                                    @endif
                                </td>
                                <td class="px-2 md:px-3 py-2 md:py-3 whitespace-nowrap">
                                    <span class="px-2 py-1 bg-blue-50 text-[#27124A] rounded-lg text-xs font-bold whitespace-nowrap">
                                        Rp {{ number_format($transaction->total_harga, 0, ',', '.') }}
                                    </span>
                                </td>
                                <td class="px-2 md:px-3 py-2 md:py-3 whitespace-nowrap hidden lg:table-cell">
                                    <span class="px-2 py-1 text-xs rounded-lg inline-flex items-center whitespace-nowrap
                                        {{ $transaction->metode_bayar == 'cash' ? 'bg-green-50 text-green-700' : 
                                           ($transaction->metode_bayar == 'qris' ? 'bg-blue-50 text-blue-700' : 
                                           'bg-purple-50 text-purple-700') }}">
                                        <i class="fas fa-{{ $transaction->metode_bayar == 'cash' ? 'money-bill-wave' : ($transaction->metode_bayar == 'qris' ? 'qrcode' : 'credit-card') }} mr-1"></i>
                                        {{ strtoupper($transaction->metode_bayar) }}
                                    </span>
                                </td>
                                <td class="px-2 md:px-3 py-2 md:py-3 whitespace-nowrap hidden md:table-cell">
                                    <span class="px-2 py-1 text-xs rounded-lg inline-flex items-center whitespace-nowrap
                                        {{ $transaction->status_transaksi == 'success' ? 'bg-green-50 text-green-700' : 
                                           ($transaction->status_transaksi == 'pending' ? 'bg-yellow-50 text-yellow-700' : 
                                           'bg-red-50 text-red-700') }}">
                                        <i class="fas fa-{{ $transaction->status_transaksi == 'success' ? 'check-circle' : ($transaction->status_transaksi == 'pending' ? 'clock' : 'times-circle') }} mr-1"></i>
                                        {{ ucfirst($transaction->status_transaksi) }}
                                    </span>
                                </td>
                                <td class="px-2 md:px-3 py-2 md:py-3 whitespace-nowrap">
                                    <div class="flex items-center gap-1 md:gap-2">
                                        <a href="{{ route('kasir.transaksi.show', $transaction->id) }}" 
                                           class="p-1 md:p-1.5 bg-blue-50 hover:bg-blue-100 text-blue-600 rounded-lg transition-all duration-300 border border-blue-100"
                                           title="Detail Transaksi">
                                            <i class="fas fa-eye text-xs"></i>
                                        </a>
                                        <a href="{{ route('kasir.transaksi.struk', $transaction->id) }}" target="_blank"
                                           class="p-1 md:p-1.5 bg-green-50 hover:bg-green-100 text-green-600 rounded-lg transition-all duration-300 border border-green-100"
                                           title="Cetak Struk">
                                            <i class="fas fa-print text-xs"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            
            <!-- Pagination -->
            @if($transactions->hasPages())
            <div class="mt-4 md:mt-6">
                <div class="overflow-x-auto">
                    {{ $transactions->withQueryString()->links() }}
                </div>
            </div>
            @endif
            
            <!-- Statistics -->
            <div class="mt-6 md:mt-8 pt-4 md:pt-6 border-t border-gray-100">
                <h4 class="text-sm md:text-base lg:text-lg font-semibold text-gray-800 mb-3 md:mb-4 flex items-center">
                    <i class="fas fa-chart-pie mr-2 text-[#27124A] text-sm md:text-base"></i>
                    Statistik Pembayaran
                </h4>
                @php
                    $cashCount = $transactions->where('metode_bayar', 'cash')->count();
                    $qrisCount = $transactions->where('metode_bayar', 'qris')->count();
                    $otherCount = $transactions->whereNotIn('metode_bayar', ['cash', 'qris'])->count();
                    $totalCount = $transactions->total();
                @endphp
                
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-2 md:gap-3">
                    <div class="bg-white p-3 md:p-4 rounded-lg md:rounded-xl border border-gray-200 min-w-0">
                        <div class="flex justify-between items-center mb-2">
                            <span class="text-xs md:text-sm font-medium text-gray-700 flex items-center truncate">
                                <i class="fas fa-money-bill-wave text-green-600 mr-1 text-xs"></i>
                                Cash
                            </span>
                            <span class="text-sm md:text-base font-bold text-green-600">{{ $cashCount }}</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-1.5 md:h-2">
                            <div class="bg-green-600 h-1.5 md:h-2 rounded-full" 
                                 style="width: {{ $totalCount > 0 ? ($cashCount / $totalCount * 100) : 0 }}%"></div>
                        </div>
                        <div class="text-xs text-gray-500 mt-1 md:mt-2 flex justify-between">
                            <span class="truncate">Transaksi</span>
                            <span>{{ $totalCount > 0 ? round($cashCount / $totalCount * 100, 1) : 0 }}%</span>
                        </div>
                    </div>
                    
                    <div class="bg-white p-3 md:p-4 rounded-lg md:rounded-xl border border-gray-200 min-w-0">
                        <div class="flex justify-between items-center mb-2">
                            <span class="text-xs md:text-sm font-medium text-gray-700 flex items-center truncate">
                                <i class="fas fa-qrcode text-blue-600 mr-1 text-xs"></i>
                                QRIS
                            </span>
                            <span class="text-sm md:text-base font-bold text-blue-600">{{ $qrisCount }}</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-1.5 md:h-2">
                            <div class="bg-blue-600 h-1.5 md:h-2 rounded-full" 
                                 style="width: {{ $totalCount > 0 ? ($qrisCount / $totalCount * 100) : 0 }}%"></div>
                        </div>
                        <div class="text-xs text-gray-500 mt-1 md:mt-2 flex justify-between">
                            <span class="truncate">Transaksi</span>
                            <span>{{ $totalCount > 0 ? round($qrisCount / $totalCount * 100, 1) : 0 }}%</span>
                        </div>
                    </div>
                    
                    <div class="bg-white p-3 md:p-4 rounded-lg md:rounded-xl border border-gray-200 min-w-0">
                        <div class="flex justify-between items-center mb-2">
                            <span class="text-xs md:text-sm font-medium text-gray-700 flex items-center truncate">
                                <i class="fas fa-credit-card text-purple-600 mr-1 text-xs"></i>
                                Lainnya
                            </span>
                            <span class="text-sm md:text-base font-bold text-purple-600">{{ $otherCount }}</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-1.5 md:h-2">
                            <div class="bg-purple-600 h-1.5 md:h-2 rounded-full" 
                                 style="width: {{ $totalCount > 0 ? ($otherCount / $totalCount * 100) : 0 }}%"></div>
                        </div>
                        <div class="text-xs text-gray-500 mt-1 md:mt-2 flex justify-between">
                            <span class="truncate">Transaksi</span>
                            <span>{{ $totalCount > 0 ? round($otherCount / $totalCount * 100, 1) : 0 }}%</span>
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>

    <!-- Export Options -->
    @if(!$transactions->isEmpty())
    <div class="bg-white rounded-xl md:rounded-2xl shadow-sm border border-gray-100 overflow-hidden w-full">
        <div class="p-3 md:p-4 lg:p-5 border-b border-gray-100">
            <h4 class="text-sm md:text-base lg:text-lg font-semibold text-gray-800 flex items-center">
                <i class="fas fa-download mr-2 text-[#27124A] text-sm md:text-base"></i>
                Ekspor Laporan
            </h4>
            <p class="text-xs md:text-sm text-gray-500 mt-0.5 md:mt-1">Download laporan dalam berbagai format</p>
        </div>
        <div class="p-3 md:p-4 lg:p-5">
            <div class="flex flex-wrap gap-2 md:gap-3">
                <button onclick="exportToPDF()" 
                        class="px-3 md:px-4 py-1.5 md:py-2 bg-red-600 hover:bg-red-700 text-white text-xs md:text-sm font-medium rounded-lg md:rounded-xl transition-all duration-300 flex items-center whitespace-nowrap">
                    <i class="fas fa-file-pdf mr-1 md:mr-2 text-xs"></i>
                    PDF
                </button>
                <button onclick="exportToExcel()" 
                        class="px-3 md:px-4 py-1.5 md:py-2 bg-green-600 hover:bg-green-700 text-white text-xs md:text-sm font-medium rounded-lg md:rounded-xl transition-all duration-300 flex items-center whitespace-nowrap">
                    <i class="fas fa-file-excel mr-1 md:mr-2 text-xs"></i>
                    Excel
                </button>
                <button onclick="window.print()" 
                        class="px-3 md:px-4 py-1.5 md:py-2 bg-blue-600 hover:bg-blue-700 text-white text-xs md:text-sm font-medium rounded-lg md:rounded-xl transition-all duration-300 flex items-center whitespace-nowrap">
                    <i class="fas fa-print mr-1 md:mr-2 text-xs"></i>
                    Cetak
                </button>
            </div>
        </div>
    </div>
    @endif

    <!-- Daily Summary Chart -->
    @if(request('start_date') && request('end_date') && !$transactions->isEmpty())
    <div class="bg-white rounded-xl md:rounded-2xl shadow-sm border border-gray-100 overflow-hidden w-full">
        <div class="p-3 md:p-4 lg:p-5 border-b border-gray-100">
            <h4 class="text-sm md:text-base lg:text-lg font-semibold text-gray-800 flex items-center">
                <i class="fas fa-chart-line mr-2 text-[#27124A] text-sm md:text-base"></i>
                Grafik Transaksi Harian
            </h4>
            <p class="text-xs md:text-sm text-gray-500 mt-0.5 md:mt-1">
                Periode {{ \Carbon\Carbon::parse(request('start_date'))->format('d/m/Y') }} - {{ \Carbon\Carbon::parse(request('end_date'))->format('d/m/Y') }}
            </p>
        </div>
        <div class="p-3 md:p-4 lg:p-5">
            <div id="dailyChart" class="h-64 md:h-80"></div>
        </div>
    </div>
    @endif
</div>
@endsection

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/apexcharts@3.35.0/dist/apexcharts.css" rel="stylesheet">
<style>
    /* Custom styles for better appearance */
    table tbody tr {
        transition: all 0.2s ease;
    }
    
    table tbody tr:hover {
        background-color: #fafafa;
    }
    
    .pagination {
        display: flex;
        justify-content: center;
        list-style: none;
        padding: 0;
        margin: 0;
        flex-wrap: wrap;
        gap: 2px;
    }

    .pagination li {
        margin: 0;
    }

    .pagination li a,
    .pagination li span {
        display: inline-block;
        padding: 0.25rem 0.5rem;
        border: 1px solid #e2e8f0;
        border-radius: 0.375rem;
        color: #4a5568;
        text-decoration: none;
        transition: all 0.2s;
        font-size: 0.75rem;
    }

    @media (min-width: 768px) {
        .pagination li a,
        .pagination li span {
            padding: 0.5rem 0.75rem;
            font-size: 0.875rem;
            border-radius: 0.5rem;
        }
    }

    .pagination li.active span {
        background-color: #27124A;
        color: white;
        border-color: #27124A;
    }

    .pagination li a:hover {
        background-color: #f7fafc;
        border-color: #cbd5e0;
    }
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/apexcharts@3.35.0"></script>
<script>
function exportToPDF() {
    const filters = {
        start_date: document.getElementById('start_date').value,
        end_date: document.getElementById('end_date').value,
        search: document.getElementById('search').value
    };
    
    const queryString = Object.keys(filters)
        .filter(key => filters[key])
        .map(key => `${key}=${encodeURIComponent(filters[key])}`)
        .join('&');
    
    window.open(`{{ route('kasir.report.transaksi') }}/pdf?${queryString}`, '_blank');
}

function exportToExcel() {
    const filters = {
        start_date: document.getElementById('start_date').value,
        end_date: document.getElementById('end_date').value,
        search: document.getElementById('search').value
    };
    
    const queryString = Object.keys(filters)
        .filter(key => filters[key])
        .map(key => `${key}=${encodeURIComponent(filters[key])}`)
        .join('&');
    
    window.open(`{{ route('kasir.report.transaksi') }}/excel?${queryString}`, '_blank');
}

// Daily Chart
@if(request('start_date') && request('end_date') && !$transactions->isEmpty())
document.addEventListener('DOMContentLoaded', function() {
    // This would be replaced with actual data from your server
    const options = {
        series: [{
            name: 'Total Transaksi',
            data: [31, 40, 28, 51, 42, 109, 100]
        }, {
            name: 'Pendapatan (Juta)',
            data: [11, 32, 45, 32, 34, 52, 41]
        }],
        chart: {
            height: window.innerWidth < 768 ? 250 : 350,
            type: 'line',
            toolbar: {
                show: true,
                tools: {
                    download: true,
                    selection: true,
                    zoom: true,
                    zoomin: true,
                    zoomout: true,
                    pan: true,
                    reset: true
                }
            },
            animations: {
                enabled: true,
                easing: 'easeinout',
                speed: 800
            }
        },
        colors: ['#27124A', '#10b981'],
        dataLabels: {
            enabled: false
        },
        stroke: {
            curve: 'smooth',
            width: 2
        },
        grid: {
            borderColor: '#e2e8f0',
            row: {
                colors: ['#f8fafc', 'transparent'],
                opacity: 0.5
            }
        },
        markers: {
            size: 4,
            colors: ['#27124A', '#10b981'],
            strokeColors: '#fff',
            strokeWidth: 2,
            hover: {
                size: 6
            }
        },
        xaxis: {
            categories: [
                "Senin", "Selasa", "Rabu", "Kamis", 
                "Jumat", "Sabtu", "Minggu"
            ],
            labels: {
                style: {
                    colors: '#64748b',
                    fontSize: '10px'
                }
            }
        },
        yaxis: {
            labels: {
                style: {
                    colors: '#64748b',
                    fontSize: '10px'
                },
                formatter: function(value) {
                    return value.toLocaleString('id-ID');
                }
            }
        },
        legend: {
            position: 'top',
            horizontalAlign: 'center',
            labels: {
                colors: '#334155'
            },
            fontSize: '12px',
            itemMargin: {
                horizontal: 10
            }
        },
        tooltip: {
            theme: 'light',
            y: {
                formatter: function(value) {
                    return value.toLocaleString('id-ID');
                }
            }
        }
    };

    const chart = new ApexCharts(document.querySelector("#dailyChart"), options);
    chart.render();
});
@endif
</script>
@endpush