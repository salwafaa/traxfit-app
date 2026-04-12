@extends('layouts.app')

@section('title', 'Data Transaksi')
@section('page-title', 'Data Transaksi Saya')

@section('sidebar')
    @include('kasir.partials.sidebar')
@endsection

@section('content')
<div class="space-y-6 w-full max-w-full">

    {{-- ===================== HEADER STATS ===================== --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 w-full">

        {{-- Total Transaksi --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-4">
            <div class="flex items-center justify-between">
                <div class="flex-1 min-w-0 pr-3">
                    <p class="text-xs text-gray-500 mb-1 truncate">Total Transaksi</p>
                    <p class="text-2xl font-bold text-gray-800">{{ $transactions->total() }}</p>
                </div>
                <div class="w-11 h-11 bg-blue-50 rounded-xl flex items-center justify-center flex-shrink-0">
                    <i class="fas fa-cash-register text-[#27124A] text-lg"></i>
                </div>
            </div>
            <div class="mt-3 flex items-center gap-1 text-xs text-gray-500">
                <span>📊</span>
                <span>Total seluruh transaksi</span>
            </div>
        </div>

        {{-- Total Pendapatan --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-4">
            <div class="flex items-center justify-between">
                <div class="flex-1 min-w-0 pr-3">
                    <p class="text-xs text-gray-500 mb-1 truncate">Total Pendapatan</p>
                    <p class="text-lg font-bold text-green-600 truncate">
                        Rp {{ number_format($totalPendapatan ?? $transactions->sum('total_harga'), 0, ',', '.') }}
                    </p>
                </div>
                <div class="w-11 h-11 bg-green-50 rounded-xl flex items-center justify-center flex-shrink-0">
                    <i class="fas fa-money-bill-wave text-[#27124A] text-lg"></i>
                </div>
            </div>
            <div class="mt-3 flex items-center gap-1 text-xs text-gray-500">
                <span>💰</span>
                <span>Total pendapatan</span>
            </div>
        </div>

        {{-- Transaksi Member --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-4">
            <div class="flex items-center justify-between">
                <div class="flex-1 min-w-0 pr-3">
                    <p class="text-xs text-gray-500 mb-1 truncate">Transaksi Member</p>
                    <p class="text-2xl font-bold text-gray-800">
                        {{ $totalMember ?? $transactions->whereNotNull('id_member')->count() }}
                    </p>
                </div>
                <div class="w-11 h-11 bg-purple-50 rounded-xl flex items-center justify-center flex-shrink-0">
                    <i class="fas fa-users text-[#27124A] text-lg"></i>
                </div>
            </div>
            <div class="mt-3 flex items-center gap-1 text-xs text-gray-500">
                <span>👥</span>
                <span>Transaksi dari member</span>
            </div>
        </div>

        {{-- Transaksi Non-Member --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-4">
            <div class="flex items-center justify-between">
                <div class="flex-1 min-w-0 pr-3">
                    <p class="text-xs text-gray-500 mb-1 truncate">Non-Member</p>
                    <p class="text-2xl font-bold text-gray-800">
                        {{ $totalNonMember ?? $transactions->whereNull('id_member')->count() }}
                    </p>
                </div>
                <div class="w-11 h-11 bg-yellow-50 rounded-xl flex items-center justify-center flex-shrink-0">
                    <i class="fas fa-user text-[#27124A] text-lg"></i>
                </div>
            </div>
            <div class="mt-3 flex items-center gap-1 text-xs text-gray-500">
                <span>👤</span>
                <span>Transaksi non-member</span>
            </div>
        </div>

    </div>

    {{-- ===================== MAIN CARD ===================== --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden w-full">

        {{-- ---- Card Header ---- --}}
        <div class="px-5 py-4 border-b border-gray-100">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                <div>
                    <h3 class="text-base font-semibold text-gray-800">Daftar Transaksi</h3>
                    <p class="text-sm text-gray-500 mt-0.5">Kelola dan lihat semua data transaksi</p>
                </div>
                <div class="flex flex-wrap items-center gap-2">
                    <div class="text-sm bg-blue-50 text-[#27124A] px-3 py-2 rounded-xl whitespace-nowrap">
                        Hari Ini: <span class="font-bold">Rp {{ number_format($totalToday, 0, ',', '.') }}</span>
                    </div>
                    <a href="{{ route('kasir.transaksi.membership.create') }}"
                       class="inline-flex items-center gap-2 px-4 py-2 bg-[#27124A] hover:bg-[#3a1d6b] text-white text-sm font-medium rounded-xl transition-all duration-200 shadow-sm">
                        <i class="fas fa-id-card"></i>
                        Transaksi Membership
                    </a>
                    <a href="{{ route('kasir.transaksi.create') }}"
                        class="inline-flex items-center gap-1.5 px-4 py-2 bg-[#27124A] hover:bg-[#3a1d6b] text-white font-medium rounded-xl text-sm transition-all duration-200">
                        <i class="fas fa-plus"></i>
                        Transaksi Baru
                    </a>
                </div>
            </div>
        </div>

        {{-- ---- Filter ---- --}}
        <div class="px-5 py-4 border-b border-gray-100 bg-gray-50/60">
            <form method="GET" action="{{ route('kasir.transaksi.index') }}">
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3">

                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1.5">Tanggal Mulai</label>
                        <input type="date" name="start_date" value="{{ request('start_date') }}"
                            class="w-full px-3 py-2 text-sm border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#27124A]/20 focus:border-[#27124A] transition-all bg-white">
                    </div>

                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1.5">Tanggal Akhir</label>
                        <input type="date" name="end_date" value="{{ request('end_date') }}"
                            class="w-full px-3 py-2 text-sm border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#27124A]/20 focus:border-[#27124A] transition-all bg-white">
                    </div>

                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1.5">Status Member</label>
                        <select name="member_status"
                            class="w-full px-3 py-2 text-sm border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#27124A]/20 focus:border-[#27124A] transition-all bg-white">
                            <option value="">Semua</option>
                            <option value="member" {{ request('member_status') == 'member' ? 'selected' : '' }}>Member</option>
                            <option value="nonmember" {{ request('member_status') == 'nonmember' ? 'selected' : '' }}>Non-Member</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1.5">&nbsp;</label>
                        <div class="flex gap-2">
                            <button type="submit"
                                class="flex-1 inline-flex items-center justify-center gap-1.5 bg-[#27124A] hover:bg-[#3a1d6b] text-white text-sm font-medium py-2 px-3 rounded-xl transition-all duration-200">
                                <i class="fas fa-filter text-xs"></i>
                                Filter
                            </button>
                            <a href="{{ route('kasir.transaksi.index') }}"
                                class="flex-1 inline-flex items-center justify-center gap-1.5 bg-gray-200 hover:bg-gray-300 text-gray-700 text-sm font-medium py-2 px-3 rounded-xl transition-all duration-200">
                                <i class="fas fa-redo text-xs"></i>
                                Reset
                            </a>
                        </div>
                    </div>

                </div>
            </form>
        </div>

        {{-- ---- Info Row ---- --}}
        <div class="px-5 py-3 border-b border-gray-100 flex items-center">
            <p class="text-sm text-gray-500">
                <i class="fas fa-info-circle mr-1.5 text-[#27124A]"></i>
                Menampilkan
                <span class="font-medium text-gray-700">{{ $transactions->firstItem() ?? 0 }}</span>
                –
                <span class="font-medium text-gray-700">{{ $transactions->lastItem() ?? 0 }}</span>
                dari
                <span class="font-medium text-gray-700">{{ $transactions->total() }}</span>
                transaksi
            </p>
        </div>

        {{-- ---- Table ---- --}}
        <div class="overflow-x-auto w-full">
            <table class="min-w-full divide-y divide-gray-100 text-sm">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wide w-10">No</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wide">No. Transaksi</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wide hidden lg:table-cell">Member</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wide">Total</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wide hidden sm:table-cell">Pembayaran</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wide hidden md:table-cell">Waktu</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wide">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-100">
                    @forelse($transactions as $transaction)
                        <tr class="hover:bg-gray-50/60 transition-colors duration-150">

                            {{-- No --}}
                            <td class="px-4 py-3 whitespace-nowrap">
                                <div class="w-7 h-7 bg-gray-100 rounded-lg flex items-center justify-center text-xs font-semibold text-gray-600">
                                    {{ $loop->iteration + ($transactions->currentPage() - 1) * $transactions->perPage() }}
                                </div>
                            </td>

                            {{-- No. Transaksi --}}
                            <td class="px-4 py-3 whitespace-nowrap">
                                <a href="{{ route('kasir.transaksi.show', $transaction->id) }}"
                                    class="inline-flex items-center gap-2 font-mono font-semibold text-[#27124A] hover:text-[#3a1d6b] text-xs">
                                    <div class="w-7 h-7 bg-purple-50 rounded-lg flex items-center justify-center flex-shrink-0">
                                        <i class="fas fa-receipt text-xs text-[#27124A]"></i>
                                    </div>
                                    {{ $transaction->nomor_unik }}
                                </a>
                            </td>

                            {{-- Member --}}
                            <td class="px-4 py-3 whitespace-nowrap hidden lg:table-cell">
                                @if($transaction->member)
                                    <div class="flex items-center gap-2">
                                        <div class="w-7 h-7 bg-green-50 rounded-full flex items-center justify-center flex-shrink-0">
                                            <i class="fas fa-user text-[#27124A] text-xs"></i>
                                        </div>
                                        <div>
                                            <div class="font-medium text-gray-800 text-xs leading-tight">{{ $transaction->member->nama }}</div>
                                            <div class="text-xs text-gray-400 leading-tight">{{ $transaction->member->kode_member }}</div>
                                        </div>
                                    </div>
                                @else
                                    <span class="inline-block px-2 py-1 bg-gray-100 text-gray-500 rounded-lg text-xs font-medium">Non-Member</span>
                                @endif
                            </td>

                            {{-- Total --}}
                            <td class="px-4 py-3 whitespace-nowrap">
                                <span class="inline-block px-2.5 py-1 bg-blue-50 text-[#27124A] rounded-lg text-xs font-bold">
                                    Rp {{ number_format($transaction->total_harga, 0, ',', '.') }}
                                </span>
                            </td>

                            {{-- Pembayaran --}}
                            <td class="px-4 py-3 whitespace-nowrap hidden sm:table-cell">
                                <div class="flex items-center gap-2">
                                    <div class="w-7 h-7 bg-gray-50 rounded-lg flex items-center justify-center flex-shrink-0">
                                        <i class="fas fa-wallet text-gray-400 text-xs"></i>
                                    </div>
                                    <div>
                                        <div class="text-xs text-gray-700 leading-tight capitalize">{{ $transaction->metode_bayar ?? '-' }}</div>
                                        <div class="text-xs text-gray-400 leading-tight">{{ $transaction->created_at->format('d/m/Y') }}</div>
                                    </div>
                                </div>
                            </td>

                            {{-- Waktu --}}
                            <td class="px-4 py-3 whitespace-nowrap hidden md:table-cell">
                                <div class="flex items-center gap-2">
                                    <div class="w-7 h-7 bg-gray-50 rounded-lg flex items-center justify-center flex-shrink-0">
                                        <i class="fas fa-clock text-gray-400 text-xs"></i>
                                    </div>
                                    <div>
                                        <div class="text-xs text-gray-700 leading-tight">{{ $transaction->created_at->format('H:i') }}</div>
                                        <div class="text-xs text-gray-400 leading-tight">{{ $transaction->created_at->format('d/m/Y') }}</div>
                                    </div>
                                </div>
                            </td>

                            {{-- Aksi --}}
                            <td class="px-4 py-3 whitespace-nowrap">
                                <div class="flex items-center gap-1.5">
                                    <a href="{{ route('kasir.transaksi.show', $transaction->id) }}"
                                        class="w-8 h-8 inline-flex items-center justify-center bg-blue-50 hover:bg-blue-100 text-blue-600 rounded-lg border border-blue-100 transition-all duration-200"
                                        title="Detail Transaksi">
                                        <i class="fas fa-eye text-xs"></i>
                                    </a>
                                    <a href="{{ route('kasir.transaksi.struk', $transaction->id) }}"
                                        class="w-8 h-8 inline-flex items-center justify-center bg-green-50 hover:bg-green-100 text-green-600 rounded-lg border border-green-100 transition-all duration-200"
                                        title="Cetak Struk" target="_blank">
                                        <i class="fas fa-print text-xs"></i>
                                    </a>
                                    @if(in_array($transaction->jenis_transaksi, ['membership', 'produk_membership']))
                                    <a href="{{ route('kasir.transaksi.membership.kartu', $transaction->id) }}"
                                        class="w-8 h-8 inline-flex items-center justify-center bg-purple-50 hover:bg-purple-100 text-purple-600 rounded-lg border border-purple-100 transition-all duration-200"
                                        title="Kartu Member" target="_blank">
                                        <i class="fas fa-id-card text-xs"></i>
                                    </a>
                                    @endif
                                </div>
                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-4 py-12 text-center">
                                <div class="inline-flex items-center justify-center w-16 h-16 bg-purple-50 rounded-full mb-4">
                                    <i class="fas fa-shopping-cart text-2xl text-[#27124A]"></i>
                                </div>
                                <h4 class="text-base font-semibold text-gray-800 mb-1">Belum Ada Transaksi</h4>
                                <p class="text-sm text-gray-400 mb-5">Belum ada data transaksi. Mulai lakukan transaksi pertama Anda.</p>
                                <div class="flex items-center justify-center gap-2">
                                    <a href="{{ route('kasir.transaksi.membership.create') }}"
                                        class="inline-flex items-center gap-2 px-4 py-2 bg-purple-600 hover:bg-purple-700 text-white font-medium rounded-xl text-sm transition-all duration-200">
                                        <i class="fas fa-id-card"></i>
                                        Transaksi Membership
                                    </a>
                                    <a href="{{ route('kasir.transaksi.create') }}"
                                        class="inline-flex items-center gap-2 px-4 py-2 bg-[#27124A] hover:bg-[#3a1d6b] text-white font-medium rounded-xl text-sm transition-all duration-200">
                                        <i class="fas fa-plus"></i>
                                        Transaksi Baru
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- ---- Pagination ---- --}}
        @if($transactions->hasPages())
        <div class="px-5 py-4 border-t border-gray-100">
            {{ $transactions->withQueryString()->links() }}
        </div>
        @endif

    </div>
</div>
@endsection

@push('styles')
<style>
    table tbody tr {
        transition: background-color 0.15s ease;
    }

    /* Pagination */
    .pagination {
        display: flex;
        justify-content: center;
        flex-wrap: wrap;
        list-style: none;
        padding: 0;
        margin: 0;
        gap: 4px;
    }
    .pagination li a,
    .pagination li span {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 2rem;
        padding: 0.35rem 0.6rem;
        font-size: 0.8rem;
        border: 1px solid #e2e8f0;
        border-radius: 0.5rem;
        color: #4a5568;
        text-decoration: none;
        transition: all 0.15s ease;
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

    /* Scrollbar */
    .overflow-x-auto::-webkit-scrollbar { height: 5px; }
    .overflow-x-auto::-webkit-scrollbar-track { background: #f1f1f1; border-radius: 10px; }
    .overflow-x-auto::-webkit-scrollbar-thumb { background: #c1c1c1; border-radius: 10px; }
    .overflow-x-auto::-webkit-scrollbar-thumb:hover { background: #a0a0a0; }
</style>
@endpush