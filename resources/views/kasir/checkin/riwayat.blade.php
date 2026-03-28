@extends('layouts.app')

@section('title', 'Riwayat Check-in')
@section('page-title', 'Riwayat Check-in')

@section('sidebar')
@include('kasir.partials.sidebar')
@endsection

@section('content')
<!-- Header Stats -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
    <!-- Total Check-in -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500 mb-1">Total Check-in</p>
                <p class="text-2xl font-bold text-gray-800">{{ $checkins->total() }}</p>
            </div>
            <div class="w-12 h-12 bg-blue-50 rounded-xl flex items-center justify-center">
                <i class="fas fa-history text-[#27124A] text-xl"></i>
            </div>
        </div>
        <div class="mt-4 flex items-center text-xs text-gray-500">
            <span class="text-blue-500 mr-1">📊</span> Total seluruh check-in member
        </div>
    </div>

    <!-- Member Unik -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500 mb-1">Member Unik</p>
                <p class="text-2xl font-bold text-gray-800">{{ $checkins->unique('id_member')->count() }}</p>
            </div>
            <div class="w-12 h-12 bg-green-50 rounded-xl flex items-center justify-center">
                <i class="fas fa-users text-[#27124A] text-xl"></i>
            </div>
        </div>
        <div class="mt-4 flex items-center text-xs text-gray-500">
            <span class="text-green-500 mr-1">👥</span> Member yang pernah check-in
        </div>
    </div>

    <!-- Rata-rata Harian -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500 mb-1">Rata-rata Harian</p>
                <p class="text-2xl font-bold text-yellow-600">
                    {{ $checkins->total() > 0 ? number_format($checkins->total() / max(1, $checkins->groupBy(function($item) { return $item->tanggal->format('Y-m-d'); })->count()), 1) : 0 }}
                </p>
            </div>
            <div class="w-12 h-12 bg-yellow-50 rounded-xl flex items-center justify-center">
                <i class="fas fa-chart-line text-[#27124A] text-xl"></i>
            </div>
        </div>
        <div class="mt-4 flex items-center text-xs text-gray-500">
            <span class="text-yellow-500 mr-1">📈</span> Rata-rata check-in per hari
        </div>
    </div>

    <!-- Rentang Tanggal -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500 mb-1">Rentang Tanggal</p>
                <p class="text-lg font-bold text-gray-800">
                    @if(request('start_date') && request('end_date'))
                    {{ date('d/m/Y', strtotime(request('start_date'))) }} - {{ date('d/m/Y', strtotime(request('end_date'))) }}
                    @else
                    Semua Tanggal
                    @endif
                </p>
            </div>
            <div class="w-12 h-12 bg-purple-50 rounded-xl flex items-center justify-center">
                <i class="fas fa-calendar-alt text-[#27124A] text-xl"></i>
            </div>
        </div>
        <div class="mt-4 flex items-center text-xs text-gray-500">
            <span class="text-purple-500 mr-1">📅</span> Periode data yang ditampilkan
        </div>
    </div>
</div>

