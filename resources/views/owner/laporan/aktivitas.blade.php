@extends('layouts.app')

@section('title', 'Aktivitas User')
@section('page-title', 'Aktivitas User')

@section('sidebar')
@include('owner.partials.sidebar')
@endsection

@section('content')
<div class="space-y-4 md:space-y-6 w-full max-w-full">
    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-7 gap-3 md:gap-4 w-full">
        <div class="bg-white rounded-xl md:rounded-2xl shadow-sm border border-gray-100 p-3 md:p-4">
            <div class="flex items-center justify-between">
                <div class="flex-1 pr-2">
                    <p class="text-xs md:text-sm text-gray-500 mb-1">Total Log</p>
                    <p class="text-xl md:text-2xl font-bold text-gray-800">{{ number_format($summary['total_logs'], 0, ',', '.') }}</p>
                </div>
                <div class="w-10 h-10 md:w-12 md:h-12 bg-blue-50 rounded-xl flex items-center justify-center flex-shrink-0">
                    <i class="fas fa-history text-[#27124A] text-base md:text-xl"></i>
                </div>
            </div>
            <div class="mt-2 md:mt-3 flex items-center text-xs text-gray-500">
                <span class="text-blue-500 mr-1">📋</span>
                <span>Total aktivitas</span>
            </div>
        </div>
        <div class="bg-white rounded-xl md:rounded-2xl shadow-sm border border-gray-100 p-3 md:p-4">
            <div class="flex items-center justify-between">
                <div class="flex-1 pr-2">
                    <p class="text-xs md:text-sm text-gray-500 mb-1">Login</p>
                    <p class="text-xl md:text-2xl font-bold text-green-600">{{ number_format($summary['total_login'], 0, ',', '.') }}</p>
                </div>
                <div class="w-10 h-10 md:w-12 md:h-12 bg-green-50 rounded-xl flex items-center justify-center flex-shrink-0">
                    <i class="fas fa-sign-in-alt text-[#27124A] text-base md:text-xl"></i>
                </div>
            </div>
            <div class="mt-2 md:mt-3 flex items-center text-xs text-gray-500">
                <span class="text-green-500 mr-1">🔐</span>
                <span>Aktivitas login</span>
            </div>
        </div>
        <div class="bg-white rounded-xl md:rounded-2xl shadow-sm border border-gray-100 p-3 md:p-4">
            <div class="flex items-center justify-between">
                <div class="flex-1 pr-2">
                    <p class="text-xs md:text-sm text-gray-500 mb-1">Logout</p>
                    <p class="text-xl md:text-2xl font-bold text-orange-600">{{ number_format($summary['total_logout'], 0, ',', '.') }}</p>
                </div>
                <div class="w-10 h-10 md:w-12 md:h-12 bg-orange-50 rounded-xl flex items-center justify-center flex-shrink-0">
                    <i class="fas fa-sign-out-alt text-[#27124A] text-base md:text-xl"></i>
                </div>
            </div>
            <div class="mt-2 md:mt-3 flex items-center text-xs text-gray-500">
                <span class="text-orange-500 mr-1">🚪</span>
                <span>Aktivitas logout</span>
            </div>
        </div>
        <div class="bg-white rounded-xl md:rounded-2xl shadow-sm border border-gray-100 p-3 md:p-4">
            <div class="flex items-center justify-between">
                <div class="flex-1 pr-2">
                    <p class="text-xs md:text-sm text-gray-500 mb-1">Create</p>
                    <p class="text-xl md:text-2xl font-bold text-purple-600">{{ number_format($summary['total_create'], 0, ',', '.') }}</p>
                </div>
                <div class="w-10 h-10 md:w-12 md:h-12 bg-purple-50 rounded-xl flex items-center justify-center flex-shrink-0">
                    <i class="fas fa-plus-circle text-[#27124A] text-base md:text-xl"></i>
                </div>
            </div>
            <div class="mt-2 md:mt-3 flex items-center text-xs text-gray-500">
                <span class="text-purple-500 mr-1">➕</span>
                <span>Menambah data</span>
            </div>
        </div>
        <div class="bg-white rounded-xl md:rounded-2xl shadow-sm border border-gray-100 p-3 md:p-4">
            <div class="flex items-center justify-between">
                <div class="flex-1 pr-2">
                    <p class="text-xs md:text-sm text-gray-500 mb-1">Update</p>
                    <p class="text-xl md:text-2xl font-bold text-yellow-600">{{ number_format($summary['total_update'], 0, ',', '.') }}</p>
                </div>
                <div class="w-10 h-10 md:w-12 md:h-12 bg-yellow-50 rounded-xl flex items-center justify-center flex-shrink-0">
                    <i class="fas fa-edit text-[#27124A] text-base md:text-xl"></i>
                </div>
            </div>
            <div class="mt-2 md:mt-3 flex items-center text-xs text-gray-500">
                <span class="text-yellow-500 mr-1">✏️</span>
                <span>Mengubah data</span>
            </div>
        </div>
        <div class="bg-white rounded-xl md:rounded-2xl shadow-sm border border-gray-100 p-3 md:p-4">
            <div class="flex items-center justify-between">
                <div class="flex-1 pr-2">
                    <p class="text-xs md:text-sm text-gray-500 mb-1">Delete</p>
                    <p class="text-xl md:text-2xl font-bold text-red-600">{{ number_format($summary['total_delete'], 0, ',', '.') }}</p>
                </div>
                <div class="w-10 h-10 md:w-12 md:h-12 bg-red-50 rounded-xl flex items-center justify-center flex-shrink-0">
                    <i class="fas fa-trash-alt text-[#27124A] text-base md:text-xl"></i>
                </div>
            </div>
            <div class="mt-2 md:mt-3 flex items-center text-xs text-gray-500">
                <span class="text-red-500 mr-1">🗑️</span>
                <span>Menghapus data</span>
            </div>
        </div>
        <div class="bg-white rounded-xl md:rounded-2xl shadow-sm border border-gray-100 p-3 md:p-4">
            <div class="flex items-center justify-between">
                <div class="flex-1 pr-2">
                    <p class="text-xs md:text-sm text-gray-500 mb-1">View</p>
                    <p class="text-xl md:text-2xl font-bold text-indigo-600">{{ number_format($summary['total_view'], 0, ',', '.') }}</p>
                </div>
                <div class="w-10 h-10 md:w-12 md:h-12 bg-indigo-50 rounded-xl flex items-center justify-center flex-shrink-0">
                    <i class="fas fa-eye text-[#27124A] text-base md:text-xl"></i>
                </div>
            </div>
            <div class="mt-2 md:mt-3 flex items-center text-xs text-gray-500">
                <span class="text-indigo-500 mr-1">👁️</span>
                <span>Melihat data</span>
            </div>
        </div>
    </div>

    <div class="bg-blue-50 border border-blue-200 rounded-xl md:rounded-2xl p-3 md:p-4 flex items-center">
        <div class="w-6 h-6 md:w-8 md:h-8 bg-blue-100 rounded-full flex items-center justify-center mr-2 md:mr-3 flex-shrink-0">
            <i class="fas fa-info-circle text-blue-600 text-xs md:text-sm"></i>
        </div>
        <p class="text-xs md:text-sm text-blue-800">
            <span class="font-semibold">Informasi:</span> Menampilkan semua aktivitas user dalam sistem. 
            Gunakan filter untuk melihat data spesifik.
        </p>
    </div>

    <div class="bg-white rounded-xl md:rounded-2xl shadow-sm border border-gray-100 overflow-hidden w-full">
        <div class="p-3 md:p-4 border-b border-gray-100">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3">
                <div class="min-w-0 flex-1">
                    <h3 class="text-sm md:text-base font-semibold text-gray-800">Riwayat Aktivitas</h3>
                    <p class="text-xs md:text-sm text-gray-500 mt-0.5">Monitor semua aktivitas admin dan kasir di sistem</p>
                </div>
            </div>
        </div>

        <div class="p-3 md:p-4 border-b border-gray-100 bg-gray-50/50">
            <form method="GET" action="{{ route('owner.laporan.aktivitas') }}" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-2 md:gap-3">
                <div>
                    <label class="block text-xs md:text-sm font-medium text-gray-700 mb-1">Tgl Mulai</label>
                    <input type="date" name="start_date" value="{{ $startDate->format('Y-m-d') }}" 
                           class="w-full px-2 md:px-3 py-1.5 md:py-2 text-xs md:text-sm border border-gray-200 rounded-lg md:rounded-xl focus:outline-none focus:ring-2 focus:ring-[#27124A]/20 focus:border-[#27124A] transition-all">
                </div>
                <div>
                    <label class="block text-xs md:text-sm font-medium text-gray-700 mb-1">Tgl Akhir</label>
                    <input type="date" name="end_date" value="{{ $endDate->format('Y-m-d') }}" 
                           class="w-full px-2 md:px-3 py-1.5 md:py-2 text-xs md:text-sm border border-gray-200 rounded-lg md:rounded-xl focus:outline-none focus:ring-2 focus:ring-[#27124A]/20 focus:border-[#27124A] transition-all">
                </div>
                <div>
                    <label class="block text-xs md:text-sm font-medium text-gray-700 mb-1">Role</label>
                    <select name="role" class="w-full px-2 md:px-3 py-1.5 md:py-2 text-xs md:text-sm border border-gray-200 rounded-lg md:rounded-xl focus:outline-none focus:ring-2 focus:ring-[#27124A]/20 focus:border-[#27124A] transition-all">
                        <option value="">Semua Role</option>
                        <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                        <option value="kasir" {{ request('role') == 'kasir' ? 'selected' : '' }}>Kasir</option>
                        <option value="owner" {{ request('role') == 'owner' ? 'selected' : '' }}>Owner</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs md:text-sm font-medium text-gray-700 mb-1">Pencarian</label>
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

        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3 p-3 md:p-4 border-b border-gray-100">
            <div class="text-xs md:text-sm text-gray-500 bg-gray-50 px-3 md:px-4 py-1.5 md:py-2 rounded-lg md:rounded-xl">
                <i class="fas fa-info-circle mr-1 md:mr-2 text-[#27124A]"></i>
                <span>Menampilkan {{ $logs->firstItem() ?? 0 }} - {{ $logs->lastItem() ?? 0 }} dari {{ number_format($logs->total(), 0, ',', '.') }} aktivitas</span>
                <span class="ml-2">| Periode: {{ $startDate->format('d/m/Y') }} - {{ $endDate->format('d/m/Y') }}</span>
            </div>
            
            <div class="flex gap-2">
                <a href="{{ route('owner.laporan.aktivitas', array_merge(request()->query(), ['export' => 'pdf'])) }}" 
                   class="bg-red-600 hover:bg-red-700 text-white px-3 md:px-4 py-1.5 md:py-2 rounded-lg md:rounded-xl text-xs md:text-sm transition-all duration-300 flex items-center">
                    <i class="fas fa-file-pdf mr-1 md:mr-2"></i> PDF
                </a>
                <a href="{{ route('owner.laporan.aktivitas', array_merge(request()->query(), ['export' => 'excel'])) }}" 
                   class="bg-green-600 hover:bg-green-700 text-white px-3 md:px-4 py-1.5 md:py-2 rounded-lg md:rounded-xl text-xs md:text-sm transition-all duration-300 flex items-center">
                    <i class="fas fa-file-excel mr-1 md:mr-2"></i> Excel
                </a>
            </div>
        </div>

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
        
        @if($logs->hasPages())
        <div class="p-3 md:p-4 border-t border-gray-100">
            <div class="overflow-x-auto">
                {{ $logs->withQueryString()->links() }}
            </div>
        </div>
        @endif
    </div>
</div>
@endsection