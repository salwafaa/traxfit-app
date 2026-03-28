@extends('layouts.app')

@section('title', 'Laporan Member')
@section('page-title', 'Laporan Member')

@section('sidebar')
@include('owner.partials.sidebar')
@endsection

@section('content')
<div class="space-y-4 md:space-y-6 w-full max-w-full">
    <!-- Header dengan Export -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
        <div>
            <h1 class="text-2xl md:text-3xl font-bold text-gray-900">Laporan Member</h1>
            <p class="text-xs md:text-sm text-gray-500 mt-1">Informasi lengkap member gym dan aktivitasnya</p>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('owner.laporan.member', array_merge(request()->query(), ['export' => 'pdf'])) }}" 
               class="bg-red-600 hover:bg-red-700 text-white px-3 md:px-4 py-1.5 md:py-2 rounded-lg md:rounded-xl text-xs md:text-sm transition-all duration-300 flex items-center shadow-sm">
                <i class="fas fa-file-pdf mr-1 md:mr-2"></i> PDF
            </a>
            <a href="{{ route('owner.laporan.member', array_merge(request()->query(), ['export' => 'excel'])) }}" 
               class="bg-green-600 hover:bg-green-700 text-white px-3 md:px-4 py-1.5 md:py-2 rounded-lg md:rounded-xl text-xs md:text-sm transition-all duration-300 flex items-center shadow-sm">
                <i class="fas fa-file-excel mr-1 md:mr-2"></i> Excel
            </a>
        </div>
    </div>

    <!-- Info Section -->
    <div class="bg-blue-50 border border-blue-200 rounded-xl md:rounded-2xl p-3 md:p-4 flex items-center">
        <div class="w-6 h-6 md:w-8 md:h-8 bg-blue-100 rounded-full flex items-center justify-center mr-2 md:mr-3 flex-shrink-0">
            <i class="fas fa-info-circle text-blue-600 text-xs md:text-sm"></i>
        </div>
        <p class="text-xs md:text-sm text-blue-800">
            <span class="font-semibold">Informasi:</span> Menampilkan data member gym. 
            Gunakan filter untuk melihat data spesifik berdasarkan status, paket, atau periode.
        </p>
    </div>

    <!-- Stats Cards - 6 Cards -->
    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-2 md:gap-3">
        <!-- Total Member -->
        <div class="bg-white rounded-xl md:rounded-2xl shadow-sm border border-gray-100 p-3 md:p-4">
            <div class="flex items-center justify-between mb-2">
                <p class="text-xs text-gray-500">Total Member</p>
                <div class="w-8 h-8 bg-blue-50 rounded-lg flex items-center justify-center">
                    <i class="fas fa-users text-[#27124A] text-sm"></i>
                </div>
            </div>
            <p class="text-lg md:text-2xl font-bold text-gray-800">{{ number_format($totalMember, 0, ',', '.') }}</p>
            <div class="mt-2 flex items-center text-xs text-gray-500">
                <span class="text-blue-500 mr-1">👥</span> Seluruh member
            </div>
        </div>

        <!-- Member Aktif -->
        <div class="bg-white rounded-xl md:rounded-2xl shadow-sm border border-gray-100 p-3 md:p-4">
            <div class="flex items-center justify-between mb-2">
                <p class="text-xs text-gray-500">Member Aktif</p>
                <div class="w-8 h-8 bg-green-50 rounded-lg flex items-center justify-center">
                    <i class="fas fa-user-check text-green-600 text-sm"></i>
                </div>
            </div>
            <p class="text-lg md:text-2xl font-bold text-green-600">{{ number_format($memberAktif, 0, ',', '.') }}</p>
            <div class="mt-2 flex items-center text-xs text-gray-500">
                <span class="text-green-500 mr-1">✅</span> Status aktif
            </div>
        </div>

        <!-- Akan Expired -->
        <div class="bg-white rounded-xl md:rounded-2xl shadow-sm border border-gray-100 p-3 md:p-4">
            <div class="flex items-center justify-between mb-2">
                <p class="text-xs text-gray-500">Akan Expired</p>
                <div class="w-8 h-8 bg-yellow-50 rounded-lg flex items-center justify-center">
                    <i class="fas fa-clock text-yellow-600 text-sm"></i>
                </div>
            </div>
            <p class="text-lg md:text-2xl font-bold text-yellow-600">{{ number_format($expiringSoon, 0, ',', '.') }}</p>
            <div class="mt-2 flex items-center text-xs text-gray-500">
                <span class="text-yellow-500 mr-1">⏰</span> Expired ≤ 7 hari
            </div>
        </div>

        <!-- Member Expired -->
        <div class="bg-white rounded-xl md:rounded-2xl shadow-sm border border-gray-100 p-3 md:p-4">
            <div class="flex items-center justify-between mb-2">
                <p class="text-xs text-gray-500">Member Expired</p>
                <div class="w-8 h-8 bg-red-50 rounded-lg flex items-center justify-center">
                    <i class="fas fa-user-times text-red-600 text-sm"></i>
                </div>
            </div>
            <p class="text-lg md:text-2xl font-bold text-red-600">{{ number_format($memberExpired, 0, ',', '.') }}</p>
            <div class="mt-2 flex items-center text-xs text-gray-500">
                <span class="text-red-500 mr-1">❌</span> Sudah expired
            </div>
        </div>

        <!-- Member Pending -->
        <div class="bg-white rounded-xl md:rounded-2xl shadow-sm border border-gray-100 p-3 md:p-4">
            <div class="flex items-center justify-between mb-2">
                <p class="text-xs text-gray-500">Member Pending</p>
                <div class="w-8 h-8 bg-purple-50 rounded-lg flex items-center justify-center">
                    <i class="fas fa-hourglass-half text-purple-600 text-sm"></i>
                </div>
            </div>
            <p class="text-lg md:text-2xl font-bold text-purple-600">{{ number_format($memberPending, 0, ',', '.') }}</p>
            <div class="mt-2 flex items-center text-xs text-gray-500">
                <span class="text-purple-500 mr-1">⏳</span> Menunggu aktivasi
            </div>
        </div>

        <!-- Persentase Aktif -->
        <div class="bg-white rounded-xl md:rounded-2xl shadow-sm border border-gray-100 p-3 md:p-4">
            <div class="flex items-center justify-between mb-2">
                <p class="text-xs text-gray-500">Aktif %</p>
                <div class="w-8 h-8 bg-pink-50 rounded-lg flex items-center justify-center">
                    <i class="fas fa-chart-pie text-[#27124A] text-sm"></i>
                </div>
            </div>
            <p class="text-lg md:text-2xl font-bold text-gray-800">
                {{ $totalMember > 0 ? round(($memberAktif / $totalMember) * 100, 1) : 0 }}%
            </p>
            <div class="mt-2 flex items-center text-xs text-gray-500">
                <span class="text-pink-500 mr-1">📊</span> Persentase aktif
            </div>
        </div>
    </div>

    <!-- Filter Section - Menyatu dengan Card -->
    <div class="bg-white rounded-xl md:rounded-2xl shadow-sm border border-gray-100 overflow-hidden w-full">
        <!-- Header Filter -->
        <div class="p-3 md:p-4 border-b border-gray-100 bg-gray-50/50">
            <h3 class="text-sm md:text-base font-semibold text-gray-800 flex items-center">
                <i class="fas fa-filter mr-2 text-[#27124A]"></i>
                Filter Member
            </h3>
        </div>
        
        <!-- Form Filter -->
        <div class="p-3 md:p-4">
            <form method="GET" action="{{ route('owner.laporan.member') }}" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-2 md:gap-3">
                <div>
                    <label class="block text-xs md:text-sm font-medium text-gray-700 mb-1">Status</label>
                    <select name="status" class="w-full px-2 md:px-3 py-1.5 md:py-2 text-xs md:text-sm border border-gray-200 rounded-lg md:rounded-xl focus:outline-none focus:ring-2 focus:ring-[#27124A]/20 focus:border-[#27124A] transition-all">
                        <option value="active" {{ request('status', 'active') == 'active' ? 'selected' : '' }}>Member Aktif</option>
                        <option value="expired" {{ request('status') == 'expired' ? 'selected' : '' }}>Member Expired</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Member Pending</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs md:text-sm font-medium text-gray-700 mb-1">Paket</label>
                    <select name="package" class="w-full px-2 md:px-3 py-1.5 md:py-2 text-xs md:text-sm border border-gray-200 rounded-lg md:rounded-xl focus:outline-none focus:ring-2 focus:ring-[#27124A]/20 focus:border-[#27124A] transition-all">
                        <option value="">Semua Paket</option>
                        @foreach($packages ?? [] as $package)
                            <option value="{{ $package->id }}" {{ request('package') == $package->id ? 'selected' : '' }}>
                                {{ $package->nama_paket }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-xs md:text-sm font-medium text-gray-700 mb-1">Tgl Daftar Mulai</label>
                    <input type="date" name="start_date" value="{{ request('start_date') }}" 
                           class="w-full px-2 md:px-3 py-1.5 md:py-2 text-xs md:text-sm border border-gray-200 rounded-lg md:rounded-xl focus:outline-none focus:ring-2 focus:ring-[#27124A]/20 focus:border-[#27124A] transition-all">
                </div>
                <div>
                    <label class="block text-xs md:text-sm font-medium text-gray-700 mb-1">Tgl Daftar Akhir</label>
                    <input type="date" name="end_date" value="{{ request('end_date') }}" 
                           class="w-full px-2 md:px-3 py-1.5 md:py-2 text-xs md:text-sm border border-gray-200 rounded-lg md:rounded-xl focus:outline-none focus:ring-2 focus:ring-[#27124A]/20 focus:border-[#27124A] transition-all">
                </div>
                <div class="flex items-end gap-2">
                    <button type="submit"
                        class="flex-1 bg-[#27124A] hover:bg-[#3a1d6b] text-white text-xs md:text-sm font-medium py-1.5 md:py-2 px-2 rounded-lg md:rounded-xl transition-all duration-300 flex items-center justify-center">
                        <i class="fas fa-filter mr-1 text-xs"></i>
                        <span class="hidden sm:inline">Filter</span>
                    </button>
                    <a href="{{ route('owner.laporan.member') }}"
                        class="flex-1 bg-gray-200 hover:bg-gray-300 text-gray-800 text-xs md:text-sm font-medium py-1.5 md:py-2 px-2 rounded-lg md:rounded-xl transition-all duration-300 flex items-center justify-center">
                        <i class="fas fa-redo mr-1 text-xs"></i>
                        <span class="hidden sm:inline">Reset</span>
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Top Member Check-in & Statistik -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 md:gap-6">
        <!-- Top 10 Check-in Bulan Ini -->
        <div class="lg:col-span-1 bg-white rounded-xl md:rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="p-3 md:p-4 border-b border-gray-100 bg-gradient-to-r from-yellow-50 to-orange-50">
                <h3 class="text-sm md:text-base font-semibold text-gray-800 flex items-center">
                    <i class="fas fa-trophy text-yellow-500 mr-2"></i>
                    Top 10 Check-in Bulan Ini
                </h3>
                <p class="text-xs md:text-sm text-gray-500 mt-0.5">Member dengan aktivitas tertinggi</p>
            </div>
            
            <div class="divide-y divide-gray-100 max-h-96 overflow-y-auto">
                @forelse($topCheckins as $index => $member)
                <div class="p-3 md:p-4 hover:bg-gray-50 transition-colors duration-150">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 w-7 h-7 md:w-8 md:h-8 rounded-lg {{ $index < 3 ? 'bg-yellow-100' : 'bg-gray-100' }} flex items-center justify-center font-bold {{ $index < 3 ? 'text-yellow-600' : 'text-gray-600' }} text-xs md:text-sm">
                            {{ $index + 1 }}
                        </div>
                        <div class="ml-2 md:ml-3 flex-1 min-w-0">
                            <p class="text-xs md:text-sm font-semibold text-gray-800 truncate">{{ $member->nama }}</p>
                            <p class="text-xs text-gray-500 truncate">{{ $member->package->nama_paket ?? 'Tanpa Paket' }}</p>
                        </div>
                        <div class="text-right ml-2 flex-shrink-0">
                            <p class="text-sm md:text-base font-bold text-[#27124A]">{{ number_format($member->checkins_count, 0, ',', '.') }}</p>
                            <p class="text-xs text-gray-400">check-in</p>
                        </div>
                    </div>
                </div>
                @empty
                <div class="p-6 md:p-8 text-center">
                    <div class="inline-flex items-center justify-center w-12 h-12 md:w-14 md:h-14 bg-gray-100 rounded-full mb-3">
                        <i class="fas fa-trophy text-gray-400 text-lg md:text-xl"></i>
                    </div>
                    <p class="text-xs md:text-sm text-gray-400">Belum ada aktivitas check-in bulan ini</p>
                </div>
                @endforelse
            </div>
        </div>
        
        <!-- Statistik Member -->
        <div class="lg:col-span-2 bg-white rounded-xl md:rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="p-3 md:p-4 border-b border-gray-100">
                <h3 class="text-sm md:text-base font-semibold text-gray-800">Statistik Member</h3>
                <p class="text-xs md:text-sm text-gray-500 mt-0.5">Analisis aktivitas member</p>
            </div>
            
            <div class="p-3 md:p-4">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 md:gap-4">
                    <!-- Rata-rata Check-in -->
                    <div class="bg-gradient-to-br from-blue-50 to-indigo-50 rounded-lg md:rounded-xl p-4 md:p-5 border border-blue-100">
                        <div class="flex items-center justify-between mb-3">
                            <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                                <i class="fas fa-chart-line text-blue-600 text-sm md:text-base"></i>
                            </div>
                            <span class="text-xl md:text-2xl font-bold text-blue-600">
                                {{ $totalMember > 0 ? round($topCheckins->sum('checkins_count') / $totalMember, 1) : 0 }}
                            </span>
                        </div>
                        <h4 class="text-xs md:text-sm font-semibold text-gray-800">Rata-rata Check-in</h4>
                        <p class="text-xs text-gray-500 mt-0.5">Per member bulan ini</p>
                        <div class="mt-3 pt-3 border-t border-blue-200">
                            <div class="flex justify-between text-xs">
                                <span class="text-gray-600">Total Check-in</span>
                                <span class="font-bold text-blue-600">{{ number_format($topCheckins->sum('checkins_count'), 0, ',', '.') }}</span>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Member Aktif Check-in -->
                    <div class="bg-gradient-to-br from-green-50 to-emerald-50 rounded-lg md:rounded-xl p-4 md:p-5 border border-green-100">
                        <div class="flex items-center justify-between mb-3">
                            <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                                <i class="fas fa-users text-green-600 text-sm md:text-base"></i>
                            </div>
                            <span class="text-xl md:text-2xl font-bold text-green-600">{{ number_format($topCheckins->count(), 0, ',', '.') }}</span>
                        </div>
                        <h4 class="text-xs md:text-sm font-semibold text-gray-800">Member Aktif Check-in</h4>
                        <p class="text-xs text-gray-500 mt-0.5">Melakukan check-in bulan ini</p>
                        <div class="mt-3 pt-3 border-t border-green-200">
                            <div class="flex justify-between text-xs">
                                <span class="text-gray-600">Persentase</span>
                                <span class="font-bold text-green-600">
                                    {{ $totalMember > 0 ? round(($topCheckins->count() / $totalMember) * 100, 1) : 0 }}%
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Progress Bar Distribusi -->
                <div class="mt-4 md:mt-5">
                    <h4 class="text-xs md:text-sm font-semibold text-gray-800 mb-3">Distribusi Status Member</h4>
                    <div class="space-y-3">
                        <div>
                            <div class="flex justify-between text-xs mb-1">
                                <span class="text-gray-600">Aktif</span>
                                <span class="font-medium text-gray-800">{{ number_format($memberAktif, 0, ',', '.') }} member ({{ $totalMember > 0 ? round(($memberAktif / $totalMember) * 100, 1) : 0 }}%)</span>
                            </div>
                            <div class="w-full h-1.5 md:h-2 bg-gray-100 rounded-full overflow-hidden">
                                <div class="h-full bg-green-500 rounded-full" 
                                     style="width: {{ $totalMember > 0 ? ($memberAktif / $totalMember) * 100 : 0 }}%"></div>
                            </div>
                        </div>
                        <div>
                            <div class="flex justify-between text-xs mb-1">
                                <span class="text-gray-600">Akan Expired</span>
                                <span class="font-medium text-gray-800">{{ number_format($expiringSoon, 0, ',', '.') }} member ({{ $totalMember > 0 ? round(($expiringSoon / $totalMember) * 100, 1) : 0 }}%)</span>
                            </div>
                            <div class="w-full h-1.5 md:h-2 bg-gray-100 rounded-full overflow-hidden">
                                <div class="h-full bg-yellow-500 rounded-full" 
                                     style="width: {{ $totalMember > 0 ? ($expiringSoon / $totalMember) * 100 : 0 }}%"></div>
                            </div>
                        </div>
                        <div>
                            <div class="flex justify-between text-xs mb-1">
                                <span class="text-gray-600">Expired</span>
                                <span class="font-medium text-gray-800">{{ number_format($memberExpired, 0, ',', '.') }} member ({{ $totalMember > 0 ? round(($memberExpired / $totalMember) * 100, 1) : 0 }}%)</span>
                            </div>
                            <div class="w-full h-1.5 md:h-2 bg-gray-100 rounded-full overflow-hidden">
                                <div class="h-full bg-red-500 rounded-full" 
                                     style="width: {{ $totalMember > 0 ? ($memberExpired / $totalMember) * 100 : 0 }}%"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabel Member -->
    <div class="bg-white rounded-xl md:rounded-2xl shadow-sm border border-gray-100 overflow-hidden w-full">
        <!-- Header Tabel -->
        <div class="p-3 md:p-4 border-b border-gray-100">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3">
                <div>
                    <h3 class="text-sm md:text-base font-semibold text-gray-800">Daftar Member</h3>
                    <p class="text-xs md:text-sm text-gray-500 mt-0.5">Menampilkan {{ $members->firstItem() ?? 0 }} - {{ $members->lastItem() ?? 0 }} dari {{ number_format($members->total(), 0, ',', '.') }} member</p>
                </div>
            </div>
        </div>
        
        <!-- Table -->
        <div class="overflow-x-auto w-full">
            <table class="min-w-full divide-y divide-gray-100">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-3 md:px-4 py-2 md:py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama</th>
                        <th class="px-3 md:px-4 py-2 md:py-3 text-left text-xs font-medium text-gray-500 uppercase hidden md:table-cell">No. Telepon</th>
                        <th class="px-3 md:px-4 py-2 md:py-3 text-left text-xs font-medium text-gray-500 uppercase">Paket</th>
                        <th class="px-3 md:px-4 py-2 md:py-3 text-left text-xs font-medium text-gray-500 uppercase hidden lg:table-cell">Tgl Daftar</th>
                        <th class="px-3 md:px-4 py-2 md:py-3 text-left text-xs font-medium text-gray-500 uppercase">Tgl Expired</th>
                        <th class="px-3 md:px-4 py-2 md:py-3 text-left text-xs font-medium text-gray-500 uppercase hidden sm:table-cell">Sisa Hari</th>
                        <th class="px-3 md:px-4 py-2 md:py-3 text-left text-xs font-medium text-gray-500 uppercase hidden lg:table-cell">Check-in</th>
                        <th class="px-3 md:px-4 py-2 md:py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-100">
                    @forelse($members as $member)
                    @php
                        $sisaHari = $member->tgl_expired ? \Carbon\Carbon::now()->diffInDays(\Carbon\Carbon::parse($member->tgl_expired), false) : 0;
                    @endphp
                    <tr class="hover:bg-gray-50 transition-colors duration-150">
                        <td class="px-3 md:px-4 py-2 md:py-3 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="w-6 h-6 md:w-7 md:h-7 bg-purple-50 rounded-lg flex items-center justify-center mr-2 flex-shrink-0">
                                    <i class="fas fa-user text-[#27124A] text-xs"></i>
                                </div>
                                <span class="text-xs md:text-sm font-medium text-gray-800">{{ $member->nama }}</span>
                            </div>
                        </td>
                        <td class="px-3 md:px-4 py-2 md:py-3 whitespace-nowrap text-xs text-gray-600 hidden md:table-cell">
                            {{ $member->telepon ?? '-' }}
                        </td>
                        <td class="px-3 md:px-4 py-2 md:py-3 whitespace-nowrap">
                            @if($member->package)
                                <span class="px-2 py-1 bg-blue-50 text-blue-700 rounded-lg text-xs font-medium">
                                    {{ $member->package->nama_paket }}
                                </span>
                            @else
                                <span class="text-xs text-gray-400">-</span>
                            @endif
                        </td>
                        <td class="px-3 md:px-4 py-2 md:py-3 whitespace-nowrap hidden lg:table-cell">
                            @if($member->tgl_daftar)
                                <div class="flex items-center">
                                    <div class="w-6 h-6 bg-gray-50 rounded-lg flex items-center justify-center mr-1 flex-shrink-0">
                                        <i class="fas fa-calendar text-gray-400 text-xs"></i>
                                    </div>
                                    <span class="text-xs text-gray-700">{{ \Carbon\Carbon::parse($member->tgl_daftar)->format('d/m/Y') }}</span>
                                </div>
                            @else
                                <span class="text-xs text-gray-400">-</span>
                            @endif
                        </td>
                        <td class="px-3 md:px-4 py-2 md:py-3 whitespace-nowrap">
                            @if($member->tgl_expired)
                                <span class="text-xs text-gray-700">{{ \Carbon\Carbon::parse($member->tgl_expired)->format('d/m/Y') }}</span>
                            @else
                                <span class="text-xs text-gray-400">-</span>
                            @endif
                        </td>
                        <td class="px-3 md:px-4 py-2 md:py-3 whitespace-nowrap hidden sm:table-cell">
                            @if($sisaHari > 0)
                                <span class="px-2 py-1 bg-green-100 text-green-700 rounded-lg text-xs font-medium">
                                    {{ $sisaHari }} hari
                                </span>
                            @elseif($sisaHari == 0 && $member->tgl_expired)
                                <span class="px-2 py-1 bg-yellow-100 text-yellow-700 rounded-lg text-xs font-medium">
                                    Hari ini
                                </span>
                            @else
                                <span class="px-2 py-1 bg-red-100 text-red-700 rounded-lg text-xs font-medium">
                                    Expired
                                </span>
                            @endif
                        </td>
                        <td class="px-3 md:px-4 py-2 md:py-3 whitespace-nowrap hidden lg:table-cell">
                            <span class="px-2 py-1 bg-blue-50 text-[#27124A] rounded-lg text-xs font-bold">
                                {{ number_format($member->checkins_count, 0, ',', '.') }}
                            </span>
                        </td>
                        <td class="px-3 md:px-4 py-2 md:py-3 whitespace-nowrap">
                            @if($member->status == 'active' && $sisaHari > 0)
                                <span class="px-2 py-1 bg-green-100 text-green-700 rounded-lg text-xs flex items-center w-fit">
                                    <i class="fas fa-circle text-[6px] mr-1"></i> Aktif
                                </span>
                            @elseif($member->status == 'pending')
                                <span class="px-2 py-1 bg-yellow-100 text-yellow-700 rounded-lg text-xs flex items-center w-fit">
                                    <i class="fas fa-clock text-xs mr-1"></i> Pending
                                </span>
                            @else
                                <span class="px-2 py-1 bg-red-100 text-red-700 rounded-lg text-xs flex items-center w-fit">
                                    <i class="fas fa-circle text-[6px] mr-1"></i> Expired
                                </span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="px-4 py-8 text-center">
                            <div class="inline-flex items-center justify-center w-14 h-14 md:w-16 md:h-16 bg-purple-50 rounded-full mb-3">
                                <i class="fas fa-users text-xl md:text-2xl text-[#27124A]"></i>
                            </div>
                            <h4 class="text-sm md:text-base font-semibold text-gray-800 mb-1">Tidak Ada Data Member</h4>
                            <p class="text-xs md:text-sm text-gray-400">Belum ada member yang terdaftar dalam sistem</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        @if($members->hasPages())
        <div class="p-3 md:p-4 border-t border-gray-100">
            <div class="overflow-x-auto">
                {{ $members->withQueryString()->links() }}
            </div>
        </div>
        @endif
    </div>
</div>
@endsection