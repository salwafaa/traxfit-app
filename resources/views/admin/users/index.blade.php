@extends('layouts.app')

@section('title', 'Kelola User')
@section('page-title', 'Kelola User')

@section('sidebar')
@include('admin.partials.sidebar')
@endsection

@section('content')
<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition-all duration-300">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500 mb-1">Total User</p>
                <p class="text-2xl font-bold text-gray-800">{{ $users->count() }}</p>
            </div>
            <div class="w-12 h-12 bg-purple-50 rounded-xl flex items-center justify-center">
                <i class="fas fa-users text-[#27124A] text-xl"></i>
            </div>
        </div>
        <div class="mt-4 flex items-center text-xs text-gray-500">
            <span class="text-purple-500 mr-1">👥</span> Semua user dalam sistem
        </div>
    </div>
    
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition-all duration-300">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500 mb-1">User Aktif</p>
                <p class="text-2xl font-bold text-gray-800">{{ $users->where('status', true)->count() }}</p>
            </div>
            <div class="w-12 h-12 bg-green-50 rounded-xl flex items-center justify-center">
                <i class="fas fa-check-circle text-[#27124A] text-xl"></i>
            </div>
        </div>
        <div class="mt-4 flex items-center text-xs text-gray-500">
            <span class="text-green-500 mr-1">✅</span> User dengan akses aktif
        </div>
    </div>
    
    @if(auth()->user()->role == 'owner')
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition-all duration-300">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500 mb-1">Total Admin</p>
                <p class="text-2xl font-bold text-gray-800">{{ $users->where('role', 'admin')->count() }}</p>
            </div>
            <div class="w-12 h-12 bg-blue-50 rounded-xl flex items-center justify-center">
                <i class="fas fa-user-shield text-[#27124A] text-xl"></i>
            </div>
        </div>
        <div class="mt-4 flex items-center text-xs text-gray-500">
            <span class="text-blue-500 mr-1">🛡️</span> Administrator sistem
        </div>
    </div>
    @endif
    
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition-all duration-300">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500 mb-1">Total Kasir</p>
                <p class="text-2xl font-bold text-gray-800">{{ $users->where('role', 'kasir')->count() }}</p>
            </div>
            <div class="w-12 h-12 bg-pink-50 rounded-xl flex items-center justify-center">
                <i class="fas fa-cash-register text-[#27124A] text-xl"></i>
            </div>
        </div>
        <div class="mt-4 flex items-center text-xs text-gray-500">
            <span class="text-pink-500 mr-1">💳</span> Petugas kasir
        </div>
    </div>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden mb-8">
    <div class="p-6 border-b border-gray-100">
        <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-4">
            <div>
                <h3 class="text-lg font-semibold text-gray-800">Daftar User Sistem</h3>
                <p class="text-sm text-gray-500 mt-1">
                    @if(auth()->user()->role == 'admin')
                        Kelola user dengan role Kasir
                    @else
                        Kelola user dengan akses ke sistem TraxFit
                    @endif
                </p>
            </div>
            <div class="flex flex-wrap gap-3">
                <a href="{{ route('admin.users.create') }}" 
                   class="px-4 py-2.5 bg-[#27124A] hover:bg-[#3a1d6b] text-white font-medium rounded-xl transition-all duration-300 flex items-center shadow-sm hover:shadow-md">
                    <i class="fas fa-plus mr-2"></i> Tambah User
                </a>
            </div>
        </div>
    </div>
    
    @if(session('success'))
    <div class="mx-6 mt-6 mb-4 bg-green-50 border-l-4 border-green-500 rounded-lg p-4 shadow-sm">
        <div class="flex items-center">
            <div class="flex-shrink-0">
                <i class="fas fa-check-circle text-green-500 text-lg"></i>
            </div>
            <div class="ml-3">
                <p class="text-green-700 font-medium">{{ session('success') }}</p>
            </div>
            <button type="button" class="ml-auto text-green-400 hover:text-green-600" onclick="this.closest('.mx-6').style.display='none'">
                <i class="fas fa-times"></i>
            </button>
        </div>
    </div>
    @endif
    
    @if(session('error'))
    <div class="mx-6 mt-6 mb-4 bg-red-50 border-l-4 border-red-500 rounded-lg p-4 shadow-sm">
        <div class="flex items-center">
            <div class="flex-shrink-0">
                <i class="fas fa-exclamation-circle text-red-500 text-lg"></i>
            </div>
            <div class="ml-3">
                <p class="text-red-700 font-medium">{{ session('error') }}</p>
            </div>
            <button type="button" class="ml-auto text-red-400 hover:text-red-600" onclick="this.closest('.mx-6').style.display='none'">
                <i class="fas fa-times"></i>
            </button>
        </div>
    </div>
    @endif

    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-100">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-20">No</th>
                    <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Username</th>
                    <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama</th>
                    <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Role</th>
                    <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Last Login</th>
                    <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-100">
                @forelse($users as $user)
                <tr class="hover:bg-gray-50 transition-colors duration-150">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center justify-center w-8 h-8 bg-gray-100 rounded-lg text-gray-600 font-medium text-sm">
                            {{ $loop->iteration }}
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 w-10 h-10 bg-purple-50 rounded-xl flex items-center justify-center mr-3">
                                <i class="fas fa-user text-[#27124A]"></i>
                            </div>
                            <div>
                                <h4 class="font-medium text-gray-800">{{ $user->username }}</h4>
                                <p class="text-xs text-gray-400">ID: {{ $user->id }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="font-medium text-gray-800">{{ $user->nama }}</div>
                    </td>
                    <td class="px-6 py-4">
                        @php
                            $roleConfig = [
                                'admin' => ['bg' => 'bg-purple-50', 'text' => 'text-[#27124A]', 'icon' => 'fa-user-shield', 'label' => 'Admin'],
                                'kasir' => ['bg' => 'bg-blue-50', 'text' => 'text-[#27124A]', 'icon' => 'fa-cash-register', 'label' => 'Kasir']
                            ];
                        @endphp
                        <span class="px-3 py-1.5 {{ $roleConfig[$user->role]['bg'] ?? 'bg-gray-50' }} rounded-lg text-sm font-medium inline-flex items-center border border-purple-100">
                            <i class="fas {{ $roleConfig[$user->role]['icon'] ?? 'fa-user' }} mr-2 text-xs text-[#27124A]"></i>
                            <span>{{ $roleConfig[$user->role]['label'] ?? ucfirst($user->role) }}</span>
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        <form action="{{ route('admin.users.toggleStatus', $user->id) }}" method="POST" class="inline">
                            @csrf
                            @method('PUT')
                            <button type="submit" 
                                    class="px-3 py-1.5 rounded-lg text-sm font-medium transition-all duration-300 
                                    {{ $user->status ? 
                                       'bg-green-100 text-green-700 border border-green-200 hover:bg-green-200' : 
                                       'bg-red-100 text-red-700 border border-red-200 hover:bg-red-200' }}"
                                    onclick="return confirm('Yakin ingin {{ $user->status ? 'nonaktifkan' : 'aktifkan' }} user {{ $user->nama }}?')">
                                <i class="fas {{ $user->status ? 'fa-toggle-on' : 'fa-toggle-off' }} mr-1"></i>
                                {{ $user->status ? 'Aktif' : 'Nonaktif' }}
                            </button>
                        </form>
                    </td>
                    <td class="px-6 py-4">
                        @if($user->last_login)
                            <div>
                                <span class="text-sm text-gray-700">{{ \Carbon\Carbon::parse($user->last_login)->format('d/m/Y') }}</span>
                                <span class="text-xs text-gray-400 block">{{ \Carbon\Carbon::parse($user->last_login)->format('H:i') }}</span>
                            </div>
                        @else
                            <span class="text-gray-400 text-sm italic">Belum login</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center space-x-2">
                            <a href="{{ route('admin.users.edit', $user->id) }}" 
                               class="p-2 bg-blue-50 hover:bg-blue-100 text-blue-600 rounded-lg transition-all duration-300 border border-blue-100"
                               title="Edit User">
                                <i class="fas fa-edit text-sm"></i>
                            </a>
                            
                            <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        class="p-2 bg-red-50 hover:bg-red-100 text-red-600 rounded-lg transition-all duration-300 border border-red-100 {{ $user->id == auth()->id() ? 'opacity-50 cursor-not-allowed' : '' }}"
                                        onclick="{{ $user->id != auth()->id() 
                                            ? 'return confirm(\'Yakin ingin menghapus user ' . $user->nama . '? Tindakan ini tidak dapat dibatalkan.\')' 
                                            : 'event.preventDefault();' }}"
                                        title="Hapus User"
                                        {{ $user->id == auth()->id() ? 'disabled' : '' }}>
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
                            <i class="fas fa-users text-3xl text-[#27124A]"></i>
                        </div>
                        <h4 class="text-lg font-semibold text-gray-800 mb-2">Belum Ada User</h4>
                        <p class="text-gray-400 text-sm mb-6">Mulai dengan menambahkan user pertama untuk mengelola sistem</p>
                        <a href="{{ route('admin.users.create') }}" 
                           class="inline-flex items-center px-5 py-2.5 bg-[#27124A] hover:bg-[#3a1d6b] text-white font-medium rounded-xl transition-all duration-300 shadow-sm hover:shadow-md">
                            <i class="fas fa-plus mr-2"></i> Tambah User Pertama
                        </a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@if(auth()->user()->role == 'owner' && $users->isNotEmpty())