<!-- Main Content -->
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="p-6 border-b border-gray-100">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div>
                <h3 class="text-lg font-semibold text-gray-800">Riwayat Check-in Member</h3>
                <p class="text-sm text-gray-500 mt-1">Lihat dan filter riwayat check-in member</p>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('kasir.checkin.index') }}" 
                   class="inline-flex items-center px-5 py-2.5 bg-[#27124A] hover:bg-[#3a1d6b] text-white font-medium rounded-xl transition-all duration-300 shadow-sm hover:shadow-md">
                    <i class="fas fa-plus mr-2"></i>
                    Check-in Baru
                </a>
            </div>
        </div>
    </div>
    
    <!-- Filter Form -->
    <div class="p-6 border-b border-gray-100 bg-gray-50/50">
        <form method="GET" action="{{ route('kasir.checkin.riwayat') }}" id="filterForm">
            <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2" for="start_date">
                        <i class="fas fa-calendar-alt mr-2 text-[#27124A]"></i>Tanggal Mulai
                    </label>
                    <input type="date" id="start_date" name="start_date" value="{{ request('start_date') }}"
                           class="w-full px-4 py-2.5 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#27124A]/20 focus:border-[#27124A] transition-all">
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2" for="end_date">
                        <i class="fas fa-calendar-alt mr-2 text-[#27124A]"></i>Tanggal Akhir
                    </label>
                    <input type="date" id="end_date" name="end_date" value="{{ request('end_date') }}"
                           class="w-full px-4 py-2.5 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#27124A]/20 focus:border-[#27124A] transition-all">
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2" for="member">
                        <i class="fas fa-user mr-2 text-[#27124A]"></i>Member
                    </label>
                    <select id="member" name="member" 
                            class="w-full px-4 py-2.5 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#27124A]/20 focus:border-[#27124A] transition-all">
                        <option value="">Semua Member</option>
                        @foreach($members as $member)
                        <option value="{{ $member->id }}" {{ request('member') == $member->id ? 'selected' : '' }}>
                            {{ $member->kode_member }} - {{ $member->nama }}
                        </option>
                        @endforeach
                    </select>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2"> </label>
                    <div class="flex space-x-2">
                        <button type="submit" 
                                class="flex-1 bg-[#27124A] hover:bg-[#3a1d6b] text-white font-medium py-2.5 px-4 rounded-xl transition-all duration-300 shadow-sm hover:shadow-md flex items-center justify-center">
                            <i class="fas fa-filter mr-2"></i> Filter
                        </button>
                        <a href="{{ route('kasir.checkin.riwayat') }}" 
                           class="flex-1 bg-gray-200 hover:bg-gray-300 text-gray-800 font-medium py-2.5 px-4 rounded-xl transition-all duration-300 flex items-center justify-center">
                            <i class="fas fa-redo mr-2"></i> Reset
                        </a>
                    </div>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2"> </label>
                    <div class="flex space-x-2">
                        <button type="button" onclick="exportToCSV()" 
                                class="flex-1 bg-green-600 hover:bg-green-700 text-white font-medium py-2.5 px-4 rounded-xl transition-all duration-300 shadow-sm hover:shadow-md flex items-center justify-center">
                            <i class="fas fa-file-csv mr-2"></i> CSV
                        </button>
                        <button type="button" onclick="window.print()" 
                                class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-medium py-2.5 px-4 rounded-xl transition-all duration-300 shadow-sm hover:shadow-md flex items-center justify-center">
                            <i class="fas fa-print mr-2"></i> Cetak
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
    
    <!-- Results -->
    <div class="p-6">
        @if($checkins->isEmpty())
        <div class="text-center py-12">
            <div class="inline-flex items-center justify-center w-24 h-24 bg-gray-100 rounded-full mb-4">
                <i class="fas fa-history text-4xl text-gray-400"></i>
            </div>
            <h4 class="text-lg font-semibold text-gray-800 mb-2">Belum Ada Data Check-in</h4>
            <p class="text-gray-400 text-sm max-w-md mx-auto mb-4">
                Tidak ada data check-in yang sesuai dengan filter yang dipilih.
            </p>
            <a href="{{ route('kasir.checkin.index') }}" 
               class="inline-flex items-center px-5 py-2.5 bg-[#27124A] hover:bg-[#3a1d6b] text-white font-medium rounded-xl transition-all duration-300">
                <i class="fas fa-plus mr-2"></i>
                Check-in Member
            </a>
        </div>
        @else
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-100">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Waktu</th>
                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Member</th>
                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Paket</th>
                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kasir</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-100">
                    @foreach($checkins as $checkin)
                    <tr class="hover:bg-gray-50 transition-colors duration-150">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="w-10 h-10 bg-purple-50 rounded-lg flex items-center justify-center mr-3">
                                    <i class="fas fa-calendar-day text-[#27124A]"></i>
                                </div>
                                <div>
                                    <div class="font-medium text-gray-800">
                                        {{ $checkin->tanggal->format('d/m/Y') }}
                                    </div>
                                    <div class="text-xs text-gray-400">
                                        {{ $checkin->tanggal->translatedFormat('l') }}
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="w-8 h-8 bg-green-50 rounded-lg flex items-center justify-center mr-2">
                                    <i class="fas fa-clock text-[#27124A] text-xs"></i>
                                </div>
                                <div>
                                    <div class="text-sm font-medium text-gray-800">
                                        {{ $checkin->jam_masuk->format('H:i') }}
                                    </div>
                                    <div class="text-xs text-gray-400">
                                        {{ $checkin->created_at->diffForHumans() }}
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 w-10 h-10 bg-blue-50 rounded-full flex items-center justify-center mr-3">
                                    <i class="fas fa-user text-[#27124A]"></i>
                                </div>
                                <div>
                                    <div class="font-medium text-gray-800">
                                        {{ $checkin->member->nama }}
                                    </div>
                                    <div class="text-xs text-gray-400">
                                        {{ $checkin->member->kode_member }}
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-3 py-1.5 bg-blue-50 text-[#27124A] rounded-lg text-sm font-medium">
                                {{ $checkin->member->package->nama_paket ?? '-' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="w-8 h-8 bg-gray-50 rounded-lg flex items-center justify-center mr-2">
                                    <i class="fas fa-user-tie text-gray-400 text-xs"></i>
                                </div>
                                <span class="text-sm text-gray-700">
                                    {{ $checkin->kasir->nama ?? '-' }}
                                </span>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        <div class="mt-6">
            {{ $checkins->withQueryString()->links() }}
        </div>
        
        <!-- Summary -->
        <div class="mt-6 pt-6 border-t border-gray-100">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="bg-blue-50/50 rounded-xl p-4 border border-blue-100">
                    <div class="flex items-center">
                        <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center mr-3">
                            <i class="fas fa-calendar-check text-[#27124A]"></i>
                        </div>
                        <div>
                            <p class="text-xs text-blue-700">Total Check-in</p>
                            <p class="text-xl font-bold text-blue-800">{{ $checkins->total() }}</p>
                        </div>
                    </div>
                </div>
                
                <div class="bg-green-50/50 rounded-xl p-4 border border-green-100">
                    <div class="flex items-center">
                        <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center mr-3">
                            <i class="fas fa-users text-[#27124A]"></i>
                        </div>
                        <div>
                            <p class="text-xs text-green-700">Member Unik</p>
                            <p class="text-xl font-bold text-green-800">{{ $checkins->unique('id_member')->count() }}</p>
                        </div>
                    </div>
                </div>
                
                <div class="bg-purple-50/50 rounded-xl p-4 border border-purple-100">
                    <div class="flex items-center">
                        <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center mr-3">
                            <i class="fas fa-chart-bar text-[#27124A]"></i>
                        </div>
                        <div>
                            <p class="text-xs text-purple-700">Rata-rata Harian</p>
                            <p class="text-xl font-bold text-purple-800">
                                {{ $checkins->total() > 0 ? number_format($checkins->total() / max(1, $checkins->groupBy(function($item) { return $item->tanggal->format('Y-m-d'); })->count()), 1) : 0 }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>

<!-- Instructions -->
<div class="mt-8 bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="p-6 border-b border-gray-100">
        <h4 class="text-lg font-semibold text-gray-800">📋 Petunjuk Penggunaan</h4>
        <p class="text-sm text-gray-500 mt-1">Panduan lengkap menggunakan fitur riwayat check-in</p>
    </div>
    <div class="p-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="flex items-start p-4 bg-blue-50/50 rounded-xl border border-blue-100">
                <div class="flex-shrink-0 w-10 h-10 bg-blue-100 rounded-xl flex items-center justify-center mr-3">
                    <i class="fas fa-filter text-[#27124A]"></i>
                </div>
                <div>
                    <h5 class="font-medium text-gray-800">Filter Data</h5>
                    <p class="text-xs text-gray-600 mt-1">Gunakan filter untuk mencari data check-in berdasarkan periode atau member tertentu</p>
                </div>
            </div>
            
            <div class="flex items-start p-4 bg-green-50/50 rounded-xl border border-green-100">
                <div class="flex-shrink-0 w-10 h-10 bg-green-100 rounded-xl flex items-center justify-center mr-3">
                    <i class="fas fa-download text-[#27124A]"></i>
                </div>
                <div>
                    <h5 class="font-medium text-gray-800">Ekspor Data</h5>
                    <p class="text-xs text-gray-600 mt-1">Ekspor data ke format CSV untuk analisis lebih lanjut atau arsip</p>
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
function exportToCSV() {
    // Collect filter data
    const filters = {
        start_date: document.getElementById('start_date').value,
        end_date: document.getElementById('end_date').value,
        member: document.getElementById('member').value
    };
    
    // Build query string
    const queryString = Object.keys(filters)
        .filter(key => filters[key])
        .map(key => `${key}=${encodeURIComponent(filters[key])}`)
        .join('&');
    
    // Open download URL
    window.open(`/kasir/checkin/export?${queryString}`, '_blank');
}

// Auto submit form when filter changes (optional)
document.getElementById('member').addEventListener('change', function() {
    document.getElementById('filterForm').submit();
});
</script>
@endpush