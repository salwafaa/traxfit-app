@extends('layouts.app')

@section('title', 'Cek Status Member')
@section('page-title', 'Cek Status Member')

@section('sidebar')
@include('kasir.partials.sidebar')
@endsection

@section('content')
<div class="space-y-6 w-full max-w-full">

    {{-- ===== STATS ===== --}}
    <div class="grid grid-cols-2 lg:grid-cols-3 gap-4 w-full">

        {{-- Total Aktif --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-4">
            <div class="flex items-center justify-between">
                <div class="flex-1 min-w-0 pr-3">
                    <p class="text-xs text-gray-500 mb-1 truncate">Total Aktif</p>
                    <p class="text-2xl font-bold text-gray-800">{{ $totalActive ?? 0 }}</p>
                </div>
                <div class="w-11 h-11 bg-green-50 rounded-xl flex items-center justify-center flex-shrink-0">
                    <i class="fas fa-user-check text-[#27124A] text-lg"></i>
                </div>
            </div>
            <div class="mt-3 flex items-center gap-1 text-xs text-gray-500">
                <span>✅</span>
                <span>Member dengan status aktif</span>
            </div>
        </div>

        {{-- Expired Hari Ini --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-4">
            <div class="flex items-center justify-between">
                <div class="flex-1 min-w-0 pr-3">
                    <p class="text-xs text-gray-500 mb-1 truncate">Expired Hari Ini</p>
                    <p class="text-2xl font-bold text-red-600">{{ $expiredToday ?? 0 }}</p>
                </div>
                <div class="w-11 h-11 bg-red-50 rounded-xl flex items-center justify-center flex-shrink-0">
                    <i class="fas fa-times-circle text-[#27124A] text-lg"></i>
                </div>
            </div>
            <div class="mt-3 flex items-center gap-1 text-xs text-gray-500">
                <span>⚠️</span>
                <span>Keanggotaan berakhir hari ini</span>
            </div>
        </div>

        {{-- Akan Expired --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-4 col-span-2 lg:col-span-1">
            <div class="flex items-center justify-between">
                <div class="flex-1 min-w-0 pr-3">
                    <p class="text-xs text-gray-500 mb-1 truncate">Akan Expired ≤7 Hari</p>
                    <p class="text-2xl font-bold text-yellow-600">{{ $almostExpired ?? 0 }}</p>
                </div>
                <div class="w-11 h-11 bg-yellow-50 rounded-xl flex items-center justify-center flex-shrink-0">
                    <i class="fas fa-exclamation-triangle text-[#27124A] text-lg"></i>
                </div>
            </div>
            <div class="mt-3 flex items-center gap-1 text-xs text-gray-500">
                <span>🔔</span>
                <span>Perlu segera diperpanjang</span>
            </div>
        </div>

    </div>

    {{-- ===== CARD UTAMA ===== --}}
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">

        {{-- Header --}}
        <div class="px-5 py-4 border-b border-gray-100">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                <div>
                    <h3 class="text-base font-semibold text-gray-800">Daftar Status Member</h3>
                    <p class="text-sm text-gray-500 mt-0.5">Pantau status keanggotaan semua member</p>
                </div>
            </div>
        </div>

        {{-- Search & Filter --}}
        <div class="px-5 py-4 border-b border-gray-100 bg-gray-50/60">
            <div class="flex flex-col sm:flex-row gap-3">
                <div class="relative flex-1">
                    <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 text-sm pointer-events-none"></i>
                    <input type="text" id="searchInput"
                           placeholder="Cari nama, kode member, atau telepon..."
                           autocomplete="off"
                           class="w-full pl-10 pr-4 py-2 text-sm border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#27124A]/20 focus:border-[#27124A] transition-all bg-white">
                </div>
                <select id="filterStatus"
                        class="py-2 px-3 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-[#27124A]/20 focus:border-[#27124A] transition-all bg-white">
                    <option value="">Semua Status</option>
                    <option value="aktif">Aktif</option>
                    <option value="akan expired">Akan Expired</option>
                    <option value="expired">Expired</option>
                </select>
                <button type="button" id="resetBtn"
                        class="px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 rounded-xl text-sm font-medium flex items-center gap-2 transition-all duration-200">
                    <i class="fas fa-rotate-left"></i> Reset
                </button>
            </div>
            <p class="text-xs text-gray-400 mt-3">
                <i class="fas fa-info-circle mr-1 text-[#27124A]"></i>
                Menampilkan <span id="visibleCount" class="font-semibold text-gray-600">{{ $allMembers->count() }}</span>
                dari {{ $allMembers->count() }} member
            </p>
        </div>

        {{-- Grid member --}}
        <div id="membersList" class="p-5 grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-4">

            @forelse($allMembers as $member)
                @php
                    $today       = \Carbon\Carbon::now()->startOfDay();
                    $expiredDate = $member->tgl_expired
                        ? \Carbon\Carbon::parse($member->tgl_expired)->startOfDay()
                        : null;

                    if ($member->status == 'active' && $expiredDate && $expiredDate >= $today) {
                        $sisaHari = $today->diffInDays($expiredDate);
                        if ($sisaHari <= 7) {
                            $statusLabel = 'Akan Expired';
                            $statusKey   = 'akan expired';
                            $badgeCls    = 'bg-yellow-100 text-yellow-800';
                            $cardBorder  = 'border-yellow-200';
                            $iconStatus  = 'fa-exclamation-triangle text-yellow-500';
                            $sisaText    = $sisaHari . ' hari lagi';
                            $sisaCls     = 'text-yellow-700';
                        } else {
                            $statusLabel = 'Aktif';
                            $statusKey   = 'aktif';
                            $badgeCls    = 'bg-green-100 text-green-800';
                            $cardBorder  = 'border-green-200';
                            $iconStatus  = 'fa-check-circle text-green-500';
                            $sisaText    = $sisaHari . ' hari lagi';
                            $sisaCls     = 'text-green-700';
                        }
                        $isActive = true;
                    } else {
                        $statusLabel = 'Expired';
                        $statusKey   = 'expired';
                        $badgeCls    = 'bg-red-100 text-red-800';
                        $cardBorder  = 'border-red-200';
                        $iconStatus  = 'fa-times-circle text-red-500';
                        $sisaHari    = $expiredDate ? (int) abs($today->diffInDays($expiredDate, false)) : 0;
                        $sisaText    = $sisaHari > 0 ? $sisaHari . ' hari lalu' : 'Hari ini';
                        $sisaCls     = 'text-red-600';
                        $isActive    = false;
                    }
                @endphp

                <div class="member-card border {{ $cardBorder }} rounded-xl overflow-hidden hover:shadow-md transition-shadow"
                     data-nama="{{ strtolower($member->nama) }}"
                     data-kode="{{ strtolower($member->kode_member) }}"
                     data-telp="{{ strtolower($member->telepon ?? '') }}"
                     data-status="{{ $statusKey }}">

                    {{-- Card Header --}}
                    <div class="flex items-center justify-between px-4 pt-4 pb-3">
                        <div class="flex items-center gap-3 min-w-0">
                            <div class="w-10 h-10 rounded-xl bg-purple-100 flex items-center justify-center shrink-0">
                                <i class="fas fa-user text-purple-700"></i>
                            </div>
                            <div class="min-w-0">
                                <p class="font-semibold text-gray-800 text-sm truncate">{{ $member->nama }}</p>
                                <p class="text-xs text-gray-400 font-mono">{{ $member->kode_member }}</p>
                            </div>
                        </div>
                        <span class="ml-2 shrink-0 px-2.5 py-1 rounded-lg text-xs font-semibold {{ $badgeCls }}">
                            {{ $statusLabel }}
                        </span>
                    </div>

                    <hr class="border-gray-100">

                    {{-- Status bar --}}
                    <div class="px-4 pt-3">
                        <div class="flex items-center gap-2 px-3 py-2 rounded-xl bg-gray-50">
                            <i class="fas {{ $iconStatus }} text-sm shrink-0"></i>
                            <div class="min-w-0">
                                <p class="text-xs text-gray-500">Status Keanggotaan</p>
                                <p class="text-sm font-semibold {{ $sisaCls }}">
                                    {{ $statusLabel }}
                                    <span class="font-normal text-gray-400 text-xs">— {{ $sisaText }}</span>
                                </p>
                            </div>
                        </div>
                    </div>

                    {{-- Info rows --}}
                    <div class="px-4 py-3 flex flex-col gap-1.5 text-xs text-gray-500">
                        <div class="flex items-center gap-2">
                            <i class="fas fa-box w-4 text-center text-purple-400"></i>
                            <span class="truncate">{{ $member->package->nama_paket ?? '-' }}</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <i class="fas fa-phone w-4 text-center text-purple-400"></i>
                            <span>{{ $member->telepon ?? '-' }}</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <i class="fas fa-calendar-plus w-4 text-center text-purple-400"></i>
                            <span>Daftar: {{ $member->tgl_daftar ? \Carbon\Carbon::parse($member->tgl_daftar)->format('d/m/Y') : '-' }}</span>
                        </div>
                        <div class="flex items-center gap-2 {{ $sisaCls }} font-medium">
                            <i class="fas fa-calendar-times w-4 text-center"></i>
                            <span>Expired: {{ $expiredDate ? $expiredDate->format('d/m/Y') : '-' }}</span>
                        </div>
                    </div>

                    {{-- Card Footer --}}
                    @if(!$isActive || $statusLabel == 'Akan Expired')
                    <div class="px-4 pb-4">
                        <a href="{{ route('kasir.transaksi.membership.create') }}?member_id={{ $member->id }}&mode=renew"
                           class="w-full py-2 bg-green-600 hover:bg-green-700 text-white rounded-xl text-xs font-semibold transition flex items-center justify-center gap-2">
                            <i class="fas fa-redo"></i> Perpanjang Member
                        </a>
                    </div>
                    @endif

                </div>
            @empty
                <div class="col-span-3 text-center py-16 text-gray-400">
                    <div class="inline-flex items-center justify-center w-16 h-16 bg-purple-50 rounded-full mb-4">
                        <i class="fas fa-users text-2xl text-[#27124A]"></i>
                    </div>
                    <p class="text-base font-semibold text-gray-700 mb-1">Belum Ada Data Member</p>
                    <p class="text-sm text-gray-400">Tambahkan member terlebih dahulu untuk melihat statusnya.</p>
                </div>
            @endforelse

        </div>

        {{-- Empty search result — di luar grid supaya tidak ikut dihitung sebagai card --}}
        <div id="emptyResult" style="display:none;" class="text-center py-16 text-gray-400 px-6">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-purple-50 rounded-full mb-4">
                <i class="fas fa-user-slash text-2xl text-[#27124A]"></i>
            </div>
            <p class="text-base font-semibold text-gray-700 mb-1">Tidak Ada Member yang Cocok</p>
            <p class="text-sm text-gray-400">Coba kata kunci atau filter yang berbeda.</p>
        </div>

    </div>

</div>

{{-- ===== JAVASCRIPT — inline di sini, bukan @push, supaya pasti jalan setelah DOM siap ===== --}}
<script>
(function () {
    'use strict';

    /* Ambil semua elemen yang diperlukan */
    var searchInput  = document.getElementById('searchInput');
    var filterStatus = document.getElementById('filterStatus');
    var resetBtn     = document.getElementById('resetBtn');
    var membersList  = document.getElementById('membersList');
    var emptyResult  = document.getElementById('emptyResult');
    var visibleCount = document.getElementById('visibleCount');

    /* Ambil semua card satu kali saja */
    var allCards = membersList
        ? Array.from(membersList.querySelectorAll('.member-card'))
        : [];
    var total = allCards.length;

    function doFilter() {
        var keyword = (searchInput.value || '').toLowerCase().trim();
        var status  = (filterStatus.value || '').toLowerCase();
        var visible = 0;

        allCards.forEach(function (card) {
            var nama  = (card.getAttribute('data-nama') || '');
            var kode  = (card.getAttribute('data-kode') || '');
            var telp  = (card.getAttribute('data-telp') || '');
            var stat  = (card.getAttribute('data-status') || '');

            var matchSearch =
                keyword === '' ||
                nama.indexOf(keyword) !== -1 ||
                kode.indexOf(keyword) !== -1 ||
                telp.indexOf(keyword) !== -1;

            var matchStatus = status === '' || stat === status;

            if (matchSearch && matchStatus) {
                card.style.display = '';
                visible++;
            } else {
                card.style.display = 'none';
            }
        });

        /* Update counter */
        if (visibleCount) visibleCount.textContent = visible;

        /* Tampilkan pesan kosong hanya jika ada data tapi tidak ada yang cocok */
        if (emptyResult) {
            emptyResult.style.display = (total > 0 && visible === 0) ? 'block' : 'none';
        }
    }

    /* Pasang event listener langsung — tidak perlu DOMContentLoaded
       karena script ini ada di bawah elemen-elemen terkait */
    if (searchInput)  searchInput.addEventListener('input',  doFilter);
    if (filterStatus) filterStatus.addEventListener('change', doFilter);

    if (resetBtn) {
        resetBtn.addEventListener('click', function () {
            if (searchInput)  searchInput.value  = '';
            if (filterStatus) filterStatus.value = '';
            doFilter();
            if (searchInput) searchInput.focus();
        });
    }

})();
</script>

@endsection

@push('styles')
<style>
    .overflow-x-auto::-webkit-scrollbar { height: 5px; }
    .overflow-x-auto::-webkit-scrollbar-track { background: #f1f1f1; border-radius: 10px; }
    .overflow-x-auto::-webkit-scrollbar-thumb { background: #c1c1c1; border-radius: 10px; }
    .overflow-x-auto::-webkit-scrollbar-thumb:hover { background: #a0a0a0; }
</style>
@endpush