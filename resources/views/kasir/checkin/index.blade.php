@extends('layouts.app')

@section('title', 'Check-in Member')
@section('page-title', 'Check-in Member')

@section('sidebar')
@include('kasir.partials.sidebar')
@endsection

@section('content')

{{-- =============================================
     STYLE
     ============================================= --}}
<style>
.member-card { transition: all 0.2s ease; }
.member-card.hidden-card { display: none !important; }
.filter-btn { cursor: pointer; transition: all 0.2s; }
.filter-btn.aktif { background-color: #27124A !important; color: #fff !important; }
.checkin-btn { cursor: pointer; }
.checkin-btn:disabled { opacity: 0.6; cursor: not-allowed; }
@keyframes fadeIn { from { opacity:0; transform:translateY(-10px); } to { opacity:1; transform:translateY(0); } }
#modal-sukses { animation: fadeIn 0.2s ease; }
</style>

{{-- ===== STATS — disamakan dengan desain riwayat ===== --}}
<div class="grid grid-cols-2 lg:grid-cols-5 gap-4 mb-6">

    {{-- Total Member --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-4">
        <div class="flex items-center justify-between">
            <div class="flex-1 min-w-0 pr-3">
                <p class="text-xs text-gray-500 mb-1 truncate">Total Member</p>
                <p class="text-2xl font-bold text-gray-800">{{ $membersWithStatus->count() }}</p>
            </div>
            <div class="w-11 h-11 bg-purple-50 rounded-xl flex items-center justify-center flex-shrink-0">
                <i class="fas fa-users text-[#27124A] text-lg"></i>
            </div>
        </div>
        <div class="mt-3 flex items-center gap-1 text-xs text-gray-500">
            <span>👥</span>
            <span>Semua member terdaftar</span>
        </div>
    </div>

    {{-- Aktif --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-4">
        <div class="flex items-center justify-between">
            <div class="flex-1 min-w-0 pr-3">
                <p class="text-xs text-gray-500 mb-1 truncate">Aktif</p>
                <p class="text-2xl font-bold text-green-600">{{ $activeCount }}</p>
            </div>
            <div class="w-11 h-11 bg-green-50 rounded-xl flex items-center justify-center flex-shrink-0">
                <i class="fas fa-user-check text-[#27124A] text-lg"></i>
            </div>
        </div>
        <div class="mt-3 flex items-center gap-1 text-xs text-gray-500">
            <span>✅</span>
            <span>Member masih aktif</span>
        </div>
    </div>

    {{-- Sudah Check-in --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-4">
        <div class="flex items-center justify-between">
            <div class="flex-1 min-w-0 pr-3">
                <p class="text-xs text-gray-500 mb-1 truncate">Sudah Check-in</p>
                <p class="text-2xl font-bold text-blue-600">{{ $checkedInCount }}</p>
            </div>
            <div class="w-11 h-11 bg-blue-50 rounded-xl flex items-center justify-center flex-shrink-0">
                <i class="fas fa-calendar-check text-[#27124A] text-lg"></i>
            </div>
        </div>
        <div class="mt-3 flex items-center gap-1 text-xs text-gray-500">
            <span>📋</span>
            <span>Check-in hari ini</span>
        </div>
    </div>

    {{-- Akan Expired --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-4">
        <div class="flex items-center justify-between">
            <div class="flex-1 min-w-0 pr-3">
                <p class="text-xs text-gray-500 mb-1 truncate">Akan Expired</p>
                <p class="text-2xl font-bold text-yellow-500">{{ $almostExpiredCount }}</p>
            </div>
            <div class="w-11 h-11 bg-yellow-50 rounded-xl flex items-center justify-center flex-shrink-0">
                <i class="fas fa-exclamation-triangle text-[#27124A] text-lg"></i>
            </div>
        </div>
        <div class="mt-3 flex items-center gap-1 text-xs text-gray-500">
            <span>⚠️</span>
            <span>Hampir expired</span>
        </div>
    </div>

    {{-- Expired --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-4">
        <div class="flex items-center justify-between">
            <div class="flex-1 min-w-0 pr-3">
                <p class="text-xs text-gray-500 mb-1 truncate">Expired</p>
                <p class="text-2xl font-bold text-red-500">{{ $expiredCount }}</p>
            </div>
            <div class="w-11 h-11 bg-red-50 rounded-xl flex items-center justify-center flex-shrink-0">
                <i class="fas fa-times-circle text-[#27124A] text-lg"></i>
            </div>
        </div>
        <div class="mt-3 flex items-center gap-1 text-xs text-gray-500">
            <span>❌</span>
            <span>Member expired</span>
        </div>
    </div>

</div>

{{-- ===== CARD UTAMA ===== --}}
<div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">

    {{-- Header --}}
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-3 p-6 border-b border-gray-100">
        <div>
            <h3 class="text-lg font-semibold text-gray-800">Daftar Semua Member</h3>
            <p class="text-sm text-gray-500 mt-0.5">Klik tombol Check-in Sekarang untuk absensi member</p>
        </div>
        <a href="{{ route('kasir.checkin.riwayat') }}"
           class="px-5 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-xl text-sm font-medium flex items-center gap-2">
            <i class="fas fa-history"></i> Riwayat Check-in
        </a>
    </div>

    {{-- Search --}}
    <div class="p-6 border-b border-gray-100 bg-purple-50/40">
        <div class="flex flex-col sm:flex-row gap-3 max-w-2xl">
            <div class="relative flex-1">
                <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 text-sm"></i>
                <input type="text" id="inputCari" placeholder="Cari nama, kode member, atau telepon..."
                       class="w-full pl-10 pr-4 py-3 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-purple-300 focus:border-purple-400">
            </div>
            <button id="btnReset"
                    class="px-5 py-3 bg-white border border-gray-200 hover:bg-gray-100 text-gray-600 rounded-xl text-sm font-medium flex items-center gap-2">
                <i class="fas fa-times"></i> Reset
            </button>
        </div>
    </div>

    {{-- Filter tabs --}}
    <div id="tabContainer" class="flex flex-wrap gap-2 px-6 py-3 border-b border-gray-100">
        <button class="filter-btn aktif px-4 py-1.5 rounded-lg text-sm font-medium bg-gray-100 text-gray-700"
                data-filter="semua">
            <i class="fas fa-users mr-1"></i> Semua ({{ $membersWithStatus->count() }})
        </button>
        <button class="filter-btn px-4 py-1.5 rounded-lg text-sm font-medium bg-gray-100 text-gray-700"
                data-filter="active">
            <i class="fas fa-user-check mr-1 text-green-500"></i> Aktif ({{ $activeCount }})
        </button>
        <button class="filter-btn px-4 py-1.5 rounded-lg text-sm font-medium bg-gray-100 text-gray-700"
                data-filter="checked-in">
            <i class="fas fa-check-circle mr-1 text-blue-500"></i> Sudah Check-in ({{ $checkedInCount }})
        </button>
        <button class="filter-btn px-4 py-1.5 rounded-lg text-sm font-medium bg-gray-100 text-gray-700"
                data-filter="almost-expired">
            <i class="fas fa-exclamation-triangle mr-1 text-yellow-500"></i> Akan Expired ({{ $almostExpiredCount }})
        </button>
        <button class="filter-btn px-4 py-1.5 rounded-lg text-sm font-medium bg-gray-100 text-gray-700"
                data-filter="expired">
            <i class="fas fa-times-circle mr-1 text-red-500"></i> Expired ({{ $expiredCount }})
        </button>
    </div>

    {{-- Grid member --}}
    <div id="gridMember" class="p-6 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-5">

        @forelse($membersWithStatus as $m)
        <div class="member-card border rounded-xl p-5 hover:shadow-md transition-shadow"
             data-status="{{ $m['status_class'] }}"
             data-nama="{{ strtolower($m['nama']) }}"
             data-kode="{{ strtolower($m['kode_member']) }}"
             data-telp="{{ strtolower($m['telepon']) }}">

            {{-- Nama & badge --}}
            <div class="flex justify-between items-start mb-3">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center
                        {{ $m['status_badge'] == 'success' ? 'bg-green-100' : ($m['status_badge'] == 'warning' ? 'bg-yellow-100' : ($m['status_badge'] == 'danger' ? 'bg-red-100' : 'bg-purple-100')) }}">
                        <i class="fas fa-user text-lg
                            {{ $m['status_badge'] == 'success' ? 'text-green-600' : ($m['status_badge'] == 'warning' ? 'text-yellow-600' : ($m['status_badge'] == 'danger' ? 'text-red-500' : 'text-purple-600')) }}"></i>
                    </div>
                    <div>
                        <p class="font-semibold text-gray-900 text-sm leading-tight">{{ $m['nama'] }}</p>
                        <p class="text-xs text-gray-400">{{ $m['kode_member'] }}</p>
                    </div>
                </div>
                <span class="badge-status text-xs font-medium px-2 py-1 rounded-lg
                    {{ $m['status_badge'] == 'success' ? 'bg-green-100 text-green-700' : ($m['status_badge'] == 'warning' ? 'bg-yellow-100 text-yellow-700' : ($m['status_badge'] == 'danger' ? 'bg-red-100 text-red-600' : 'bg-blue-100 text-blue-700')) }}">
                    {{ $m['status_text'] }}
                </span>
            </div>

            {{-- Info --}}
            <div class="space-y-1.5 mb-4 text-xs text-gray-500">
                <div class="flex items-center gap-2">
                    <i class="fas fa-phone w-4 text-gray-300"></i>
                    <span>{{ $m['telepon'] }}</span>
                </div>
                <div class="flex items-center gap-2">
                    <i class="fas fa-box w-4 text-gray-300"></i>
                    <span>{{ $m['paket'] }}</span>
                </div>
                <div class="flex items-center gap-2">
                    <i class="fas fa-calendar-alt w-4 text-gray-300"></i>
                    <span>Expired: {{ $m['expired_formatted'] }}</span>
                </div>
                <div class="flex items-center gap-2">
                    <i class="fas fa-hourglass-half w-4 text-gray-300"></i>
                    <span class="{{ $m['status_badge'] == 'warning' ? 'text-yellow-600 font-semibold' : '' }}">
                        {{ $m['sisa_hari_text'] }}
                    </span>
                </div>
            </div>

            {{-- Tombol aksi --}}
            <div class="pt-3 border-t border-gray-100">
                @if($m['can_checkin'])
                    <button type="button"
                            class="checkin-btn w-full py-2.5 bg-[#27124A] hover:bg-[#3d1c70] text-white rounded-xl text-sm font-semibold flex items-center justify-center gap-2 transition-colors"
                            data-id="{{ $m['id'] }}">
                        <i class="fas fa-sign-in-alt"></i>
                        Check-in Sekarang
                    </button>
                @elseif($m['checked_in_today'])
                    <button disabled
                            class="w-full py-2.5 bg-green-100 text-green-600 rounded-xl text-sm font-semibold flex items-center justify-center gap-2 cursor-not-allowed">
                        <i class="fas fa-check-circle"></i>
                        Sudah Check-in
                    </button>
                @else
                    <button disabled
                            class="w-full py-2.5 bg-red-100 text-red-400 rounded-xl text-sm font-semibold flex items-center justify-center gap-2 cursor-not-allowed">
                        <i class="fas fa-ban"></i>
                        Member Expired
                    </button>
                @endif
            </div>
        </div>
        @empty
        {{-- Belum ada member sama sekali di database --}}
        <div class="col-span-full text-center py-16">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-purple-50 rounded-full mb-4">
                <i class="fas fa-users text-2xl text-[#27124A]"></i>
            </div>
            <h4 class="text-base font-semibold text-gray-800 mb-1">Belum Ada Member</h4>
            <p class="text-sm text-gray-400 max-w-sm mx-auto">Belum ada member terdaftar di sistem.</p>
        </div>
        @endforelse

        {{-- Pesan kosong saat filter/search tidak ada hasil — tersembunyi secara default --}}
        <div id="emptyFilter" class="col-span-full text-center py-16" style="display:none;">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-purple-50 rounded-full mb-4">
                <i class="fas fa-search text-2xl text-[#27124A]"></i>
            </div>
            <h4 class="text-base font-semibold text-gray-800 mb-1">Tidak Ada Member Ditemukan</h4>
            <p class="text-sm text-gray-400 max-w-sm mx-auto">Coba ubah kata kunci atau pilih filter yang berbeda.</p>
        </div>
    </div>
</div>

{{-- ===== CHECK-IN HARI INI ===== --}}
<div class="mt-6 bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
    <div class="flex justify-between items-center p-6 border-b border-gray-100">
        <div>
            <h4 class="text-base font-semibold text-gray-800">
                <i class="fas fa-clock mr-2 text-[#27124A]"></i>Check-in Hari Ini
            </h4>
            <p class="text-xs text-gray-400 mt-0.5">{{ now()->format('d F Y') }}</p>
        </div>
        <button onclick="location.reload()"
                class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-600 rounded-xl text-sm flex items-center gap-2">
            <i class="fas fa-sync-alt"></i> Refresh
        </button>
    </div>
    <div class="p-6">
        <div id="emptyToday" class="{{ $todayCheckins->isEmpty() ? '' : 'hidden' }} text-center py-8">
            <i class="fas fa-user-clock text-4xl text-gray-200 mb-3"></i>
            <p class="text-gray-400 text-sm">Belum ada check-in hari ini</p>
        </div>
        <div id="wrapperTableToday" class="{{ $todayCheckins->isEmpty() ? 'hidden' : '' }} overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead>
                    <tr class="bg-gray-50">
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500">Waktu</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500">Member</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500">Paket</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500">Kasir</th>
                    </tr>
                </thead>
                <tbody id="bodyTableToday" class="divide-y divide-gray-50">
                    @foreach($todayCheckins as $ci)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-3 font-medium">{{ $ci->jam_masuk->format('H:i') }}</td>
                        <td class="px-4 py-3">
                            <p class="font-medium text-gray-800">{{ $ci->member->nama ?? '-' }}</p>
                            <p class="text-xs text-gray-400">{{ $ci->member->kode_member ?? '-' }}</p>
                        </td>
                        <td class="px-4 py-3 text-gray-600">{{ $ci->member->package->nama_paket ?? '-' }}</td>
                        <td class="px-4 py-3 text-gray-600">{{ $ci->kasir->nama ?? '-' }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- ===== MODAL SUKSES ===== --}}
<div id="overlaySukses"
     style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.55); z-index:9999; align-items:center; justify-content:center;">
    <div id="modal-sukses" class="bg-white rounded-2xl shadow-2xl w-full max-w-md mx-4 p-6">
        <div class="text-center mb-4">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-green-100 rounded-full mb-3">
                <i class="fas fa-check-circle text-green-500 text-3xl"></i>
            </div>
            <h3 class="text-xl font-bold text-gray-800">Check-in Berhasil! 🎉</h3>
        </div>
        <div id="isiSukses" class="bg-green-50 border border-green-200 rounded-xl p-4 mb-4 text-sm"></div>
        <button id="btnTutupModal"
                class="w-full py-3 bg-[#27124A] hover:bg-[#3d1c70] text-white font-semibold rounded-xl transition-colors">
            Tutup
        </button>
    </div>
</div>

{{-- ===== TOAST ERROR ===== --}}
<div id="toastError"
     style="display:none; position:fixed; bottom:1.5rem; right:1.5rem; z-index:9999;">
    <div class="flex items-center gap-3 bg-red-100 border-l-4 border-red-500 text-red-700 px-4 py-3 rounded-xl shadow-lg min-w-[280px]">
        <i class="fas fa-exclamation-circle text-red-500"></i>
        <span id="teksError" class="flex-1 text-sm"></span>
        <button onclick="document.getElementById('toastError').style.display='none'" class="text-red-400 hover:text-red-600">
            <i class="fas fa-times"></i>
        </button>
    </div>
</div>

{{-- =============================================
     JAVASCRIPT
     ============================================= --}}
<script>
(function () {
    'use strict';

    /* -------------------------------------------------------
       CONFIG
    ------------------------------------------------------- */
    var CSRF    = '{{ csrf_token() }}';
    var URL_CI  = '{{ route("kasir.checkin.store") }}';
    var KASIR   = '{{ addslashes(auth()->user()->nama ?? auth()->user()->name ?? "Kasir") }}';

    /* -------------------------------------------------------
       HELPERS
    ------------------------------------------------------- */
    function esc(str) {
        var d = document.createElement('div');
        d.textContent = (str == null) ? '' : String(str);
        return d.innerHTML;
    }

    function tampilError(msg) {
        document.getElementById('teksError').textContent = msg;
        document.getElementById('toastError').style.display = 'block';
        setTimeout(function () {
            document.getElementById('toastError').style.display = 'none';
        }, 5000);
    }

    function tutupModal() {
        document.getElementById('overlaySukses').style.display = 'none';
    }

    function tampilSukses(d) {
        document.getElementById('isiSukses').innerHTML =
            '<div style="display:grid;grid-template-columns:auto 1fr;gap:4px 12px;">' +
            '<span style="color:#6b7280">Nama</span><strong>' + esc(d.nama) + '</strong>' +
            '<span style="color:#6b7280">Kode</span><strong>' + esc(d.kode_member) + '</strong>' +
            '<span style="color:#6b7280">Waktu</span><strong style="color:#16a34a">' + esc(d.waktu) + ' &mdash; ' + esc(d.tanggal) + '</strong>' +
            '<span style="color:#6b7280">Paket</span><strong>' + esc(d.paket) + '</strong>' +
            '<span style="color:#6b7280">Expired</span><strong>' + esc(d.expired) + '</strong>' +
            '<span style="color:#6b7280">Sisa</span><strong>' + esc(d.sisa_hari) + '</strong>' +
            '</div>';
        document.getElementById('overlaySukses').style.display = 'flex';
    }

    /* -------------------------------------------------------
       CHECK-IN
    ------------------------------------------------------- */
    function lakukanCheckin(memberId, btn) {
        if (!memberId) { tampilError('ID member tidak valid.'); return; }
        if (!confirm('Yakin check-in member ini?')) return;

        var htmlLama = btn.innerHTML;
        btn.disabled = true;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i>&nbsp;Memproses...';

        fetch(URL_CI, {
            method : 'POST',
            headers: {
                'Content-Type' : 'application/json',
                'X-CSRF-TOKEN' : CSRF,
                'Accept'       : 'application/json'
            },
            body: JSON.stringify({ member_id: memberId })
        })
        .then(function (res) {
            if (res.status === 419) {
                throw new Error('Sesi habis. Silakan refresh halaman (F5) lalu coba lagi.');
            }
            return res.json();
        })
        .then(function (json) {
            if (json.success) {
                /* Update tombol */
                btn.innerHTML = '<i class="fas fa-check-circle"></i>&nbsp;Sudah Check-in';
                btn.className = 'w-full py-2.5 bg-green-100 text-green-600 rounded-xl text-sm font-semibold flex items-center justify-center gap-2 cursor-not-allowed';
                btn.disabled  = true;

                /* Update badge card */
                var card = btn.closest('.member-card');
                if (card) {
                    card.setAttribute('data-status', 'checked-in');
                    var badge = card.querySelector('.badge-status');
                    if (badge) {
                        badge.className = 'badge-status text-xs font-medium px-2 py-1 rounded-lg bg-green-100 text-green-700';
                        badge.textContent = 'Sudah Check-in';
                    }
                }

                /* Tambah baris di tabel hari ini */
                var emptyToday   = document.getElementById('emptyToday');
                var wrapperTable = document.getElementById('wrapperTableToday');
                var tbody        = document.getElementById('bodyTableToday');

                if (emptyToday)   emptyToday.classList.add('hidden');
                if (wrapperTable) wrapperTable.classList.remove('hidden');

                if (tbody) {
                    var tr = document.createElement('tr');
                    tr.style.backgroundColor = '#f0fdf4';
                    tr.innerHTML =
                        '<td class="px-4 py-3 font-medium">' + esc(json.checkin.waktu) + '</td>' +
                        '<td class="px-4 py-3"><p class="font-medium text-gray-800">' + esc(json.checkin.nama) +
                            '</p><p class="text-xs text-gray-400">' + esc(json.checkin.kode_member) + '</p></td>' +
                        '<td class="px-4 py-3 text-gray-600">' + esc(json.checkin.paket) + '</td>' +
                        '<td class="px-4 py-3 text-gray-600">' + esc(KASIR) + '</td>';
                    tbody.insertBefore(tr, tbody.firstChild);
                    setTimeout(function () { tr.style.backgroundColor = ''; }, 3000);
                }

                tampilSukses(json.checkin);

            } else {
                tampilError(json.message || 'Gagal check-in.');
                btn.disabled  = false;
                btn.innerHTML = htmlLama;
            }
        })
        .catch(function (err) {
            tampilError(err.message || 'Terjadi kesalahan jaringan. Coba lagi.');
            btn.disabled  = false;
            btn.innerHTML = htmlLama;
        });
    }

    /* -------------------------------------------------------
       FILTER & SEARCH
    ------------------------------------------------------- */
    var filterAktif = 'semua';

    function terapkanFilter() {
        var kata  = (document.getElementById('inputCari').value || '').trim().toLowerCase();
        var cards = document.querySelectorAll('#gridMember .member-card');
        var tampil = 0;

        cards.forEach(function (c) {
            var status = c.getAttribute('data-status') || '';
            var match_filter =
                filterAktif === 'semua' ||
                (filterAktif === 'active'         && status === 'active')         ||
                (filterAktif === 'checked-in'     && status === 'checked-in')     ||
                (filterAktif === 'almost-expired' && status === 'almost-expired') ||
                (filterAktif === 'expired'        && status === 'expired');

            var match_cari =
                !kata ||
                (c.getAttribute('data-nama') || '').indexOf(kata) !== -1 ||
                (c.getAttribute('data-kode') || '').indexOf(kata) !== -1 ||
                (c.getAttribute('data-telp') || '').indexOf(kata) !== -1;

            if (match_filter && match_cari) {
                c.classList.remove('hidden-card');
                tampil++;
            } else {
                c.classList.add('hidden-card');
            }
        });

        /* Tampilkan/sembunyikan pesan kosong filter */
        var emp = document.getElementById('emptyFilter');
        if (emp) {
            /* Hanya tampilkan jika memang ada member di database tapi hasil filter kosong */
            if (tampil === 0 && cards.length > 0) {
                emp.style.display = 'block';
            } else {
                emp.style.display = 'none';
            }
        }
    }

    /* -------------------------------------------------------
       EVENT LISTENERS
    ------------------------------------------------------- */

    /* Modal tutup */
    document.getElementById('btnTutupModal').addEventListener('click', tutupModal);
    document.getElementById('overlaySukses').addEventListener('click', function (e) {
        if (e.target === this) tutupModal();
    });

    /* Filter tab — event delegation pada #tabContainer */
    document.getElementById('tabContainer').addEventListener('click', function (e) {
        var btn = e.target.closest('.filter-btn');
        if (!btn) return;
        document.querySelectorAll('.filter-btn').forEach(function (b) { b.classList.remove('aktif'); });
        btn.classList.add('aktif');
        filterAktif = btn.getAttribute('data-filter') || 'semua';
        terapkanFilter();
    });

    /* Search */
    document.getElementById('inputCari').addEventListener('input', terapkanFilter);

    /* Reset */
    document.getElementById('btnReset').addEventListener('click', function () {
        document.getElementById('inputCari').value = '';
        filterAktif = 'semua';
        document.querySelectorAll('.filter-btn').forEach(function (b) { b.classList.remove('aktif'); });
        var btnSemua = document.querySelector('.filter-btn[data-filter="semua"]');
        if (btnSemua) btnSemua.classList.add('aktif');
        terapkanFilter();
    });

    /* TOMBOL CHECK-IN — event delegation pada #gridMember */
    document.getElementById('gridMember').addEventListener('click', function (e) {
        var btn = e.target.closest('.checkin-btn');
        if (!btn || btn.disabled) return;
        var id = parseInt(btn.getAttribute('data-id'), 10);
        if (id) lakukanCheckin(id, btn);
    });

})();
</script>

@endsection