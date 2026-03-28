@extends('layouts.app')

@section('title', 'Aktivitas User')
@section('page-title', 'Aktivitas User')

@section('sidebar')
@include('owner.partials.sidebar')
@endsection

@section('content')
<div class="space-y-4 md:space-y-6 w-full max-w-full">
    <!-- Header dengan Export -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
        <div>
            <h1 class="text-2xl md:text-3xl font-bold text-gray-900">Aktivitas User</h1>
            <p class="text-xs md:text-sm text-gray-500 mt-1">Monitor semua aktivitas admin dan kasir di sistem</p>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('owner.laporan.aktivitas', ['export' => 'pdf'] + request()->all()) }}" 
               class="bg-red-600 hover:bg-red-700 text-white px-3 md:px-4 py-1.5 md:py-2 rounded-lg md:rounded-xl text-xs md:text-sm transition-all duration-300 flex items-center shadow-sm">
                <i class="fas fa-file-pdf mr-1 md:mr-2"></i> PDF
            </a>
            <a href="{{ route('owner.laporan.aktivitas', ['export' => 'excel'] + request()->all()) }}" 
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
            <span class="font-semibold">Informasi:</span> Menampilkan semua aktivitas user dalam sistem. 
            Gunakan filter untuk melihat data spesifik.
        </p>
    </div>

    <!-- Filter Section - Menyatu dengan Card -->
    <div class="bg-white rounded-xl md:rounded-2xl shadow-sm border border-gray-100 overflow-hidden w-full">
        <!-- Header Filter -->
        <div class="p-3 md:p-4 border-b border-gray-100 bg-gray-50/50">
            <h3 class="text-sm md:text-base font-semibold text-gray-800 flex items-center">
                <i class="fas fa-filter mr-2 text-[#27124A]"></i>
                Filter Aktivitas
            </h3>
        </div>
        
        <!-- Form Filter -->
        <div class="p-3 md:p-4 border-b border-gray-100">
            <form method="GET" action="{{ route('owner.laporan.aktivitas') }}" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-2 md:gap-3">
                <div>
                    <label class="block text-xs md:text-sm font-medium text-gray-700 mb-1">
                        <i class="far fa-calendar-alt mr-1 text-gray-400"></i> Tgl Mulai
                    </label>
                    <input type="date" name="start_date" value="{{ $startDate->format('Y-m-d') }}" 
                           class="w-full px-2 md:px-3 py-1.5 md:py-2 text-xs md:text-sm border border-gray-200 rounded-lg md:rounded-xl focus:outline-none focus:ring-2 focus:ring-[#27124A]/20 focus:border-[#27124A] transition-all">
                </div>
                <div>
                    <label class="block text-xs md:text-sm font-medium text-gray-700 mb-1">
                        <i class="far fa-calendar-alt mr-1 text-gray-400"></i> Tgl Akhir
                    </label>
                    <input type="date" name="end_date" value="{{ $endDate->format('Y-m-d') }}" 
                           class="w-full px-2 md:px-3 py-1.5 md:py-2 text-xs md:text-sm border border-gray-200 rounded-lg md:rounded-xl focus:outline-none focus:ring-2 focus:ring-[#27124A]/20 focus:border-[#27124A] transition-all">
                </div>
                <div>
                    <label class="block text-xs md:text-sm font-medium text-gray-700 mb-1">
                        <i class="fas fa-user-tag mr-1 text-gray-400"></i> Role
                    </label>
                    <select name="role" class="w-full px-2 md:px-3 py-1.5 md:py-2 text-xs md:text-sm border border-gray-200 rounded-lg md:rounded-xl focus:outline-none focus:ring-2 focus:ring-[#27124A]/20 focus:border-[#27124A] transition-all">
                        <option value="">Semua Role</option>
                        <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                        <option value="kasir" {{ request('role') == 'kasir' ? 'selected' : '' }}>Kasir</option>
                        <option value="owner" {{ request('role') == 'owner' ? 'selected' : '' }}>Owner</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs md:text-sm font-medium text-gray-700 mb-1">
                        <i class="fas fa-search mr-1 text-gray-400"></i> Pencarian
                    </label>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari aktivitas..." 
                           class="w-full px-2 md:px-3 py-1.5 md:py-2 text-xs md:text-sm border border-gray-200 rounded-lg md:rounded-xl focus:outline-none focus:ring-2 focus:ring-[#27124A]/20 focus:border-[#27124A] transition-all">
                </div>
                <div class="flex items-end gap-2">
                    <button type="submit"
                        class="flex-1 bg-[#27124A] hover:bg-[#3a1d6b] text-white text-xs md:text-sm font-medium py-1.5 md:py-2 px-2 rounded-lg md:rounded-xl transition-all duration-300 flex items-center justify-center">
                        <i class="fas fa-filter mr-1 text-xs"></i>
                        <span class="hidden sm:inline">Filter</span>
                    </button>
                    <a href="{{ route('owner.laporan.aktivitas') }}"
                        class="flex-1 bg-gray-200 hover:bg-gray-300 text-gray-800 text-xs md:text-sm font-medium py-1.5 md:py-2 px-2 rounded-lg md:rounded-xl transition-all duration-300 flex items-center justify-center">
                        <i class="fas fa-redo mr-1 text-xs"></i>
                        <span class="hidden sm:inline">Reset</span>
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Statistik Ringkasan - 7 Cards -->
    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-7 gap-2 md:gap-3">
        <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-xl md:rounded-2xl p-3 md:p-4 border border-blue-200">
            <p class="text-xs text-blue-600 font-medium mb-1">Total Log</p>
            <p class="text-lg md:text-2xl font-bold text-gray-800">{{ number_format($summary['total_logs'], 0, ',', '.') }}</p>
        </div>
        <div class="bg-gradient-to-br from-green-50 to-green-100 rounded-xl md:rounded-2xl p-3 md:p-4 border border-green-200">
            <p class="text-xs text-green-600 font-medium mb-1">Login</p>
            <p class="text-lg md:text-2xl font-bold text-gray-800">{{ number_format($summary['total_login'], 0, ',', '.') }}</p>
        </div>
        <div class="bg-gradient-to-br from-orange-50 to-orange-100 rounded-xl md:rounded-2xl p-3 md:p-4 border border-orange-200">
            <p class="text-xs text-orange-600 font-medium mb-1">Logout</p>
            <p class="text-lg md:text-2xl font-bold text-gray-800">{{ number_format($summary['total_logout'], 0, ',', '.') }}</p>
        </div>
        <div class="bg-gradient-to-br from-purple-50 to-purple-100 rounded-xl md:rounded-2xl p-3 md:p-4 border border-purple-200">
            <p class="text-xs text-purple-600 font-medium mb-1">Create</p>
            <p class="text-lg md:text-2xl font-bold text-gray-800">{{ number_format($summary['total_create'], 0, ',', '.') }}</p>
        </div>
        <div class="bg-gradient-to-br from-yellow-50 to-yellow-100 rounded-xl md:rounded-2xl p-3 md:p-4 border border-yellow-200">
            <p class="text-xs text-yellow-600 font-medium mb-1">Update</p>
            <p class="text-lg md:text-2xl font-bold text-gray-800">{{ number_format($summary['total_update'], 0, ',', '.') }}</p>
        </div>
        <div class="bg-gradient-to-br from-red-50 to-red-100 rounded-xl md:rounded-2xl p-3 md:p-4 border border-red-200">
            <p class="text-xs text-red-600 font-medium mb-1">Delete</p>
            <p class="text-lg md:text-2xl font-bold text-gray-800">{{ number_format($summary['total_delete'], 0, ',', '.') }}</p>
        </div>
        <div class="bg-gradient-to-br from-indigo-50 to-indigo-100 rounded-xl md:rounded-2xl p-3 md:p-4 border border-indigo-200">
            <p class="text-xs text-indigo-600 font-medium mb-1">View</p>
            <p class="text-lg md:text-2xl font-bold text-gray-800">{{ number_format($summary['total_view'], 0, ',', '.') }}</p>
        </div>
    </div>

    <!-- Tabel Log -->
    <div class="bg-white rounded-xl md:rounded-2xl shadow-sm border border-gray-100 overflow-hidden w-full">
        <!-- Header Tabel -->
        <div class="p-3 md:p-4 border-b border-gray-100 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3">
            <div>
                <h3 class="text-sm md:text-base font-semibold text-gray-800">Riwayat Aktivitas</h3>
                <p class="text-xs md:text-sm text-gray-500 mt-0.5">Menampilkan {{ $logs->firstItem() ?? 0 }} - {{ $logs->lastItem() ?? 0 }} dari {{ number_format($logs->total(), 0, ',', '.') }} aktivitas</p>
            </div>
            <span class="text-xs md:text-sm text-gray-500 bg-gray-50 px-3 md:px-4 py-1.5 md:py-2 rounded-lg md:rounded-xl">
                <i class="far fa-clock mr-1"></i> 
                {{ $startDate->format('d/m/Y') }} - {{ $endDate->format('d/m/Y') }}
            </span>
        </div>
        
        <!-- Table -->
        <div class="overflow-x-auto w-full">
            <table class="min-w-full divide-y divide-gray-100">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-3 md:px-4 py-2 md:py-3 text-left text-xs font-medium text-gray-500 uppercase">Waktu</th>
                        <th class="px-3 md:px-4 py-2 md:py-3 text-left text-xs font-medium text-gray-500 uppercase">User</th>
                        <th class="px-3 md:px-4 py-2 md:py-3 text-left text-xs font-medium text-gray-500 uppercase hidden sm:table-cell">Role</th>
                        <th class="px-3 md:px-4 py-2 md:py-3 text-left text-xs font-medium text-gray-500 uppercase">Aktivitas</th>
                        <th class="px-3 md:px-4 py-2 md:py-3 text-left text-xs font-medium text-gray-500 uppercase hidden md:table-cell">Keterangan</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-100">
                    @forelse($logs as $log)
                    <tr class="hover:bg-gray-50 transition-colors duration-150">
                        <td class="px-3 md:px-4 py-2 md:py-3 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="w-6 h-6 bg-gray-50 rounded-lg flex items-center justify-center mr-1 flex-shrink-0">
                                    <i class="fas fa-clock text-gray-400 text-xs"></i>
                                </div>
                                <div>
                                    <div class="text-xs text-gray-700">{{ $log->created_at->format('d/m/Y') }}</div>
                                    <div class="text-xs text-gray-400">{{ $log->created_at->format('H:i:s') }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-3 md:px-4 py-2 md:py-3 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="w-6 h-6 bg-purple-50 rounded-lg flex items-center justify-center mr-1 flex-shrink-0">
                                    <i class="fas fa-user text-[#27124A] text-xs"></i>
                                </div>
                                <span class="text-xs md:text-sm font-medium text-gray-800">{{ $log->user->nama ?? 'Unknown' }}</span>
                            </div>
                        </td>
                        <td class="px-3 md:px-4 py-2 md:py-3 whitespace-nowrap hidden sm:table-cell">
                            @if($log->role_user == 'admin')
                                <span class="px-2 py-1 bg-red-100 text-red-700 rounded-lg text-xs flex items-center w-fit">
                                    <i class="fas fa-shield-alt mr-1 text-xs"></i> Admin
                                </span>
                            @elseif($log->role_user == 'kasir')
                                <span class="px-2 py-1 bg-green-100 text-green-700 rounded-lg text-xs flex items-center w-fit">
                                    <i class="fas fa-cash-register mr-1 text-xs"></i> Kasir
                                </span>
                            @else
                                <span class="px-2 py-1 bg-purple-100 text-purple-700 rounded-lg text-xs flex items-center w-fit">
                                    <i class="fas fa-crown mr-1 text-xs"></i> Owner
                                </span>
                            @endif
                        </td>
                        <td class="px-3 md:px-4 py-2 md:py-3 whitespace-nowrap">
                            @php
                                $activityClass = match(true) {
                                    str_contains($log->activity, 'Create') => 'text-green-600 bg-green-100',
                                    str_contains($log->activity, 'Update') => 'text-yellow-600 bg-yellow-100',
                                    str_contains($log->activity, 'Delete') => 'text-red-600 bg-red-100',
                                    str_contains($log->activity, 'Login') => 'text-blue-600 bg-blue-100',
                                    str_contains($log->activity, 'Logout') => 'text-orange-600 bg-orange-100',
                                    str_contains($log->activity, 'View') => 'text-purple-600 bg-purple-100',
                                    default => 'text-gray-600 bg-gray-100'
                                };
                            @endphp
                            <span class="px-2 py-1 rounded-lg text-xs font-medium {{ $activityClass }} flex items-center w-fit">
                                <i class="fas 
                                    @if(str_contains($log->activity, 'Create')) fa-plus
                                    @elseif(str_contains($log->activity, 'Update')) fa-edit
                                    @elseif(str_contains($log->activity, 'Delete')) fa-trash
                                    @elseif(str_contains($log->activity, 'Login')) fa-sign-in-alt
                                    @elseif(str_contains($log->activity, 'Logout')) fa-sign-out-alt
                                    @elseif(str_contains($log->activity, 'View')) fa-eye
                                    @else fa-circle
                                    @endif mr-1 text-xs"></i>
                                {{ $log->activity }}
                            </span>
                        </td>
                        <td class="px-3 md:px-4 py-2 md:py-3 text-xs text-gray-600 max-w-xs hidden md:table-cell">
                            {{ Str::limit($log->keterangan, 50) }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-4 py-8 text-center">
                            <div class="inline-flex items-center justify-center w-14 h-14 md:w-16 md:h-16 bg-purple-50 rounded-full mb-3">
                                <i class="fas fa-history text-xl md:text-2xl text-[#27124A]"></i>
                            </div>
                            <h4 class="text-sm md:text-base font-semibold text-gray-800 mb-1">Tidak Ada Aktivitas</h4>
                            <p class="text-xs md:text-sm text-gray-400">Belum ada aktivitas yang tercatat pada periode ini</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        @if($logs->hasPages())
        <div class="p-3 md:p-4 border-t border-gray-100">
            <div class="overflow-x-auto">
                {{ $logs->withQueryString()->links() }}
            </div>
        </div>
        @endif
    </div>

    <!-- Statistik per User & Aktivitas Terbaru -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 md:gap-6">
        <!-- Top User by Activity -->
        <div class="bg-white rounded-xl md:rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="p-3 md:p-4 border-b border-gray-100 bg-gradient-to-r from-blue-50 to-indigo-50">
                <h3 class="text-sm md:text-base font-semibold text-gray-800 flex items-center">
                    <i class="fas fa-chart-bar text-blue-500 mr-2"></i>
                    Top User by Activity
                </h3>
                <p class="text-xs md:text-sm text-gray-500 mt-0.5">User dengan aktivitas terbanyak</p>
            </div>
            
            <div class="divide-y divide-gray-100 max-h-80 overflow-y-auto">
                @forelse($userStats->sortByDesc('logs_count')->take(5) as $user)
                <div class="p-3 md:p-4 hover:bg-gray-50 transition-colors duration-150">
                    <div class="flex justify-between items-center">
                        <div class="flex items-center min-w-0 flex-1">
                            <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center mr-3 flex-shrink-0">
                                <i class="fas fa-user text-blue-600 text-sm"></i>
                            </div>
                            <div class="min-w-0 flex-1">
                                <p class="text-xs md:text-sm font-semibold text-gray-800 truncate">{{ $user->nama }}</p>
                                <p class="text-xs text-gray-500">{{ $user->role == 'admin' ? 'Admin' : 'Kasir' }}</p>
                            </div>
                        </div>
                        <div class="text-right ml-2 flex-shrink-0">
                            <p class="text-base md:text-lg font-bold text-blue-600">{{ number_format($user->logs_count, 0, ',', '.') }}</p>
                            <p class="text-xs text-gray-400">aktivitas</p>
                        </div>
                    </div>
                </div>
                @empty
                <div class="p-6 text-center">
                    <p class="text-xs md:text-sm text-gray-400">Tidak ada data user</p>
                </div>
                @endforelse
            </div>
        </div>
        
        <!-- Aktivitas Terbaru -->
        <div class="bg-white rounded-xl md:rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="p-3 md:p-4 border-b border-gray-100 bg-gradient-to-r from-green-50 to-emerald-50">
                <h3 class="text-sm md:text-base font-semibold text-gray-800 flex items-center">
                    <i class="fas fa-clock text-green-500 mr-2"></i>
                    Aktivitas Terbaru
                </h3>
                <p class="text-xs md:text-sm text-gray-500 mt-0.5">10 aktivitas terakhir</p>
            </div>
            
            <div class="divide-y divide-gray-100 max-h-80 overflow-y-auto">
                @forelse($recentActivities->take(10) as $activity)
                <div class="p-3 md:p-4 hover:bg-gray-50 transition-colors duration-150">
                    <div class="flex items-start">
                        <div class="flex-shrink-0 mt-1">
                            @php
                                $icon = match(true) {
                                    str_contains($activity->activity, 'Create') => ['bg-green-100', 'fa-plus', 'text-green-600'],
                                    str_contains($activity->activity, 'Update') => ['bg-yellow-100', 'fa-edit', 'text-yellow-600'],
                                    str_contains($activity->activity, 'Delete') => ['bg-red-100', 'fa-trash', 'text-red-600'],
                                    str_contains($activity->activity, 'Login') => ['bg-blue-100', 'fa-sign-in-alt', 'text-blue-600'],
                                    str_contains($activity->activity, 'Logout') => ['bg-orange-100', 'fa-sign-out-alt', 'text-orange-600'],
                                    str_contains($activity->activity, 'View') => ['bg-purple-100', 'fa-eye', 'text-purple-600'],
                                    default => ['bg-gray-100', 'fa-circle', 'text-gray-600']
                                };
                            @endphp
                            <div class="w-7 h-7 md:w-8 md:h-8 {{ $icon[0] }} rounded-lg flex items-center justify-center">
                                <i class="fas {{ $icon[1] }} {{ $icon[2] }} text-xs md:text-sm"></i>
                            </div>
                        </div>
                        <div class="ml-2 md:ml-3 flex-1 min-w-0">
                            <p class="text-xs md:text-sm text-gray-800">
                                <span class="font-semibold">{{ $activity->user->nama ?? 'System' }}</span> 
                                {{ $activity->activity }}
                            </p>
                            <p class="text-xs text-gray-500 mt-0.5 truncate">{{ $activity->keterangan }}</p>
                            <div class="flex items-center mt-1">
                                <i class="far fa-clock text-gray-400 text-xs mr-1"></i>
                                <p class="text-xs text-gray-400">{{ $activity->created_at->diffForHumans() }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                <div class="p-6 text-center">
                    <p class="text-xs md:text-sm text-gray-400">Tidak ada aktivitas terbaru</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection