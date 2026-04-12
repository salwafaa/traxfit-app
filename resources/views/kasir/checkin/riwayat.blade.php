@extends('layouts.app')

@section('title', 'Riwayat Check-in')
@section('page-title', 'Riwayat Check-in')

@section('sidebar')
@include('kasir.partials.sidebar')
@endsection

@section('content')

{{-- ===== STATS ===== --}}
<div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">

    {{-- Total Check-in --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-4">
        <div class="flex items-center justify-between">
            <div class="flex-1 min-w-0 pr-3">
                <p class="text-xs text-gray-500 mb-1 truncate">Total Check-in</p>
                <p class="text-2xl font-bold text-gray-800">{{ $totalCheckins }}</p>
            </div>
            <div class="w-11 h-11 bg-blue-50 rounded-xl flex items-center justify-center flex-shrink-0">
                <i class="fas fa-calendar-check text-[#27124A] text-lg"></i>
            </div>
        </div>
        <div class="mt-3 flex items-center gap-1 text-xs text-gray-500">
            <span>📋</span>
            <span>Total seluruh check-in</span>
        </div>
    </div>

    {{-- Member Unik --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-4">
        <div class="flex items-center justify-between">
            <div class="flex-1 min-w-0 pr-3">
                <p class="text-xs text-gray-500 mb-1 truncate">Member Unik</p>
                <p class="text-2xl font-bold text-green-600">{{ $uniqueMembers }}</p>
            </div>
            <div class="w-11 h-11 bg-green-50 rounded-xl flex items-center justify-center flex-shrink-0">
                <i class="fas fa-users text-[#27124A] text-lg"></i>
            </div>
        </div>
        <div class="mt-3 flex items-center gap-1 text-xs text-gray-500">
            <span>👥</span>
            <span>Member berbeda yang check-in</span>
        </div>
    </div>

    {{-- Rata-rata Harian --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-4">
        <div class="flex items-center justify-between">
            <div class="flex-1 min-w-0 pr-3">
                <p class="text-xs text-gray-500 mb-1 truncate">Rata-rata Harian</p>
                <p class="text-2xl font-bold text-yellow-600">{{ $avgHarian }}</p>
            </div>
            <div class="w-11 h-11 bg-yellow-50 rounded-xl flex items-center justify-center flex-shrink-0">
                <i class="fas fa-chart-line text-[#27124A] text-lg"></i>
            </div>
        </div>
        <div class="mt-3 flex items-center gap-1 text-xs text-gray-500">
            <span>📈</span>
            <span>Rata-rata per hari</span>
        </div>
    </div>

    {{-- Rentang Tanggal --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-4">
        <div class="flex items-center justify-between">
            <div class="flex-1 min-w-0 pr-3">
                <p class="text-xs text-gray-500 mb-1 truncate">Rentang Tanggal</p>
                <p class="text-sm font-bold text-gray-800 leading-snug mt-1">
                    @if(request('start_date') && request('end_date'))
                        {{ \Carbon\Carbon::parse(request('start_date'))->format('d/m/Y') }}
                        &ndash;
                        {{ \Carbon\Carbon::parse(request('end_date'))->format('d/m/Y') }}
                    @else
                        Semua Tanggal
                    @endif
                </p>
            </div>
            <div class="w-11 h-11 bg-purple-50 rounded-xl flex items-center justify-center flex-shrink-0">
                <i class="fas fa-calendar-alt text-[#27124A] text-lg"></i>
            </div>
        </div>
        <div class="mt-3 flex items-center gap-1 text-xs text-gray-500">
            <span>📅</span>
            <span>Filter periode aktif</span>
        </div>
    </div>

</div>

{{-- ===== CARD UTAMA ===== --}}
<div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">

    {{-- Header --}}
    <div class="px-5 py-4 border-b border-gray-100">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
            <div>
                <h3 class="text-base font-semibold text-gray-800">Riwayat Check-in Member</h3>
                <p class="text-sm text-gray-500 mt-0.5">Lihat dan filter riwayat check-in member</p>
            </div>
            <a href="{{ route('kasir.checkin.index') }}"
               class="inline-flex items-center gap-2 px-4 py-2 bg-[#27124A] hover:bg-[#3a1d6b] text-white text-sm font-medium rounded-xl transition-all duration-200 shadow-sm">
                <i class="fas fa-plus"></i> Check-in Baru
            </a>
        </div>
    </div>

    {{-- Filter --}}
    <div class="px-5 py-4 border-b border-gray-100 bg-gray-50/60">
        <form method="GET" action="{{ route('kasir.checkin.riwayat') }}" id="filterForm">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3">

                <div>
                    <label class="block text-xs font-medium text-gray-600 mb-1.5" for="start_date">
                        <i class="fas fa-calendar-alt mr-1 text-[#27124A]"></i>Tanggal Mulai
                    </label>
                    <input type="date" id="start_date" name="start_date" value="{{ request('start_date') }}"
                           class="w-full px-3 py-2 text-sm border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#27124A]/20 focus:border-[#27124A] transition-all bg-white">
                </div>

                <div>
                    <label class="block text-xs font-medium text-gray-600 mb-1.5" for="end_date">
                        <i class="fas fa-calendar-alt mr-1 text-[#27124A]"></i>Tanggal Akhir
                    </label>
                    <input type="date" id="end_date" name="end_date" value="{{ request('end_date') }}"
                           class="w-full px-3 py-2 text-sm border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#27124A]/20 focus:border-[#27124A] transition-all bg-white">
                </div>

                <div>
                    <label class="block text-xs font-medium text-gray-600 mb-1.5" for="member">
                        <i class="fas fa-user mr-1 text-[#27124A]"></i>Member
                    </label>
                    <select id="member" name="member"
                            class="w-full px-3 py-2 text-sm border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#27124A]/20 focus:border-[#27124A] transition-all bg-white">
                        <option value="">Semua Member</option>
                        @foreach($members as $m)
                        <option value="{{ $m->id }}" {{ request('member') == $m->id ? 'selected' : '' }}>
                            {{ $m->kode_member }} - {{ $m->nama }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-medium text-gray-600 mb-1.5">&nbsp;</label>
                    <div class="flex gap-2">
                        <button type="submit"
                                class="flex-1 inline-flex items-center justify-center gap-1.5 bg-[#27124A] hover:bg-[#3a1d6b] text-white text-sm font-medium py-2 px-3 rounded-xl transition-all duration-200">
                            <i class="fas fa-filter text-xs"></i> Filter
                        </button>
                        <a href="{{ route('kasir.checkin.riwayat') }}"
                           class="flex-1 inline-flex items-center justify-center gap-1.5 bg-gray-200 hover:bg-gray-300 text-gray-700 text-sm font-medium py-2 px-3 rounded-xl transition-all duration-200">
                            <i class="fas fa-redo text-xs"></i> Reset
                        </a>
                    </div>
                </div>

            </div>
        </form>
    </div>

    {{-- Results --}}
    <div class="p-5">
        @if($checkins->isEmpty())
        <div class="text-center py-16">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-purple-50 rounded-full mb-4">
                <i class="fas fa-history text-2xl text-[#27124A]"></i>
            </div>
            <h4 class="text-base font-semibold text-gray-800 mb-1">Belum Ada Riwayat</h4>
            <p class="text-sm text-gray-400 max-w-sm mx-auto">Belum ada data check-in yang sesuai dengan filter yang dipilih.</p>
        </div>
        @else

        {{-- Info Row --}}
        <div class="mb-4 flex items-center">
            <p class="text-sm text-gray-500">
                <i class="fas fa-info-circle mr-1.5 text-[#27124A]"></i>
                Menampilkan
                <span class="font-medium text-gray-700">{{ $checkins->firstItem() ?? 0 }}</span>
                –
                <span class="font-medium text-gray-700">{{ $checkins->lastItem() ?? 0 }}</span>
                dari
                <span class="font-medium text-gray-700">{{ $checkins->total() }}</span>
                data check-in
            </p>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-100 text-sm">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wide w-10">No</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wide">Tanggal & Waktu</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wide">Member</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wide hidden md:table-cell">Paket</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wide hidden lg:table-cell">Expired</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wide hidden sm:table-cell">Kasir</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wide">Status</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-100">
                    @foreach($checkins as $checkin)
                    <tr class="hover:bg-gray-50/60 transition-colors duration-150">
                        <td class="px-4 py-3 whitespace-nowrap">
                            <div class="w-7 h-7 bg-gray-100 rounded-lg flex items-center justify-center text-xs font-semibold text-gray-600">
                                {{ $checkins->firstItem() + $loop->index }}
                            </div>
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap">
                            <div class="flex items-center gap-2">
                                <div class="w-7 h-7 bg-blue-50 rounded-lg flex items-center justify-center flex-shrink-0">
                                    <i class="fas fa-clock text-[#27124A] text-xs"></i>
                                </div>
                                <div>
                                    <p class="text-xs font-medium text-gray-800">
                                        {{ ($checkin->tanggal instanceof \Carbon\Carbon ? $checkin->tanggal : \Carbon\Carbon::parse($checkin->tanggal))->format('d/m/Y') }}
                                    </p>
                                    <p class="text-xs text-gray-400">
                                        {{ ($checkin->jam_masuk instanceof \Carbon\Carbon ? $checkin->jam_masuk : \Carbon\Carbon::parse($checkin->jam_masuk))->format('H:i') }}
                                    </p>
                                </div>
                            </div>
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap">
                            <div class="flex items-center gap-2">
                                <div class="w-7 h-7 bg-purple-50 rounded-full flex items-center justify-center flex-shrink-0">
                                    <i class="fas fa-user text-[#27124A] text-xs"></i>
                                </div>
                                <div>
                                    <p class="text-xs font-medium text-gray-800">{{ $checkin->member->nama ?? '-' }}</p>
                                    <p class="text-xs text-gray-400">{{ $checkin->member->kode_member ?? '-' }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap hidden md:table-cell">
                            <span class="px-2.5 py-1 bg-purple-50 text-purple-700 rounded-lg text-xs font-medium">
                                {{ $checkin->member->package->nama_paket ?? '-' }}
                            </span>
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap text-xs text-gray-600 hidden lg:table-cell">
                            {{ $checkin->member && $checkin->member->tgl_expired
                                ? \Carbon\Carbon::parse($checkin->member->tgl_expired)->format('d/m/Y')
                                : '-' }}
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap text-xs text-gray-600 hidden sm:table-cell">
                            {{ $checkin->kasir->nama ?? '-' }}
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap">
                            <span class="inline-flex items-center gap-1 px-2.5 py-1 bg-green-50 text-green-700 rounded-lg text-xs font-medium">
                                <i class="fas fa-check-circle text-xs"></i> Check-in
                            </span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if($checkins->hasPages())
        <div class="mt-5 border-t border-gray-100 pt-4">
            {{ $checkins->withQueryString()->links() }}
        </div>
        @endif

        @endif
    </div>

</div>

@endsection

@push('styles')
<style>
    table tbody tr { transition: background-color 0.15s ease; }

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
    .pagination li.active span { background-color: #27124A; color: white; border-color: #27124A; }
    .pagination li a:hover { background-color: #f7fafc; border-color: #cbd5e0; }

    .overflow-x-auto::-webkit-scrollbar { height: 5px; }
    .overflow-x-auto::-webkit-scrollbar-track { background: #f1f1f1; border-radius: 10px; }
    .overflow-x-auto::-webkit-scrollbar-thumb { background: #c1c1c1; border-radius: 10px; }
    .overflow-x-auto::-webkit-scrollbar-thumb:hover { background: #a0a0a0; }
</style>
 