@extends('layouts.app')

@section('title', 'Kelola Member')
@section('page-title', 'Kelola Member')

@section('sidebar')
@include('admin.partials.sidebar')
@endsection

@section('content')
<!-- Stats Cards -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
    <!-- Total Member -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500 mb-1">Total Member</p>
                <p class="text-2xl font-bold text-gray-800">{{ $members->count() }}</p>
            </div>
            <div class="w-12 h-12 bg-purple-50 rounded-xl flex items-center justify-center">
                <i class="fas fa-users text-[#27124A] text-xl"></i>
            </div>
        </div>
        <div class="mt-4 flex items-center text-xs text-gray-500">
            <span class="text-purple-500 mr-1">👥</span> Total member terdaftar
        </div>
    </div>
    
    <!-- Member Aktif -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500 mb-1">Member Aktif</p>
                <p class="text-2xl font-bold text-gray-800">{{ $activeMembers }}</p>
            </div>
            <div class="w-12 h-12 bg-green-50 rounded-xl flex items-center justify-center">
                <i class="fas fa-user-check text-[#27124A] text-xl"></i>
            </div>
        </div>
        <div class="mt-4 flex items-center text-xs text-gray-500">
            <span class="text-green-500 mr-1">✅</span> Member dengan status aktif
        </div>
    </div>
    
    <!-- Member Expired -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500 mb-1">Member Expired</p>
                <p class="text-2xl font-bold text-gray-800">{{ $expiredMembers }}</p>
            </div>
            <div class="w-12 h-12 bg-red-50 rounded-xl flex items-center justify-center">
                <i class="fas fa-user-times text-[#27124A] text-xl"></i>
            </div>
        </div>
        <div class="mt-4 flex items-center text-xs text-gray-500">
            <span class="text-red-500 mr-1">⏰</span> Member melewati masa aktif
        </div>
    </div>
    
    <!-- Akan Expired -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500 mb-1">Akan Expired</p>
                <p class="text-2xl font-bold text-gray-800">{{ $expiringSoon }}</p>
            </div>
            <div class="w-12 h-12 bg-yellow-50 rounded-xl flex items-center justify-center">
                <i class="fas fa-clock text-[#27124A] text-xl"></i>
            </div>
        </div>
        <div class="mt-4 flex items-center text-xs text-gray-500">
            <span class="text-yellow-500 mr-1">⚠️</span> ≤ 7 hari lagi expired
        </div>
    </div>
</div>

<!-- Messages -->
@if(session('success'))
<div class="mb-6 bg-green-50 border border-green-200 rounded-xl p-4">
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
<div class="mb-6 bg-red-50 border border-red-200 rounded-xl p-4">
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

<!-- Filter Tabs -->
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden mb-6">
    <div class="border-b border-gray-100">
        <div class="flex flex-wrap -mb-px px-6">
            <a href="?filter=all" 
               class="py-4 px-5 text-sm font-medium border-b-2 {{ request('filter', 'all') == 'all' ? 'border-[#27124A] text-[#27124A]' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-200' }} transition-colors duration-300 whitespace-normal break-words">
                <i class="fas fa-list mr-2"></i>Semua ({{ $members->count() }})
            </a>
            <a href="?filter=active" 
               class="py-4 px-5 text-sm font-medium border-b-2 {{ request('filter') == 'active' ? 'border-green-500 text-green-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-200' }} transition-colors duration-300 whitespace-normal break-words">
                <i class="fas fa-check-circle mr-2"></i>Aktif ({{ $activeMembers }})
            </a>
            <a href="?filter=expired" 
               class="py-4 px-5 text-sm font-medium border-b-2 {{ request('filter') == 'expired' ? 'border-red-500 text-red-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-200' }} transition-colors duration-300 whitespace-normal break-words">
                <i class="fas fa-times-circle mr-2"></i>Expired ({{ $expiredMembers }})
            </a>
        </div>
    </div>
</div>

