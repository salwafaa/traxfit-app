@extends('layouts.app')

@section('title', 'Data Transaksi')
@section('page-title', 'Data Transaksi Saya')

@section('sidebar')
    @include('kasir.partials.sidebar')
@endsection

@section('content')
<!-- Header Stats -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500 mb-1">Total Transaksi</p>
                <p class="text-2xl font-bold text-gray-800">{{ $transactions->total() }}</p>
            </div>
            <div class="w-12 h-12 bg-blue-50 rounded-xl flex items-center justify-center">
                <i class="fas fa-cash-register text-[#27124A] text-xl"></i>
            </div>
        </div>
        <div class="mt-4 flex items-center text-xs text-gray-500">
            <span class="text-blue-500 mr-1">📊</span> Total seluruh transaksi
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500 mb-1">Total Pendapatan</p>
                <p class="text-2xl font-bold text-green-600">Rp {{ number_format($totalPendapatan ?? $transactions->sum('total_harga'), 0, ',', '.') }}</p>
            </div>
            <div class="w-12 h-12 bg-green-50 rounded-xl flex items-center justify-center">
                <i class="fas fa-money-bill-wave text-[#27124A] text-xl"></i>
            </div>
        </div>
        <div class="mt-4 flex items-center text-xs text-gray-500">
            <span class="text-green-500 mr-1">💰</span> Total pendapatan
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500 mb-1">Transaksi Member</p>
                <p class="text-2xl font-bold text-gray-800">{{ $totalMember ?? $transactions->whereNotNull('id_member')->count() }}</p>
            </div>
            <div class="w-12 h-12 bg-purple-50 rounded-xl flex items-center justify-center">
                <i class="fas fa-users text-[#27124A] text-xl"></i>
            </div>
        </div>
        <div class="mt-4 flex items-center text-xs text-gray-500">
            <span class="text-purple-500 mr-1">👥</span> Transaksi dari member
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500 mb-1">Transaksi Non-Member</p>
                <p class="text-2xl font-bold text-gray-800">{{ $totalNonMember ?? $transactions->whereNull('id_member')->count() }}</p>
            </div>
            <div class="w-12 h-12 bg-yellow-50 rounded-xl flex items-center justify-center">
                <i class="fas fa-user text-[#27124A] text-xl"></i>
            </div>
        </div>
        <div class="mt-4 flex items-center text-xs text-gray-500">
            <span class="text-yellow-500 mr-1">👤</span> Transaksi non-member
        </div>
    </div>
</div>

