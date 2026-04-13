@extends('layouts.app')

@section('title', 'Laporan Transaksi')
@section('page-title', 'Laporan Transaksi')

@section('sidebar')
@include('owner.partials.sidebar')
@endsection

@section('content')
<div class="space-y-4 md:space-y-6 w-full max-w-full">
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3 md:gap-4 w-full">
        <div class="bg-white rounded-xl md:rounded-2xl shadow-sm border border-gray-100 p-3 md:p-4">
            <div class="flex items-center justify-between">
                <div class="flex-1 pr-2">
                    <p class="text-xs md:text-sm text-gray-500 mb-1">Total Transaksi</p>
                    <p class="text-xl md:text-2xl font-bold text-gray-800">{{ number_format($totalTransaksi, 0, ',', '.') }}</p>
                </div>
                <div class="w-10 h-10 md:w-12 md:h-12 bg-blue-50 rounded-xl flex items-center justify-center flex-shrink-0">
                    <i class="fas fa-shopping-cart text-[#27124A] text-base md:text-xl"></i>
                </div>
            </div>
            <div class="mt-2 md:mt-3 flex items-center text-xs text-gray-500">
                <span class="text-blue-500 mr-1">📊</span>
                <span>Total seluruh transaksi</span>
            </div>
        </div>

        <div class="bg-white rounded-xl md:rounded-2xl shadow-sm border border-gray-100 p-3 md:p-4">
            <div class="flex items-center justify-between">
                <div class="flex-1 pr-2">
                    <p class="text-xs md:text-sm text-gray-500 mb-1">Total Pendapatan</p>
                    <p class="text-xl md:text-2xl font-bold text-gray-800">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</p>
                </div>
                <div class="w-10 h-10 md:w-12 md:h-12 bg-green-50 rounded-xl flex items-center justify-center flex-shrink-0">
                    <i class="fas fa-money-bill-wave text-[#27124A] text-base md:text-xl"></i>
                </div>
            </div>
            <div class="mt-2 md:mt-3 flex items-center text-xs text-gray-500">
                <span class="text-green-500 mr-1">💰</span>
                <span>Total pendapatan kotor</span>
            </div>
        </div>

        <div class="bg-white rounded-xl md:rounded-2xl shadow-sm border border-gray-100 p-3 md:p-4">
            <div class="flex items-center justify-between">
                <div class="flex-1 pr-2">
                    <p class="text-xs md:text-sm text-gray-500 mb-1">Tunai</p>
                    <p class="text-xl md:text-2xl font-bold text-gray-800">Rp {{ number_format($totalPendapatanTunai, 0, ',', '.') }}</p>
                </div>
                <div class="w-10 h-10 md:w-12 md:h-12 bg-yellow-50 rounded-xl flex items-center justify-center flex-shrink-0">
                    <i class="fas fa-coins text-[#27124A] text-base md:text-xl"></i>
                </div>
            </div>
            <div class="mt-2 md:mt-3 flex items-center text-xs text-gray-500">
                <span class="text-yellow-500 mr-1">💵</span>
                <span>Pembayaran tunai</span>
            </div>
        </div>

        <div class="bg-white rounded-xl md:rounded-2xl shadow-sm border border-gray-100 p-3 md:p-4">
            <div class="flex items-center justify-between">
                <div class="flex-1 pr-2">
                    <p class="text-xs md:text-sm text-gray-500 mb-1">Rata-rata</p>
                    <p class="text-xl md:text-2xl font-bold text-gray-800">Rp {{ number_format($rataRataTransaksi, 0, ',', '.') }}</p>
                </div>
                <div class="w-10 h-10 md:w-12 md:h-12 bg-purple-50 rounded-xl flex items-center justify-center flex-shrink-0">
                    <i class="fas fa-chart-line text-[#27124A] text-base md:text-xl"></i>
                </div>
            </div>
            <div class="mt-2 md:mt-3 flex items-center text-xs text-gray-500">
                <span class="text-purple-500 mr-1">📈</span>
                <span>Rata-rata per transaksi</span>
            </div>
        </div>
    </div>

    <div class="bg-blue-50 border border-blue-200 rounded-xl md:rounded-2xl p-3 md:p-4 flex items-center">
        <div class="w-6 h-6 md:w-8 md:h-8 bg-blue-100 rounded-full flex items-center justify-center mr-2 md:mr-3 flex-shrink-0">
            <i class="fas fa-info-circle text-blue-600 text-xs md:text-sm"></i>
        </div>
        <p class="text-xs md:text-sm text-blue-800">
            <span class="font-semibold">Informasi:</span> Menampilkan semua data transaksi. 
            Gunakan filter periode untuk melihat data spesifik.
        </p>
    </div>

    <div class="bg-white rounded-xl md:rounded-2xl shadow-sm border border-gray-100 overflow-hidden w-full">
        <div class="p-3 md:p-4 border-b border-gray-100">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3">
                <div class="min-w-0 flex-1">
                    <h3 class="text-sm md:text-base font-semibold text-gray-800">Laporan Transaksi</h3>
                    <p class="text-xs md:text-sm text-gray-500 mt-0.5">Riwayat transaksi penjualan</p>
                </div>
            </div>
        </div>

        <div class="p-3 md:p-4 border-b border-gray-100 bg-gray-50/50">
            <form method="GET" action="{{ route('owner.laporan.transaksi') }}" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-2 md:gap-3">
                <div>
                    <label class="block text-xs md:text-sm font-medium text-gray-700 mb-1">Periode</label>
                    <select name="period" class="w-full px-2 md:px-3 py-1.5 md:py-2 text-xs md:text-sm border border-gray-200 rounded-lg md:rounded-xl focus:outline-none focus:ring-2 focus:ring-[#27124A]/20 focus:border-[#27124A] transition-all">
                        <option value="">Pilih Periode</option>
                        <option value="today" {{ request('period') == 'today' ? 'selected' : '' }}>Hari Ini</option>
                        <option value="week" {{ request('period') == 'week' ? 'selected' : '' }}>Minggu Ini</option>
                        <option value="month" {{ request('period') == 'month' ? 'selected' : '' }}>Bulan Ini</option>
                        <option value="year" {{ request('period') == 'year' ? 'selected' : '' }}>Tahun Ini</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs md:text-sm font-medium text-gray-700 mb-1">Tgl Mulai</label>
                    <input type="date" name="start_date" value="{{ request('start_date') }}" 
                           class="w-full px-2 md:px-3 py-1.5 md:py-2 text-xs md:text-sm border border-gray-200 rounded-lg md:rounded-xl focus:outline-none focus:ring-2 focus:ring-[#27124A]/20 focus:border-[#27124A] transition-all">
                </div>
                <div>
                    <label class="block text-xs md:text-sm font-medium text-gray-700 mb-1">Tgl Akhir</label>
                    <input type="date" name="end_date" value="{{ request('end_date') }}" 
                           class="w-full px-2 md:px-3 py-1.5 md:py-2 text-xs md:text-sm border border-gray-200 rounded-lg md:rounded-xl focus:outline-none focus:ring-2 focus:ring-[#27124A]/20 focus:border-[#27124A] transition-all">
                </div>
                <div class="flex items-end gap-2">
                    <button type="submit"
                        class="flex-1 bg-[#27124A] hover:bg-[#3a1d6b] text-white text-xs md:text-sm font-medium py-1.5 md:py-2 px-2 rounded-lg md:rounded-xl transition-all duration-300 flex items-center justify-center">
                        <i class="fas fa-filter mr-1 text-xs"></i>
                        <span class="hidden sm:inline">Filter</span>
                    </button>
                    <a href="{{ route('owner.laporan.transaksi') }}"
                        class="flex-1 bg-gray-200 hover:bg-gray-300 text-gray-800 text-xs md:text-sm font-medium py-1.5 md:py-2 px-2 rounded-lg md:rounded-xl transition-all duration-300 flex items-center justify-center">
                        <i class="fas fa-redo mr-1 text-xs"></i>
                        <span class="hidden sm:inline">Reset</span>
                    </a>
                </div>
            </form>
        </div>

        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3 p-3 md:p-4 border-b border-gray-100">
            <div class="text-xs md:text-sm text-gray-500 bg-gray-50 px-3 md:px-4 py-1.5 md:py-2 rounded-lg md:rounded-xl">
                <i class="fas fa-info-circle mr-1 md:mr-2 text-[#27124A]"></i>
                <span>Menampilkan {{ $transactions->firstItem() ?? 0 }} - {{ $transactions->lastItem() ?? 0 }} dari {{ $transactions->total() }} transaksi</span>
            </div>
            
            <div class="flex gap-2">
                <a href="{{ route('owner.laporan.transaksi', array_merge(request()->query(), ['export' => 'pdf'])) }}" 
                   class="bg-red-600 hover:bg-red-700 text-white px-3 md:px-4 py-1.5 md:py-2 rounded-lg md:rounded-xl text-xs md:text-sm transition-all duration-300 flex items-center">
                    <i class="fas fa-file-pdf mr-1 md:mr-2"></i> PDF
                </a>
                <a href="{{ route('owner.laporan.transaksi', array_merge(request()->query(), ['export' => 'excel'])) }}" 
                   class="bg-green-600 hover:bg-green-700 text-white px-3 md:px-4 py-1.5 md:py-2 rounded-lg md:rounded-xl text-xs md:text-sm transition-all duration-300 flex items-center">
                    <i class="fas fa-file-excel mr-1 md:mr-2"></i> Excel
                </a>
            </div>
        </div>

        <div class="overflow-x-auto w-full">
            <table class="min-w-full divide-y divide-gray-100">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-3 md:px-4 py-2 md:py-3 text-left text-xs font-medium text-gray-500 uppercase">No. Invoice</th>
                        <th class="px-3 md:px-4 py-2 md:py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal</th>
                        <th class="px-3 md:px-4 py-2 md:py-3 text-left text-xs font-medium text-gray-500 uppercase hidden md:table-cell">Kasir</th>
                        <th class="px-3 md:px-4 py-2 md:py-3 text-left text-xs font-medium text-gray-500 uppercase hidden lg:table-cell">Member</th>
                        <th class="px-3 md:px-4 py-2 md:py-3 text-left text-xs font-medium text-gray-500 uppercase">Total</th>
                        <th class="px-3 md:px-4 py-2 md:py-3 text-left text-xs font-medium text-gray-500 uppercase hidden sm:table-cell">Metode</th>
                        <th class="px-3 md:px-4 py-2 md:py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-100">
                    @forelse($transactions as $transaction)
                    <tr class="hover:bg-gray-50">
                        <td class="px-3 md:px-4 py-2 md:py-3 whitespace-nowrap">
                            <a href="{{ route('owner.laporan.transaksi.show', $transaction->id) }}"
                                class="flex items-center font-mono font-semibold text-[#27124A] hover:text-[#3a1d6b] text-xs">
                                <div class="w-6 h-6 md:w-7 md:h-7 bg-purple-50 rounded-lg flex items-center justify-center mr-1 flex-shrink-0">
                                    <i class="fas fa-receipt text-xs text-[#27124A]"></i>
                                </div>
                                <span>{{ $transaction->nomor_unik }}</span>
                            </a>
                        </td>
                        <td class="px-3 md:px-4 py-2 md:py-3 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="w-6 h-6 md:w-7 md:h-7 bg-gray-50 rounded-lg flex items-center justify-center mr-1 flex-shrink-0">
                                    <i class="fas fa-calendar text-gray-400 text-xs"></i>
                                </div>
                                <div>
                                    <div class="text-xs text-gray-700">{{ $transaction->created_at->format('d/m/Y') }}</div>
                                    <div class="text-xs text-gray-400">{{ $transaction->created_at->format('H:i') }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-3 md:px-4 py-2 md:py-3 whitespace-nowrap hidden md:table-cell">
                            <div class="flex items-center">
                                <div class="w-6 h-6 md:w-7 md:h-7 bg-gray-100 rounded-full flex items-center justify-center mr-1 flex-shrink-0">
                                    <i class="fas fa-user text-gray-600 text-xs"></i>
                                </div>
                                <span class="text-xs text-gray-700">{{ $transaction->user->nama ?? '-' }}</span>
                            </div>
                        </td>
                        <td class="px-3 md:px-4 py-2 md:py-3 whitespace-nowrap hidden lg:table-cell">
                            @if($transaction->member)
                                <div class="flex items-center">
                                    <div class="w-6 h-6 md:w-7 md:h-7 bg-green-50 rounded-full flex items-center justify-center mr-1 flex-shrink-0">
                                        <i class="fas fa-crown text-[#27124A] text-xs"></i>
                                    </div>
                                    <span class="text-xs text-gray-700">{{ $transaction->member->nama }}</span>
                                </div>
                            @else
                                <span class="px-2 py-1 bg-gray-100 text-gray-600 rounded-lg text-xs">Non-Member</span>
                            @endif
                        </td>
                        <td class="px-3 md:px-4 py-2 md:py-3 whitespace-nowrap">
                            <span class="px-2 py-1 bg-blue-50 text-[#27124A] rounded-lg text-xs font-bold">
                                Rp {{ number_format($transaction->total_harga, 0, ',', '.') }}
                            </span>
                        </td>
                        <td class="px-3 md:px-4 py-2 md:py-3 whitespace-nowrap hidden sm:table-cell">
                            <span class="px-2 py-1 bg-green-100 text-green-700 rounded-lg text-xs flex items-center w-fit">
                                <i class="fas fa-money-bill-wave mr-1"></i> {{ $transaction->metode_bayar == 'cash' ? 'Tunai' : 'QRIS' }}
                            </span>
                        </td>
                        <td class="px-3 md:px-4 py-2 md:py-3 whitespace-nowrap">
                            <a href="{{ route('owner.laporan.transaksi.show', $transaction->id) }}" 
                               class="p-1 md:p-1.5 bg-blue-50 hover:bg-blue-100 text-blue-600 rounded-lg transition-all duration-300 border border-blue-100 inline-flex items-center"
                               title="Lihat Detail">
                                <i class="fas fa-eye text-xs"></i>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-4 py-8 text-center">
                            <div class="inline-flex items-center justify-center w-14 h-14 md:w-16 md:h-16 bg-purple-50 rounded-full mb-3">
                                <i class="fas fa-receipt text-xl md:text-2xl text-[#27124A]"></i>
                            </div>
                            <h4 class="text-sm md:text-base font-semibold text-gray-800 mb-1">Tidak Ada Data</h4>
                            <p class="text-xs md:text-sm text-gray-400">Belum ada transaksi</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($transactions->hasPages())
        <div class="p-3 md:p-4 border-t border-gray-100">
            <div class="overflow-x-auto">
                {{ $transactions->withQueryString()->links() }}
            </div>
        </div>
        @endif
    </div>
</div>
@endsection