<!-- Main Content -->
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden mb-8">
    <!-- Header -->
    <div class="p-6 border-b border-gray-100">
        <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-4">
            <div>
                <h3 class="text-lg font-semibold text-gray-800">Daftar Member</h3>
                <p class="text-sm text-gray-500 mt-1">Admin hanya dapat mengedit, menonaktifkan, dan menghapus member</p>
            </div>
        </div>
    </div>
    
    <!-- Table -->
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-100">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-16">No</th>
                    <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kode & Nama</th>
                    <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Paket</th>
                    <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Periode</th>
                    <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Sisa Hari</th>
                    <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-100">
                @php
                    $filteredMembers = $members;
                    if (request('filter') == 'active') {
                        $filteredMembers = $members->filter(function($member) {
                            return $member->is_active;
                        });
                    } elseif (request('filter') == 'expired') {
                        $filteredMembers = $members->filter(function($member) {
                            return !$member->is_active;
                        });
                    }
                    
                    // Urutkan: yang akan expired (sisa hari 1-7) di atas, lalu aktif biasa, lalu expired
                    $filteredMembers = $filteredMembers->sortByDesc(function($member) {
                        if ($member->is_active) {
                            if ($member->sisa_hari >= 1 && $member->sisa_hari <= 7) {
                                return 3; // Prioritas tertinggi untuk yang akan expired
                            } else {
                                return 2; // Prioritas menengah untuk aktif biasa
                            }
                        }
                        return 1; // Prioritas terendah untuk expired
                    });
                @endphp
                
                @forelse($filteredMembers as $member)
                @php
                    $isActive = $member->is_active;
                    $sisaHari = $member->sisa_hari;
                    $sisaHariText = $member->sisa_hari_text;
                    $sisaHariClass = $member->sisa_hari_class;
                @endphp
                <tr class="hover:bg-gray-50 transition-colors duration-150">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center justify-center w-8 h-8 bg-gray-100 rounded-lg text-gray-600 font-medium text-sm">
                            {{ $loop->iteration }}
                        </div>
                    </td>
                    
                    <td class="px-6 py-4 whitespace-normal break-words">
                        <div class="flex items-start">
                            <div class="flex-shrink-0 w-10 h-10 {{ $isActive ? 'bg-green-100' : 'bg-red-100' }} rounded-xl flex items-center justify-center mr-3">
                                <i class="fas fa-user text-[#27124A]"></i>
                            </div>
                            <div class="min-w-0 flex-1">
                                <div class="flex items-center flex-wrap gap-2 mb-1">
                                    <span class="font-mono font-medium text-[#27124A] bg-[#27124A]/10 px-2 py-0.5 rounded text-xs break-words">{{ $member->kode_member }}</span>
                                    @if($member->jenis_member)
                                    <span class="px-2 py-0.5 text-xs rounded-full bg-purple-50 text-purple-700 border border-purple-200 break-words">
                                        {{ $member->jenis_member }}
                                    </span>
                                    @endif
                                </div>
                                <div class="font-medium text-gray-800 break-words">{{ $member->nama }}</div>
                                @if($member->telepon)
                                <div class="text-xs text-gray-500 mt-1 break-words">
                                    <i class="fas fa-phone mr-1 flex-shrink-0"></i> <span class="break-words">{{ $member->telepon }}</span>
                                </div>
                                @endif
                            </div>
                        </div>
                    </td>
                    
                    <td class="px-6 py-4 whitespace-normal break-words">
                        <div class="bg-blue-50 border border-blue-100 rounded-xl p-3 min-w-0">
                            <div class="font-medium text-[#27124A] break-words">{{ $member->package->nama_paket ?? '-' }}</div>
                            <div class="text-xs text-gray-500 mt-1 break-words">
                                <i class="fas fa-clock mr-1 flex-shrink-0"></i> <span class="break-words">{{ $member->package->durasi_hari ?? '-' }} hari</span>
                            </div>
                        </div>
                    </td>
                    
                    <td class="px-6 py-4 whitespace-normal break-words">
                        <div class="flex flex-col min-w-0">
                            <div class="text-xs text-gray-400">Daftar</div>
                            <div class="text-sm font-medium text-gray-700 mb-2 break-words">{{ $member->tgl_daftar_formatted }}</div>
                            <div class="text-xs text-gray-400">Expired</div>
                            <div class="text-sm font-medium {{ $sisaHari < 0 ? 'text-red-600' : 'text-green-600' }} break-words">
                                {{ $member->tgl_expired_formatted }}
                            </div>
                        </div>
                    </td>
                    
                    <td class="px-6 py-4 whitespace-normal break-words">
                        <span class="px-3 py-1.5 rounded-lg text-sm font-medium {{ $sisaHariClass }} inline-flex items-center border">
                            <i class="fas fa-calendar-day mr-1 flex-shrink-0"></i> 
                            <span class="break-words">{{ $sisaHariText }}</span>
                        </span>
                    </td>
                    
                    <td class="px-6 py-4 whitespace-normal break-words">
                        <form action="{{ route('admin.members.toggleStatus', $member->id) }}" method="POST" class="inline">
                            @csrf
                            @method('PUT')
                            <button type="submit" 
                                    class="px-3 py-1.5 rounded-lg text-sm font-medium transition-all duration-300 
                                    {{ $isActive ? 
                                       'bg-green-100 text-green-700 border border-green-200 hover:bg-green-200' : 
                                       'bg-red-100 text-red-700 border border-red-200 hover:bg-red-200' }}"
                                    onclick="return confirm('Yakin ingin {{ $isActive ? 'nonaktifkan' : 'aktifkan' }} member {{ $member->nama }}?')">
                                <i class="fas {{ $isActive ? 'fa-toggle-on' : 'fa-toggle-off' }} mr-1"></i>
                                {{ $isActive ? 'Aktif' : ($member->sisa_hari < 0 ? 'Expired' : 'Nonaktif') }}
                            </button>
                        </form>
                    </td>
                    
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center space-x-2">
                            <!-- Edit Button -->
                            <a href="{{ route('admin.members.edit', $member->id) }}" 
                               class="p-2 bg-blue-50 hover:bg-blue-100 text-blue-600 rounded-lg transition-all duration-300 border border-blue-100 flex-shrink-0"
                               title="Edit Member">
                                <i class="fas fa-edit text-sm"></i>
                            </a>
                            
                            <!-- Delete Button -->
                            <form action="{{ route('admin.members.destroy', $member->id) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        class="p-2 bg-red-50 hover:bg-red-100 text-red-600 rounded-lg transition-all duration-300 border border-red-100 flex-shrink-0"
                                        onclick="return confirm('Yakin ingin menghapus member {{ $member->nama }}? Data yang dihapus tidak dapat dikembalikan.')"
                                        title="Hapus Member">
                                    <i class="fas fa-trash text-sm"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-6 py-12 text-center">
                        <div class="inline-flex items-center justify-center w-20 h-20 bg-purple-50 rounded-full mb-4">
                            <i class="fas fa-user-friends text-3xl text-[#27124A]"></i>
                        </div>
                        <h4 class="text-lg font-semibold text-gray-800 mb-2">Tidak ada data member</h4>
                        <p class="text-sm text-gray-400">
                            @if(request('filter') == 'active')
                                Belum ada member dengan status aktif
                            @elseif(request('filter') == 'expired')
                                Belum ada member dengan status expired
                            @else
                                Belum ada member yang terdaftar
                            @endif
                        </p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Information Card -->