<!-- Main Content -->
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="p-6 border-b border-gray-100">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div>
                <h3 class="text-lg font-semibold text-gray-800">Daftar Transaksi</h3>
                <p class="text-sm text-gray-500 mt-1">Kelola dan lihat semua data transaksi</p>
            </div>
            <div class="flex items-center gap-3">
                <div class="text-sm bg-blue-50 text-[#27124A] px-4 py-2 rounded-xl">
                    Total Hari Ini: <span class="font-bold">Rp {{ number_format($totalToday, 0, ',', '.') }}</span>
                </div>
                <div class="flex items-center space-x-2">
                    <a href="{{ route('kasir.transaksi.membership.create') }}"
                        class="inline-flex items-center px-5 py-2.5 bg-purple-600 hover:bg-purple-700 text-white font-medium rounded-xl transition-all duration-300 shadow-sm hover:shadow-md">
                        <i class="fas fa-id-card mr-2"></i>
                        Membership
                    </a>
                    <a href="{{ route('kasir.transaksi.create') }}"
                        class="inline-flex items-center px-5 py-2.5 bg-[#27124A] hover:bg-[#3a1d6b] text-white font-medium rounded-xl transition-all duration-300 shadow-sm hover:shadow-md">
                        <i class="fas fa-plus mr-2"></i>
                        Transaksi Baru
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter -->
    <div class="p-6 border-b border-gray-100 bg-gray-50/50">
        <form method="GET" action="{{ route('kasir.transaksi.index') }}" class="grid grid-cols-1 md:grid-cols-5 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Mulai</label>
                <input type="date" name="start_date" value="{{ request('start_date') }}"
                    class="w-full px-4 py-2.5 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#27124A]/20 focus:border-[#27124A] transition-all">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Akhir</label>
                <input type="date" name="end_date" value="{{ request('end_date') }}"
                    class="w-full px-4 py-2.5 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#27124A]/20 focus:border-[#27124A] transition-all">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Status Member</label>
                <select name="member_status"
                    class="w-full px-4 py-2.5 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#27124A]/20 focus:border-[#27124A] transition-all">
                    <option value="">Semua</option>
                    <option value="member" {{ request('member_status') == 'member' ? 'selected' : '' }}>Member</option>
                    <option value="nonmember" {{ request('member_status') == 'nonmember' ? 'selected' : '' }}>Non-Member</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Metode Bayar</label>
                <select name="metode_bayar"
                    class="w-full px-4 py-2.5 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#27124A]/20 focus:border-[#27124A] transition-all">
                    <option value="">Semua</option>
                    <option value="cash" {{ request('metode_bayar') == 'cash' ? 'selected' : '' }}>Cash</option>
                    <option value="debit" {{ request('metode_bayar') == 'debit' ? 'selected' : '' }}>Debit</option>
                    <option value="credit" {{ request('metode_bayar') == 'credit' ? 'selected' : '' }}>Credit</option>
                    <option value="qris" {{ request('metode_bayar') == 'qris' ? 'selected' : '' }}>QRIS</option>
                </select>
            </div>

            <div class="flex items-end space-x-2">
                <button type="submit"
                    class="flex-1 bg-[#27124A] hover:bg-[#3a1d6b] text-white font-medium py-2.5 px-4 rounded-xl transition-all duration-300 shadow-sm hover:shadow-md flex items-center justify-center">
                    <i class="fas fa-filter mr-2"></i> Filter
                </button>
                <a href="{{ route('kasir.transaksi.index') }}"
                    class="flex-1 bg-gray-200 hover:bg-gray-300 text-gray-800 font-medium py-2.5 px-4 rounded-xl transition-all duration-300 flex items-center justify-center">
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
                    <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No. Transaksi</th>
                    <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Member</th>
                    <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                    <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pembayaran</th>
                    <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Waktu</th>
                    <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-100">
                @forelse($transactions as $transaction)
                    <tr class="hover:bg-gray-50 transition-colors duration-150">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center justify-center w-8 h-8 bg-gray-100 rounded-lg text-gray-600 font-medium text-sm">
                                {{ $loop->iteration + ($transactions->currentPage() - 1) * $transactions->perPage() }}
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <a href="{{ route('kasir.transaksi.show', $transaction->id) }}"
                                class="flex items-center font-mono font-semibold text-[#27124A] hover:text-[#3a1d6b]">
                                <div class="w-8 h-8 bg-purple-50 rounded-lg flex items-center justify-center mr-2">
                                    <i class="fas fa-receipt text-xs text-[#27124A]"></i>
                                </div>
                                {{ $transaction->nomor_unik }}
                            </a>
                        </td>
                        <td class="px-6 py-4">
                            @if($transaction->member)
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 w-8 h-8 bg-green-50 rounded-full flex items-center justify-center mr-2">
                                        <i class="fas fa-user text-[#27124A] text-xs"></i>
                                    </div>
                                    <div>
                                        <div class="font-medium text-gray-800">{{ $transaction->member->nama }}</div>
                                        <div class="text-xs text-gray-400">{{ $transaction->member->kode_member }}</div>
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
                            <span
                                class="px-3 py-1.5 text-xs rounded-lg font-medium
                                @if($transaction->metode_bayar == 'cash') bg-green-50 text-green-700
                                @elseif($transaction->metode_bayar == 'debit') bg-blue-50 text-blue-700
                                @elseif($transaction->metode_bayar == 'credit') bg-purple-50 text-purple-700
                                @else bg-yellow-50 text-yellow-700
                                @endif">
                                <i class="fas fa-{{ $transaction->metode_bayar == 'cash' ? 'money-bill-wave' : ($transaction->metode_bayar == 'qris' ? 'qrcode' : 'credit-card') }} mr-1"></i>
                                {{ ucfirst($transaction->metode_bayar) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="w-8 h-8 bg-gray-50 rounded-lg flex items-center justify-center mr-2">
                                    <i class="fas fa-clock text-gray-400 text-xs"></i>
                                </div>
                                <div>
                                    <div class="text-sm text-gray-700">{{ $transaction->created_at->format('H:i') }}</div>
                                    <div class="text-xs text-gray-400">{{ $transaction->created_at->format('d/m/Y') }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center space-x-2">
                                <a href="{{ route('kasir.transaksi.show', $transaction->id) }}"
                                    class="p-2 bg-blue-50 hover:bg-blue-100 text-blue-600 rounded-lg transition-all duration-300 border border-blue-100"
                                    title="Detail Transaksi">
                                    <i class="fas fa-eye text-sm"></i>
                                </a>
                                <a href="{{ route('kasir.transaksi.struk', $transaction->id) }}"
                                    class="p-2 bg-green-50 hover:bg-green-100 text-green-600 rounded-lg transition-all duration-300 border border-green-100"
                                    title="Cetak Struk" target="_blank">
                                    <i class="fas fa-print text-sm"></i>
                                </a>
                                
                                {{-- Tombol Kartu Member khusus untuk transaksi membership --}}
                                @if(in_array($transaction->jenis_transaksi, ['membership', 'produk_membership']))
                                <a href="{{ route('kasir.transaksi.membership.kartu', $transaction->id) }}"
                                    class="p-2 bg-purple-50 hover:bg-purple-100 text-purple-600 rounded-lg transition-all duration-300 border border-purple-100"
                                    title="Kartu Member" target="_blank">
                                    <i class="fas fa-id-card text-sm"></i>
                                </a>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-6 py-12 text-center">
                            <div class="inline-flex items-center justify-center w-20 h-20 bg-purple-50 rounded-full mb-4">
                                <i class="fas fa-shopping-cart text-3xl text-[#27124A]"></i>
                            </div>
                            <h4 class="text-lg font-semibold text-gray-800 mb-2">Belum Ada Transaksi</h4>
                            <p class="text-gray-400 text-sm mb-4">Belum ada data transaksi. Mulai lakukan transaksi pertama Anda</p>
                            <div class="flex items-center justify-center space-x-3">
                                <a href="{{ route('kasir.transaksi.membership.create') }}"
                                    class="inline-flex items-center px-5 py-2.5 bg-purple-600 hover:bg-purple-700 text-white font-medium rounded-xl transition-all duration-300 shadow-sm hover:shadow-md">
                                    <i class="fas fa-id-card mr-2"></i>
                                    Transaksi Membership
                                </a>
                                <a href="{{ route('kasir.transaksi.create') }}"
                                    class="inline-flex items-center px-5 py-2.5 bg-[#27124A] hover:bg-[#3a1d6b] text-white font-medium rounded-xl transition-all duration-300 shadow-sm hover:shadow-md">
                                    <i class="fas fa-plus mr-2"></i>
                                    Transaksi Baru
                                </a>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    @if($transactions->hasPages())
        <div class="p-6 border-t border-gray-100">
            {{ $transactions->withQueryString()->links() }}
        </div>
    @endif
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
    // Auto submit form when filter changes
    document.querySelectorAll('select[name="member_status"], select[name="metode_bayar"]').forEach(select => {
        select.addEventListener('change', function() {
            this.form.submit();
        });
    });

    // Confirmation for reset filter
    document.querySelector('a[href="{{ route("kasir.transaksi.index") }}"]').addEventListener('click', function(e) {
        const hasFilters = '{{ request()->hasAny(["start_date", "end_date", "member_status", "metode_bayar"]) }}' === '1';
        if (hasFilters && !confirm('Reset semua filter?')) {
            e.preventDefault();
        }
    });
</script>
@endpush