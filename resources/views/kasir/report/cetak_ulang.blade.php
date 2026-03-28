@extends('layouts.app')

@section('title', 'Cetak Ulang Struk')
@section('page-title', 'Cetak Ulang Struk')

@section('sidebar')
@include('kasir.partials.sidebar')
@endsection

@section('content')
<!-- Header Stats -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
    <!-- Total Transaksi -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500 mb-1">Total Transaksi</p>
                <p class="text-2xl font-bold text-gray-800">{{ $transactions->total() }}</p>
            </div>
            <div class="w-12 h-12 bg-blue-50 rounded-xl flex items-center justify-center">
                <i class="fas fa-receipt text-[#27124A] text-xl"></i>
            </div>
        </div>
        <div class="mt-4 flex items-center text-xs text-gray-500">
            <span class="text-blue-500 mr-1">🧾</span> Total seluruh transaksi
        </div>
    </div>

    <!-- Transaksi Hari Ini -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500 mb-1">Transaksi Hari Ini</p>
                <p class="text-2xl font-bold text-green-600">{{ $transactions->where('created_at', '>=', now()->startOfDay())->count() }}</p>
            </div>
            <div class="w-12 h-12 bg-green-50 rounded-xl flex items-center justify-center">
                <i class="fas fa-calendar-day text-[#27124A] text-xl"></i>
            </div>
        </div>
        <div class="mt-4 flex items-center text-xs text-gray-500">
            <span class="text-green-500 mr-1">📅</span> Transaksi hari ini
        </div>
    </div>

    <!-- Total Pendapatan -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500 mb-1">Total Pendapatan</p>
                <p class="text-2xl font-bold text-[#27124A]">Rp {{ number_format($transactions->sum('total_harga'), 0, ',', '.') }}</p>
            </div>
            <div class="w-12 h-12 bg-purple-50 rounded-xl flex items-center justify-center">
                <i class="fas fa-money-bill-wave text-[#27124A] text-xl"></i>
            </div>
        </div>
        <div class="mt-4 flex items-center text-xs text-gray-500">
            <span class="text-purple-500 mr-1">💰</span> Total pendapatan
        </div>
    </div>

    <!-- Kasir -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500 mb-1">Kasir</p>
                <p class="text-2xl font-bold text-gray-800">{{ auth()->user()->nama }}</p>
            </div>
            <div class="w-12 h-12 bg-yellow-50 rounded-xl flex items-center justify-center">
                <i class="fas fa-user-tie text-[#27124A] text-xl"></i>
            </div>
        </div>
        <div class="mt-4 flex items-center text-xs text-gray-500">
            <span class="text-yellow-500 mr-1">👤</span> Sedang bertugas
        </div>
    </div>
</div>