<div class="bg-gradient-to-r from-purple-50 to-pink-50 border border-purple-100 rounded-2xl shadow-sm p-6 mb-8">
    <div class="flex items-start">
        <div class="flex-shrink-0 w-12 h-12 bg-[#27124A] rounded-xl flex items-center justify-center shadow-sm">
            <i class="fas fa-info-circle text-white text-xl"></i>
        </div>
        <div class="ml-5 flex-1 min-w-0">
            <h3 class="text-base font-semibold text-gray-800 mb-3 break-words">Informasi untuk Admin</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="flex items-start">
                    <div class="flex-shrink-0 w-6 h-6 bg-[#27124A]/10 rounded-full flex items-center justify-center mr-3">
                        <i class="fas fa-ban text-[#27124A] text-xs"></i>
                    </div>
                    <div class="min-w-0 flex-1">
                        <h4 class="font-medium text-gray-800 mb-1 break-words">Pendaftaran Baru</h4>
                        <p class="text-xs text-gray-600 break-words">Admin <strong>tidak dapat mendaftarkan member baru</strong>. Silakan hubungi kasir.</p>
                    </div>
                </div>
                <div class="flex items-start">
                    <div class="flex-shrink-0 w-6 h-6 bg-[#27124A]/10 rounded-full flex items-center justify-center mr-3">
                        <i class="fas fa-edit text-[#27124A] text-xs"></i>
                    </div>
                    <div class="min-w-0 flex-1">
                        <h4 class="font-medium text-gray-800 mb-1 break-words">Edit Data</h4>
                        <p class="text-xs text-gray-600 break-words">Admin dapat mengedit data member, mengubah paket, dan memperbaiki tanggal expired.</p>
                    </div>
                </div>
                <div class="flex items-start">
                    <div class="flex-shrink-0 w-6 h-6 bg-[#27124A]/10 rounded-full flex items-center justify-center mr-3">
                        <i class="fas fa-sync-alt text-[#27124A] text-xs"></i>
                    </div>
                    <div class="min-w-0 flex-1">
                        <h4 class="font-medium text-gray-800 mb-1 break-words">Manajemen Status</h4>
                        <p class="text-xs text-gray-600 break-words">Admin dapat mengaktifkan/nonaktifkan member dan menghapus data member.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Member yang akan expired -->
