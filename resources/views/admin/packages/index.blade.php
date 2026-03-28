@extends('layouts.app')

@section('title', 'Kelola Paket Membership')
@section('page-title', 'Kelola Paket Membership')

@section('sidebar')
@include('admin.partials.sidebar')
@endsection

@section('content')
<!-- Stats Cards - Updated with dashboard style -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
    <!-- Total Paket -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500 mb-1">Total Paket</p>
                <p class="text-2xl font-bold text-gray-800">{{ $packages->count() }}</p>
            </div>
            <div class="w-12 h-12 bg-purple-50 rounded-xl flex items-center justify-center">
                <i class="fas fa-boxes text-[#27124A] text-xl"></i>
            </div>
        </div>
        <div class="mt-4 flex items-center text-xs text-gray-500">
            <span class="text-green-500 mr-1">↑</span> Total paket tersedia
        </div>
    </div>
    
    <!-- Paket Aktif -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500 mb-1">Paket Aktif</p>
                <p class="text-2xl font-bold text-gray-800">{{ $packages->where('status', true)->count() }}</p>
            </div>
            <div class="w-12 h-12 bg-green-50 rounded-xl flex items-center justify-center">
                <i class="fas fa-check-circle text-[#27124A] text-xl"></i>
            </div>
        </div>
        <div class="mt-4 flex items-center text-xs text-gray-500">
            <span class="text-green-500 mr-1">✅</span> Paket yang sedang aktif
        </div>
    </div>
    
    <!-- Total Member -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500 mb-1">Total Member</p>
                <p class="text-2xl font-bold text-gray-800">{{ $packages->sum(function($package) { return $package->members->count(); }) }}</p>
            </div>
            <div class="w-12 h-12 bg-pink-50 rounded-xl flex items-center justify-center">
                <i class="fas fa-users text-[#27124A] text-xl"></i>
            </div>
        </div>
        <div class="mt-4 flex items-center text-xs text-gray-500">
            <span class="text-blue-500 mr-1">👥</span> Total member terdaftar
        </div>
    </div>
    
    <!-- Member Aktif -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500 mb-1">Member Aktif</p>
                <p class="text-2xl font-bold text-gray-800">{{ $packages->sum(function($package) { return $package->members->where('status', 'active')->count(); }) }}</p>
            </div>
            <div class="w-12 h-12 bg-blue-50 rounded-xl flex items-center justify-center">
                <i class="fas fa-user-check text-[#27124A] text-xl"></i>
            </div>
        </div>
        <div class="mt-4 flex items-center text-xs text-gray-500">
            <span class="text-green-500 mr-1">⭐</span> Member dengan status aktif
        </div>
    </div>
</div>

<!-- Main Content -->
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden mb-8">
    <!-- Header -->
    <div class="p-6 border-b border-gray-100">
        <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-4">
            <div>
                <h3 class="text-lg font-semibold text-gray-800">Daftar Paket Membership</h3>
                <p class="text-sm text-gray-500 mt-1">Kelola paket membership untuk pendaftaran member baru</p>
            </div>
            <a href="{{ route('admin.packages.create') }}" 
               class="px-5 py-2.5 bg-[#27124A] hover:bg-[#3a1d6b] text-white font-medium rounded-xl transition-all duration-300 flex items-center shadow-sm hover:shadow-md">
                <i class="fas fa-plus mr-2"></i> Tambah Paket
            </a>
        </div>
    </div>
    
    @if(session('success'))
    <div class="mx-6 mt-6 bg-green-50 border border-green-200 rounded-xl p-4">
        <div class="flex items-center">
            <div class="flex-shrink-0">
                <i class="fas fa-check-circle text-green-500 text-xl"></i>
            </div>
            <div class="ml-3">
                <p class="text-green-700 font-medium">{{ session('success') }}</p>
            </div>
        </div>
    </div>
    @endif
    
    @if(session('error'))
    <div class="mx-6 mt-6 bg-red-50 border border-red-200 rounded-xl p-4">
        <div class="flex items-center">
            <div class="flex-shrink-0">
                <i class="fas fa-exclamation-circle text-red-500 text-xl"></i>
            </div>
            <div class="ml-3">
                <p class="text-red-700 font-medium">{{ session('error') }}</p>
            </div>
        </div>
    </div>
    @endif
    
    <!-- Table -->
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-100">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-16">No</th>
                    <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Paket</th>
                    <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Durasi</th>
                    <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Harga</th>
                    <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Member Aktif</th>
                    <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-100">
                @foreach($packages as $package)
                <tr class="hover:bg-gray-50 transition-colors duration-150">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center justify-center w-8 h-8 bg-gray-100 rounded-lg text-gray-600 font-medium text-sm">
                            {{ $loop->iteration }}
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-normal break-words">
                        <div class="flex items-start">
                            <div class="flex-shrink-0 w-10 h-10 bg-[#27124A]/10 rounded-xl flex items-center justify-center mr-3">
                                <i class="fas fa-gift text-[#27124A]"></i>
                            </div>
                            <div class="min-w-0 flex-1">
                                <h4 class="font-medium text-gray-800 break-words">{{ $package->nama_paket }}</h4>
                                <span class="text-xs text-gray-400 break-words">ID: {{ $package->id }}</span>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-normal break-words">
                        <div class="flex items-start">
                            <div class="w-8 h-8 bg-blue-50 rounded-lg flex items-center justify-center mr-2 flex-shrink-0">
                                <i class="fas fa-calendar-alt text-[#27124A] text-sm"></i>
                            </div>
                            <div class="min-w-0 flex-1">
                                <div class="text-sm font-medium text-gray-700 break-words">{{ $package->durasi_hari }} hari</div>
                                <div class="text-xs text-gray-400 break-words">{{ $package->durasi_formatted }}</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-normal break-words">
                        <div class="bg-green-50 border border-green-100 rounded-xl p-3 min-w-0">
                            <div class="font-bold text-[#27124A] break-words">{{ $package->harga_formatted }}</div>
                            @if($package->durasi_hari > 0)
                                <div class="text-xs text-gray-500 mt-1 break-words">
                                    Rp {{ number_format($package->harga_per_hari, 0, ',', '.') }}/hari
                                </div>
                            @endif
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-normal break-words">
                        <form action="{{ route('admin.packages.toggleStatus', $package->id) }}" method="POST" class="inline">
                            @csrf
                            @method('PUT')
                            <button type="submit" 
                                    class="px-3 py-1.5 rounded-lg text-sm font-medium transition-all duration-300 
                                    {{ $package->status ? 
                                       'bg-green-100 text-green-700 border border-green-200 hover:bg-green-200' : 
                                       'bg-red-100 text-red-700 border border-red-200 hover:bg-red-200' }}">
                                <i class="fas {{ $package->status ? 'fa-toggle-on' : 'fa-toggle-off' }} mr-1"></i>
                                {{ $package->status ? 'Aktif' : 'Nonaktif' }}
                            </button>
                        </form>
                    </td>
                    <td class="px-6 py-4 whitespace-normal break-words">
                        <div class="flex items-start">
                            <div class="w-8 h-8 bg-purple-50 rounded-lg flex items-center justify-center mr-2 flex-shrink-0">
                                <i class="fas fa-users text-[#27124A] text-sm"></i>
                            </div>
                            <div class="min-w-0 flex-1">
                                <div class="text-sm font-medium text-gray-700 break-words">
                                    {{ $package->members->where('status', 'active')->count() }} aktif
                                </div>
                                <div class="text-xs text-gray-400 break-words">
                                    Total: {{ $package->members->count() }}
                                </div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center space-x-2">
                            <a href="{{ route('admin.packages.edit', $package->id) }}" 
                               class="p-2 bg-blue-50 hover:bg-blue-100 text-blue-600 rounded-lg transition-all duration-300 border border-blue-100 flex-shrink-0"
                               title="Edit Paket">
                                <i class="fas fa-edit text-sm"></i>
                            </a>
                            
                            <form action="{{ route('admin.packages.destroy', $package->id) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        class="p-2 bg-red-50 hover:bg-red-100 text-red-600 rounded-lg transition-all duration-300 border border-red-100 flex-shrink-0"
                                        onclick="return confirm('Yakin ingin menghapus paket ini? {{ $package->members->count() > 0 ? "Paket ini digunakan oleh " . $package->members->count() . " member." : "" }}')"
                                        title="Hapus Paket">
                                    <i class="fas fa-trash text-sm"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    
    @if($packages->isEmpty())
    <div class="p-12 text-center">
        <div class="inline-flex items-center justify-center w-20 h-20 bg-purple-50 rounded-full mb-4">
            <i class="fas fa-id-card text-3xl text-[#27124A]"></i>
        </div>
        <h4 class="text-lg font-semibold text-gray-800 mb-2">Belum Ada Paket Membership</h4>
        <p class="text-gray-400 text-sm mb-6">Mulai dengan membuat paket pertama untuk member gym</p>
        <a href="{{ route('admin.packages.create') }}" 
           class="inline-flex items-center px-5 py-2.5 bg-[#27124A] hover:bg-[#3a1d6b] text-white font-medium rounded-xl transition-all duration-300 shadow-sm hover:shadow-md">
            <i class="fas fa-plus mr-2"></i> Tambah Paket Pertama
        </a>
    </div>
    @endif