<!-- Main Content -->
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden mb-8">
    <div class="p-6 border-b border-gray-100">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div>
                <h3 class="text-lg font-semibold text-gray-800">Cetak Ulang Struk</h3>
                <p class="text-sm text-gray-500 mt-1">Cetak ulang struk transaksi yang sudah dilakukan</p>
            </div>
            <div class="flex items-center gap-3">
                <span class="px-4 py-2 bg-blue-50 text-[#27124A] rounded-xl text-sm font-medium">
                    <i class="fas fa-print mr-2"></i>{{ $transactions->total() }} Struk Tersedia
                </span>
            </div>
        </div>
    </div>
    
    <!-- Search Form -->
    <div class="p-6 border-b border-gray-100 bg-gray-50/50">
        <div class="max-w-3xl mx-auto">
            <form method="GET" action="{{ route('kasir.report.cetakUlang') }}" id="searchForm">
                @csrf
                <div class="flex flex-col md:flex-row gap-3 items-end">
                    <div class="flex-1">
                        <label class="block text-sm font-medium text-gray-700 mb-2" for="search">
                            <i class="fas fa-search mr-2 text-[#27124A]"></i>Cari Transaksi
                        </label>
                        <div class="relative">
                            <input type="text" id="search" name="search" value="{{ request('search') }}"
                                   class="w-full px-5 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#27124A]/20 focus:border-[#27124A] transition-all pl-12"
                                   placeholder="Cari berdasarkan no. transaksi atau nama member...">
                            <i class="fas fa-receipt absolute left-4 top-3.5 text-gray-400"></i>
                        </div>
                    </div>
                    <button type="submit"
                            class="bg-[#27124A] hover:bg-[#3a1d6b] text-white px-8 py-3 rounded-xl transition-all duration-300 shadow-sm hover:shadow-md flex items-center justify-center min-w-[120px]">
                        <i class="fas fa-search mr-2"></i>
                        <span>Cari</span>
                    </button>
                </div>
                <div class="mt-3 flex items-center text-xs text-gray-500">
                    <i class="fas fa-info-circle mr-1 text-[#27124A]"></i>
                    Tekan Enter untuk mencari. Kosongkan lalu cari untuk menampilkan semua transaksi.
                </div>
            </form>
        </div>
    </div>
    
    <!-- Results -->
    <div class="p-6">
        @if($transactions->isEmpty())
        <div class="text-center py-12">
            <div class="inline-flex items-center justify-center w-24 h-24 bg-gray-100 rounded-full mb-4">
                <i class="fas fa-receipt text-4xl text-gray-400"></i>
            </div>
            <h4 class="text-lg font-semibold text-gray-800 mb-2">Tidak Ada Data Transaksi</h4>
            <p class="text-gray-400 text-sm max-w-md mx-auto mb-4">
                @if(request('search'))
                    Tidak ditemukan transaksi dengan kata kunci "{{ request('search') }}"
                @else
                    Belum ada data transaksi yang tersedia untuk dicetak ulang
                @endif
            </p>
            @if(request('search'))
            <a href="{{ route('kasir.report.cetakUlang') }}" 
               class="inline-flex items-center px-5 py-2.5 bg-[#27124A] hover:bg-[#3a1d6b] text-white font-medium rounded-xl transition-all duration-300">
                <i class="fas fa-times mr-2"></i>
                Reset Pencarian
            </a>
            @endif
        </div>
        @else
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-100">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No. Transaksi</th>
                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Member</th>
                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kasir</th>
                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-100">
                    @foreach($transactions as $transaction)
                    <tr class="hover:bg-gray-50 transition-colors duration-150">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="w-10 h-10 bg-purple-50 rounded-lg flex items-center justify-center mr-3">
                                    <i class="fas fa-receipt text-[#27124A]"></i>
                                </div>
                                <div class="font-mono font-medium text-gray-800">
                                    {{ $transaction->nomor_unik }}
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="w-8 h-8 bg-blue-50 rounded-lg flex items-center justify-center mr-2">
                                    <i class="fas fa-calendar-alt text-[#27124A] text-xs"></i>
                                </div>
                                <div>
                                    <div class="text-sm font-medium text-gray-800">
                                        {{ $transaction->created_at->format('d/m/Y') }}
                                    </div>
                                    <div class="text-xs text-gray-400">
                                        {{ $transaction->created_at->format('H:i') }} WIB
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            @if($transaction->member)
                            <div class="flex items-center">
                                <div class="w-8 h-8 bg-green-50 rounded-full flex items-center justify-center mr-2">
                                    <i class="fas fa-user text-[#27124A] text-xs"></i>
                                </div>
                                <div>
                                    <div class="text-sm font-medium text-gray-800">
                                        {{ $transaction->member->nama }}
                                    </div>
                                    <div class="text-xs text-gray-400">
                                        {{ $transaction->member->kode_member }}
                                    </div>
                                </div>
                            </div>
                            @else
                            <span class="px-3 py-1.5 bg-gray-100 text-gray-600 rounded-lg text-xs font-medium">Non-Member</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-3 py-1.5 bg-blue-50 text-[#27124A] rounded-lg text-sm font-bold">
                                Rp {{ number_format($transaction->total_harga, 0, ',', '.') }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="w-8 h-8 bg-gray-50 rounded-lg flex items-center justify-center mr-2">
                                    <i class="fas fa-user-tie text-gray-400 text-xs"></i>
                                </div>
                                <span class="text-sm text-gray-700">{{ $transaction->user->nama }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center space-x-2">
                                <a href="{{ route('kasir.transaksi.struk', $transaction->id) }}" target="_blank"
                                   class="p-2 bg-green-50 hover:bg-green-100 text-green-600 rounded-lg transition-all duration-300 border border-green-100"
                                   title="Cetak Struk">
                                    <i class="fas fa-print text-sm"></i>
                                </a>
                                <a href="{{ route('kasir.transaksi.show', $transaction->id) }}" 
                                   class="p-2 bg-blue-50 hover:bg-blue-100 text-blue-600 rounded-lg transition-all duration-300 border border-blue-100"
                                   title="Detail Transaksi">
                                    <i class="fas fa-eye text-sm"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        <div class="mt-6">
            {{ $transactions->withQueryString()->links() }}
        </div>
        
        <!-- Quick Print All -->
        <div class="mt-6 pt-6 border-t border-gray-100">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                <div>
                    <h4 class="font-semibold text-gray-800 flex items-center">
                        <i class="fas fa-print mr-2 text-[#27124A]"></i>
                        Cetak Massal
                    </h4>
                    <p class="text-sm text-gray-500 mt-1">Cetak semua struk yang ditampilkan ({{ $transactions->count() }} struk)</p>
                </div>
                <button onclick="printAllStruks()" 
                        class="px-6 py-3 bg-green-600 hover:bg-green-700 text-white font-medium rounded-xl transition-all duration-300 shadow-sm hover:shadow-md flex items-center">
                    <i class="fas fa-print mr-2"></i>
                    Cetak Semua
                </button>
            </div>
        </div>
        @endif
    </div>
</div>

<!-- Recent Transactions -->
@if(!$transactions->isEmpty())
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden mb-8">
    <div class="p-6 border-b border-gray-100">
        <h4 class="text-lg font-semibold text-gray-800 flex items-center">
            <i class="fas fa-history mr-2 text-[#27124A]"></i>
            Transaksi Terbaru (7 Hari Terakhir)
        </h4>
        <p class="text-sm text-gray-500 mt-1">Akses cepat ke transaksi yang baru dilakukan</p>
    </div>
    <div class="p-6">
        @php
            $recentTransactions = \App\Models\Transaction::with('member')
                ->where('id_user', auth()->id())
                ->where('created_at', '>=', now()->subDays(7))
                ->latest()
                ->limit(5)
                ->get();
        @endphp
        
        @if($recentTransactions->isEmpty())
        <p class="text-gray-400 text-center py-4">Tidak ada transaksi dalam 7 hari terakhir</p>
        @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach($recentTransactions as $transaction)
            <div class="bg-gray-50 border border-gray-200 rounded-xl p-4 hover:shadow-md transition-all duration-300">
                <div class="flex justify-between items-start mb-2">
                    <div class="font-mono font-bold text-[#27124A]">{{ $transaction->nomor_unik }}</div>
                    <span class="text-xs bg-blue-100 text-blue-700 px-2 py-1 rounded-lg">
                        {{ $transaction->created_at->format('H:i') }}
                    </span>
                </div>
                <div class="text-sm text-gray-600 mb-2">
                    {{ $transaction->created_at->format('d/m/Y') }}
                    @if($transaction->member)
                    • {{ $transaction->member->nama }}
                    @endif
                </div>
                <div class="flex justify-between items-center mt-3">
                    <span class="font-bold text-gray-800">Rp {{ number_format($transaction->total_harga, 0, ',', '.') }}</span>
                    <a href="{{ route('kasir.transaksi.struk', $transaction->id) }}" target="_blank"
                       class="p-2 bg-green-100 hover:bg-green-200 text-green-700 rounded-lg transition-all duration-300">
                        <i class="fas fa-print"></i>
                    </a>
                </div>
            </div>
            @endforeach
        </div>
        @endif
    </div>
</div>
@endif

<!-- Instructions -->
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="p-6 border-b border-gray-100">
        <h4 class="text-lg font-semibold text-gray-800">📋 Petunjuk Cetak Ulang</h4>
        <p class="text-sm text-gray-500 mt-1">Panduan lengkap menggunakan fitur cetak ulang struk</p>
    </div>
    <div class="p-6">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="flex items-start p-4 bg-blue-50/50 rounded-xl border border-blue-100">
                <div class="flex-shrink-0 w-10 h-10 bg-blue-100 rounded-xl flex items-center justify-center mr-3">
                    <i class="fas fa-search text-[#27124A]"></i>
                </div>
                <div>
                    <h5 class="font-medium text-gray-800">Cari Transaksi</h5>
                    <p class="text-xs text-gray-600 mt-1">Cari berdasarkan nomor transaksi atau nama member untuk menemukan struk yang diinginkan</p>
                </div>
            </div>
            
            <div class="flex items-start p-4 bg-green-50/50 rounded-xl border border-green-100">
                <div class="flex-shrink-0 w-10 h-10 bg-green-100 rounded-xl flex items-center justify-center mr-3">
                    <i class="fas fa-print text-[#27124A]"></i>
                </div>
                <div>
                    <h5 class="font-medium text-gray-800">Cetak Struk</h5>
                    <p class="text-xs text-gray-600 mt-1">Klik tombol cetak pada baris transaksi untuk mencetak ulang struk</p>
                </div>
            </div>
            
            <div class="flex items-start p-4 bg-purple-50/50 rounded-xl border border-purple-100">
                <div class="flex-shrink-0 w-10 h-10 bg-purple-100 rounded-xl flex items-center justify-center mr-3">
                    <i class="fas fa-history text-[#27124A]"></i>
                </div>
                <div>
                    <h5 class="font-medium text-gray-800">Transaksi Terbaru</h5>
                    <p class="text-xs text-gray-600 mt-1">Lihat transaksi 7 hari terakhir untuk akses cepat ke struk yang sering dicetak</p>
                </div>
            </div>
        </div>
    </div>
</div>
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
    
    .pagination {
        display: flex;
        justify-content: center;
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .pagination li {
        margin: 0 2px;
    }

    .pagination li a,
    .pagination li span {
        display: inline-block;
        padding: 0.5rem 0.75rem;
        border: 1px solid #e2e8f0;
        border-radius: 0.5rem;
        color: #4a5568;
        text-decoration: none;
        transition: all 0.2s;
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
<script>
function printAllStruks() {
    const transactionCount = {{ $transactions->count() }};
    
    if (transactionCount === 0) {
        alert('Tidak ada struk untuk dicetak');
        return;
    }
    
    if (!confirm(`Cetak ${transactionCount} struk sekaligus?`)) {
        return;
    }
    
    const transactionIds = [
        @foreach($transactions as $transaction)
        {{ $transaction->id }},
        @endforeach
    ];
    
    transactionIds.forEach((id, index) => {
        setTimeout(() => {
            window.open(`{{ url('kasir/transaksi') }}/${id}/struk`, '_blank');
        }, index * 800); // Delay 800ms between prints
    });
    
    showAlert('info', `Membuka ${transactionIds.length} struk untuk dicetak...`);
}

function showAlert(type, message) {
    const alertDiv = document.createElement('div');
    alertDiv.className = `fixed top-4 right-4 p-4 rounded-xl shadow-lg z-50 flex items-center border animate-slideIn ${
        type === 'info' ? 'bg-blue-50 border-blue-200 text-blue-800' :
        type === 'success' ? 'bg-green-50 border-green-200 text-green-800' :
        'bg-yellow-50 border-yellow-200 text-yellow-800'
    }`;
    
    const icon = type === 'info' ? 'fa-info-circle' : 
                 type === 'success' ? 'fa-check-circle' : 
                 'fa-exclamation-triangle';
    
    alertDiv.innerHTML = `
        <i class="fas ${icon} mr-3 text-lg"></i>
        <span class="font-medium">${message}</span>
        <button onclick="this.parentElement.remove()" class="ml-4 text-gray-400 hover:text-gray-600">
            <i class="fas fa-times"></i>
        </button>
    `;
    
    document.body.appendChild(alertDiv);
    
    setTimeout(() => {
        if (alertDiv.parentElement) {
            alertDiv.remove();
        }
    }, 5000);
}

// Auto submit form saat search dikosongkan
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('search');
    const searchForm = document.getElementById('searchForm');
    
    if (searchInput) {
        let timeout = null;
        searchInput.addEventListener('input', function() {
            clearTimeout(timeout);
            timeout = setTimeout(() => {
                if (this.value === '') {
                    searchForm.submit();
                }
            }, 500);
        });
    }
});
</script>
@endpush