@php
    $expiringSoonList = $members->filter(function($member) {
        return $member->is_active && $member->sisa_hari >= 0 && $member->sisa_hari <= 7;
    })->sortBy('tgl_expired');
@endphp

@if($expiringSoonList->count() > 0)
<div class="bg-gradient-to-r from-yellow-50 to-amber-50 border border-yellow-200 rounded-2xl shadow-sm overflow-hidden">
    <div class="p-5 border-b border-yellow-200">
        <div class="flex items-center justify-between">
            <div class="flex items-center min-w-0 flex-1">
                <div class="w-10 h-10 bg-yellow-500 rounded-xl flex items-center justify-center mr-4 flex-shrink-0">
                    <i class="fas fa-exclamation-triangle text-white"></i>
                </div>
                <div class="min-w-0 flex-1">
                    <h3 class="text-base font-semibold text-yellow-800 break-words">Member Akan Expired (≤7 hari)</h3>
                    <p class="text-xs text-yellow-700 break-words">Segera perpanjang membership untuk member berikut (hubungi kasir untuk perpanjangan)</p>
                </div>
            </div>
            <span class="px-4 py-2 bg-yellow-100 text-yellow-700 rounded-xl text-sm font-medium flex-shrink-0 ml-4">
                {{ $expiringSoonList->count() }} Member
            </span>
        </div>
    </div>
    
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-yellow-200">
            <thead class="bg-yellow-100/50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-yellow-800 uppercase tracking-wider">Kode Member</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-yellow-800 uppercase tracking-wider">Nama</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-yellow-800 uppercase tracking-wider">Expired</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-yellow-800 uppercase tracking-wider">Sisa Hari</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-yellow-800 uppercase tracking-wider">Paket</th>
                </tr>
            </thead>
            <tbody class="bg-yellow-50/30 divide-y divide-yellow-200">
                @foreach($expiringSoonList as $member)
                <tr class="hover:bg-yellow-100/50 transition-colors duration-150">
                    <td class="px-6 py-3 whitespace-normal break-words">
                        <span class="font-mono font-medium text-yellow-700 break-words">{{ $member->kode_member }}</span>
                    </td>
                    <td class="px-6 py-3 whitespace-normal break-words">
                        <div class="min-w-0">
                            <div class="font-medium text-yellow-900 break-words">{{ $member->nama }}</div>
                            @if($member->telepon)
                            <div class="text-xs text-yellow-600 break-words">{{ $member->telepon }}</div>
                            @endif
                        </div>
                    </td>
                    <td class="px-6 py-3 whitespace-normal break-words">
                        <div class="font-medium text-red-600 break-words">{{ $member->tgl_expired_formatted }}</div>
                    </td>
                    <td class="px-6 py-3 whitespace-normal break-words">
                        <span class="px-3 py-1 rounded-lg {{ $member->sisa_hari_class }} font-medium text-sm inline-block border break-words">
                            {{ $member->sisa_hari_text }}
                        </span>
                    </td>
                    <td class="px-6 py-3 whitespace-normal break-words">
                        <div class="text-sm text-yellow-700 break-words">{{ $member->package->nama_paket ?? '-' }}</div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endif
@endsection

@push('styles')
<style>
    /* Custom scrollbar for table */
    .overflow-x-auto {
        scrollbar-width: thin;
        scrollbar-color: #27124A #e5e7eb;
    }
    
    .overflow-x-auto::-webkit-scrollbar {
        height: 6px;
    }
    
    .overflow-x-auto::-webkit-scrollbar-track {
        background: #e5e7eb;
        border-radius: 3px;
    }
    
    .overflow-x-auto::-webkit-scrollbar-thumb {
        background-color: #422b66;
        border-radius: 3px;
    }
    
    /* Smooth transitions */
    table tbody tr {
        transition: all 0.2s ease;
    }
    
    /* Button animations */
    button:disabled {
        opacity: 0.5;
        cursor: not-allowed;
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
    
    /* Button transitions */
    button, a {
        transition: all 0.2s ease;
    }
    
    /* Animation for active status dot */
    .animate-pulse {
        animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
    }
    
    @keyframes pulse {
        0%, 100% {
            opacity: 1;
        }
        50% {
            opacity: .5;
        }
    }
</style>
@endpush