<div class="mt-8 bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="p-6 border-b border-gray-100">
        <h3 class="text-lg font-semibold text-gray-800">Statistik User</h3>
        <p class="text-sm text-gray-500 mt-1">Ringkasan distribusi user sistem</p>
    </div>
    
    <div class="p-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="bg-gray-50/50 border border-gray-100 rounded-xl p-5">
                <div class="flex justify-between items-start mb-4">
                    <div>
                        <h4 class="font-medium text-gray-800">Administrator</h4>
                        <div class="flex items-center mt-1">
                            <span class="text-sm font-medium text-[#27124A]">{{ $users->where('role', 'admin')->count() }} user</span>
                            <span class="mx-2 text-gray-300">•</span>
                            <span class="text-sm text-gray-400">
                                {{ number_format(($users->where('role', 'admin')->count() / max(1, $users->count())) * 100, 1) }}%
                            </span>
                        </div>
                    </div>
                    <div class="w-12 h-12 bg-purple-50 rounded-xl flex items-center justify-center">
                        <i class="fas fa-user-shield text-[#27124A]"></i>
                    </div>
                </div>
                
                <div class="mb-2">
                    <div class="w-full h-1.5 bg-gray-100 rounded-full overflow-hidden">
                        @php
                            $adminPercentage = ($users->where('role', 'admin')->count() / max(1, $users->count())) * 100;
                        @endphp
                        <div class="h-full bg-[#27124A] rounded-full progress-bar" 
                             style="width: {{ $adminPercentage }}%"></div>
                    </div>
                </div>
            </div>
            
            <div class="bg-gray-50/50 border border-gray-100 rounded-xl p-5">
                <div class="flex justify-between items-start mb-4">
                    <div>
                        <h4 class="font-medium text-gray-800">Kasir</h4>
                        <div class="flex items-center mt-1">
                            <span class="text-sm font-medium text-[#27124A]">{{ $users->where('role', 'kasir')->count() }} user</span>
                            <span class="mx-2 text-gray-300">•</span>
                            <span class="text-sm text-gray-400">
                                {{ number_format(($users->where('role', 'kasir')->count() / max(1, $users->count())) * 100, 1) }}%
                            </span>
                        </div>
                    </div>
                    <div class="w-12 h-12 bg-blue-50 rounded-xl flex items-center justify-center">
                        <i class="fas fa-cash-register text-[#27124A]"></i>
                    </div>
                </div>
                
                <div class="mb-2">
                    <div class="w-full h-1.5 bg-gray-100 rounded-full overflow-hidden">
                        @php
                            $kasirPercentage = ($users->where('role', 'kasir')->count() / max(1, $users->count())) * 100;
                        @endphp
                        <div class="h-full bg-[#27124A] rounded-full progress-bar" 
                             style="width: {{ $kasirPercentage }}%"></div>
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
    table tbody tr {
        transition: all 0.2s ease;
    }
    
    table tbody tr:hover {
        background-color: #fafafa;
    }
    
    .progress-bar {
        transition: width 0.6s ease;
    }
    
    .bg-primary-custom {
        background-color: #27124A;
    }
    
    .text-primary-custom {
        color: #27124A;
    }
    
    .border-primary-custom {
        border-color: #27124A;
    }
    
    .hover\:bg-primary-custom:hover {
        background-color: #27124A;
    }
    
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
    
    button:disabled {
        opacity: 0.5;
        cursor: not-allowed;
    }
    
    [onclick*="this.closest"]:hover {
        opacity: 0.7;
    }
</style>
@endpush

@push('scripts')
<script>
    function confirmRestore(userName, userId) {
        if (confirm('Yakin ingin merestore user ' + userName + '?')) {
            document.getElementById('restore-form-' + userId).submit();
        }
    }
    
    function confirmForceDelete(userName, userId) {
        if (confirm('Yakin ingin menghapus permanen user ' + userName + '? Tindakan ini tidak dapat dibatalkan.')) {
            document.getElementById('force-delete-form-' + userId).submit();
        }
    }
    
    document.addEventListener('DOMContentLoaded', function() {
        const alerts = document.querySelectorAll('.border-l-4');
        alerts.forEach(alert => {
            setTimeout(() => {
                if (alert) {
                    alert.style.opacity = '0';
                    alert.style.transition = 'opacity 0.5s ease';
                    setTimeout(() => {
                        if (alert) alert.style.display = 'none';
                    }, 500);
                }
            }, 5000);
        });
    });
</script>
@endpush