</div>

<!-- Perbandingan Harga -->
@if($packages->count() > 1)
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="p-6 border-b border-gray-100">
        <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-4">
            <div>
                <h3 class="text-lg font-semibold text-gray-800">Perbandingan Harga per Hari</h3>
                <p class="text-sm text-gray-500 mt-1">Analisis nilai terbaik untuk member berdasarkan harga per hari</p>
            </div>
            <div class="flex items-center">
                <div class="w-3 h-3 bg-[#27124A] rounded-full mr-2"></div>
                <span class="text-xs text-gray-500">Terbaik</span>
                <div class="w-3 h-3 bg-gray-200 rounded-full mx-3"></div>
                <span class="text-xs text-gray-500">Lainnya</span>
            </div>
        </div>
    </div>
    
    <div class="p-6">
        <div class="overflow-x-auto">
            <table class="min-w-full">
                <thead>
                    <tr class="text-left text-xs text-gray-400 uppercase">
                        <th class="pb-4 font-medium">Peringkat</th>
                        <th class="pb-4 font-medium">Paket</th>
                        <th class="pb-4 font-medium">Harga Total</th>
                        <th class="pb-4 font-medium">Durasi</th>
                        <th class="pb-4 font-medium">Harga/Hari</th>
                        <th class="pb-4 font-medium">Nilai</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $sortedPackages = $packages->sortBy('harga_per_hari');
                    @endphp
                    @foreach($sortedPackages as $package)
                    <tr class="border-t border-gray-100 hover:bg-gray-50 transition-colors duration-150">
                        <td class="py-4 whitespace-nowrap">
                            <div class="flex items-center justify-center w-8 h-8 rounded-lg {{ $loop->first ? 'bg-[#27124A]' : 'bg-gray-100' }} text-white font-bold text-sm">
                                {{ $loop->iteration }}
                            </div>
                        </td>
                        <td class="py-4 whitespace-normal break-words">
                            <div class="font-medium text-gray-800 break-words">{{ $package->nama_paket }}</div>
                        </td>
                        <td class="py-4 whitespace-normal break-words">
                            <div class="font-semibold text-gray-700 break-words">{{ $package->harga_formatted }}</div>
                        </td>
                        <td class="py-4 whitespace-normal break-words">
                            <div class="text-gray-600 text-sm break-words">{{ $package->durasi_formatted }}</div>
                        </td>
                        <td class="py-4 whitespace-normal break-words">
                            <div class="font-bold text-[#27124A] break-words">Rp {{ number_format($package->harga_per_hari, 0, ',', '.') }}</div>
                        </td>
                        <td class="py-4 whitespace-normal break-words">
                            @if($loop->first)
                                <div class="inline-flex items-center px-3 py-1.5 bg-[#27124A]/10 text-[#27124A] rounded-lg font-medium text-sm border border-[#27124A]/20">
                                    <i class="fas fa-crown mr-2"></i> Terbaik
                                </div>
                            @else
                                <div class="inline-flex items-center px-3 py-1.5 bg-gray-100 text-gray-600 rounded-lg text-sm">
                                    #{{ $loop->iteration }} terbaik
                                </div>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    
    <!-- Summary -->
    <div class="p-6 border-t border-gray-100 bg-gradient-to-r from-purple-50 to-pink-50">
        <h4 class="font-semibold text-gray-800 mb-4">Kesimpulan</h4>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="bg-white p-4 rounded-xl border border-purple-100">
                <div class="flex items-center">
                    <div class="w-10 h-10 bg-[#27124A]/10 rounded-lg flex items-center justify-center mr-3 flex-shrink-0">
                        <i class="fas fa-crown text-[#27124A]"></i>
                    </div>
                    <div class="min-w-0 flex-1">
                        <div class="text-xs text-gray-500 break-words">Paket Terbaik</div>
                        <div class="font-semibold text-gray-800 break-words">{{ $sortedPackages->first()->nama_paket }}</div>
                    </div>
                </div>
            </div>
            
            <div class="bg-white p-4 rounded-xl border border-purple-100">
                <div class="flex items-center">
                    <div class="w-10 h-10 bg-[#27124A]/10 rounded-lg flex items-center justify-center mr-3 flex-shrink-0">
                        <i class="fas fa-money-bill-wave text-[#27124A]"></i>
                    </div>
                    <div class="min-w-0 flex-1">
                        <div class="text-xs text-gray-500 break-words">Harga/Hari Terbaik</div>
                        <div class="font-semibold text-gray-800 break-words">Rp {{ number_format($sortedPackages->first()->harga_per_hari, 0, ',', '.') }}/hari</div>
                    </div>
                </div>
            </div>
            
            <div class="bg-white p-4 rounded-xl border border-purple-100">
                <div class="flex items-center">
                    <div class="w-10 h-10 bg-[#27124A]/10 rounded-lg flex items-center justify-center mr-3 flex-shrink-0">
                        <i class="fas fa-percentage text-[#27124A]"></i>
                    </div>
                    <div class="min-w-0 flex-1">
                        <div class="text-xs text-gray-500 break-words">Penghematan</div>
                        @if($sortedPackages->count() > 1)
                            @php
                                $worst = $sortedPackages->last()->harga_per_hari;
                                $best = $sortedPackages->first()->harga_per_hari;
                                $saving = (($worst - $best) / $worst) * 100;
                            @endphp
                            <div class="font-semibold text-green-600 break-words">{{ number_format($saving, 1) }}% lebih murah</div>
                        @else
                            <div class="font-semibold text-gray-800 break-words">-</div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endif
@endsection

@push('styles')
<style>
    /* Custom scrollbar for table */
    .overflow-x-auto {
        scrollbar-width: thin;
        scrollbar-color: #cbd5e1 #f1f5f9;
    }
    
    .overflow-x-auto::-webkit-scrollbar {
        height: 6px;
    }
    
    .overflow-x-auto::-webkit-scrollbar-track {
        background: #f1f5f9;
        border-radius: 3px;
    }
    
    .overflow-x-auto::-webkit-scrollbar-thumb {
        background-color: #cbd5e1;
        border-radius: 3px;
    }
    
    /* Smooth transitions */
    table tbody tr {
        transition: all 0.2s ease;
    }
    
    /* Word break utilities */
    .break-words {
        word-break: break-word;
        overflow-wrap: break-word;
        hyphens: auto;
    }
    
    td {
        max-width: 300px;
    }
</style>
@endpush