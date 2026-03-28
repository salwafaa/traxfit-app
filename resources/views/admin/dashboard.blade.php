@extends('layouts.app')

@section('title', 'Dashboard Admin')
@section('page-title', 'Dashboard Admin')

@section('sidebar')
@include('admin.partials.sidebar')
@endsection

@section('content')
<div class="space-y-6">
    <!-- Welcome Message - Clean and Simple -->
    <div class="bg-gradient-to-r from-[#27124A] to-[#3a1d6b] rounded-2xl shadow-lg overflow-hidden">
        <div class="p-6 md:p-8">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-xl md:text-2xl font-bold text-white mb-2">
                        Selamat Bekerja, {{ Auth::user()->nama }}! 👋
                    </h2>
                    <p class="text-purple-200 text-sm md:text-base">
                        Anda login sebagai <span class="font-semibold text-white">Administrator</span>
                    </p>
                    <div class="flex items-center mt-3 text-purple-200 text-xs md:text-sm">
                        <i class="fas fa-calendar-alt mr-2"></i>
                        <span>{{ now()->translatedFormat('l, d F Y - H:i') }}</span>
                    </div>
                </div>
                <div class="hidden md:block">
                    <div class="w-20 h-20 bg-white/10 rounded-2xl flex items-center justify-center">
                        <i class="fas fa-user-shield text-white text-3xl"></i>
                </div>
            </div>
        </div>
    </div>
    </div>

    <!-- Key Stats - Only 4 Most Important Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <!-- Total Users -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs text-gray-500 uppercase tracking-wider">Total Users</p>
                    <p class="text-2xl font-bold text-gray-800 mt-1">{{ $stats['total_users'] }}</p>
                </div>
                <div class="w-10 h-10 bg-blue-50 rounded-lg flex items-center justify-center">
                    <i class="fas fa-users text-[#27124A] text-lg"></i>
                </div>
            </div>
            <div class="mt-3 text-xs text-gray-500">
                <i class="fas fa-circle text-green-500 text-[8px] mr-1"></i> Seluruh pengguna sistem
            </div>
        </div>

        <!-- Member Aktif -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs text-gray-500 uppercase tracking-wider">Member Aktif</p>
                    <p class="text-2xl font-bold text-gray-800 mt-1">{{ $stats['active_members'] }}</p>
                </div>
                <div class="w-10 h-10 bg-green-50 rounded-lg flex items-center justify-center">
                    <i class="fas fa-user-check text-[#27124A] text-lg"></i>
                </div>
            </div>
            <div class="mt-3 text-xs text-gray-500">
                <i class="fas fa-circle text-green-500 text-[8px] mr-1"></i> Dari {{ $stats['total_members'] }} total member
            </div>
        </div>

        <!-- Produk Tersedia -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs text-gray-500 uppercase tracking-wider">Produk Tersedia</p>
                    <p class="text-2xl font-bold text-gray-800 mt-1">{{ $stats['available_products'] ?? '0' }}</p>
                </div>
                <div class="w-10 h-10 bg-yellow-50 rounded-lg flex items-center justify-center">
                    <i class="fas fa-box text-[#27124A] text-lg"></i>
                </div>
            </div>
            <div class="mt-3 text-xs text-gray-500">
                <i class="fas fa-circle text-yellow-500 text-[8px] mr-1"></i> Dari {{ $stats['total_products'] }} total produk
            </div>
        </div>

        <!-- Pendapatan Hari Ini -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs text-gray-500 uppercase tracking-wider">Pendapatan Hari Ini</p>
                    <p class="text-2xl font-bold text-gray-800 mt-1">Rp {{ number_format($stats['today_revenue'], 0, ',', '.') }}</p>
                </div>
                <div class="w-10 h-10 bg-purple-50 rounded-lg flex items-center justify-center">
                    <i class="fas fa-chart-line text-[#27124A] text-lg"></i>
                </div>
            </div>
            <div class="mt-3 text-xs text-gray-500">
                <i class="fas fa-circle text-purple-500 text-[8px] mr-1"></i> {{ $stats['today_transactions'] }} transaksi
            </div>
        </div>
    </div>

    <!-- Charts Row -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Grafik Pendapatan -->
        <div class="lg:col-span-2 bg-white rounded-xl shadow-sm border border-gray-100 p-5">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h3 class="text-sm font-semibold text-gray-800">Grafik Pendapatan</h3>
                    <p class="text-xs text-gray-500 mt-1" id="chart-subtitle">7 hari terakhir</p>
                </div>
                <div class="flex space-x-2">
                    <button data-period="week" 
                            class="period-btn px-3 py-1.5 bg-[#27124A]/10 text-[#27124A] rounded-lg text-xs font-medium">
                        Minggu
                    </button>
                    <button data-period="month" 
                            class="period-btn px-3 py-1.5 text-gray-500 hover:bg-gray-50 rounded-lg text-xs font-medium">
                        Bulan
                    </button>
                </div>
            </div>
            
            <!-- Chart Container -->
            <div class="h-48 flex items-end space-x-2" id="chart-container">
                @php
                    $chartData = $chartData ?? ['labels' => ['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min'], 'values' => [0,0,0,0,0,0,0], 'maxValue' => 1];
                @endphp
                
                @foreach($chartData['labels'] as $index => $label)
                    @php 
                        $value = $chartData['values'][$index] ?? 0;
                        $height = $chartData['maxValue'] > 0 ? ($value / $chartData['maxValue']) * 100 : 0;
                    @endphp
                    <div class="flex-1 flex flex-col items-center group" data-value="{{ $value }}">
                        <div class="w-full bg-[#27124A]/10 rounded-t-lg relative transition-all duration-300 group-hover:bg-[#27124A]/20" 
                             style="height: {{ $height }}px; min-height: 20px;">
                            <div class="absolute -top-8 left-1/2 transform -translate-x-1/2 bg-gray-800 text-white text-xs py-1 px-2 rounded opacity-0 group-hover:opacity-100 transition-opacity whitespace-nowrap z-10">
                                Rp {{ number_format($value, 0, ',', '.') }}
                            </div>
                        </div>
                        <span class="text-xs text-gray-500 mt-2">{{ $label }}</span>
                    </div>
                @endforeach
            </div>
            
            <!-- Loading & Empty States -->
            <div id="chart-loading" class="hidden py-8 flex items-center justify-center">
                <i class="fas fa-spinner fa-spin text-[#27124A] mr-2"></i>
                <span class="text-sm text-gray-500">Memuat data...</span>
            </div>
            <div id="chart-empty" class="hidden py-8 text-center">
                <i class="fas fa-chart-line text-2xl text-gray-300 mb-2"></i>
                <p class="text-sm text-gray-400">Belum ada data transaksi</p>
            </div>
        </div>

        <!-- Statistik Member - Simplified -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
            <h3 class="text-sm font-semibold text-gray-800 mb-3">Statistik Member</h3>
            <div class="space-y-3">
                <div>
                    <div class="flex justify-between text-xs mb-1">
                        <span class="text-gray-600">Aktif</span>
                        <span class="font-medium text-gray-800">{{ $stats['active_members'] }} ({{ $stats['total_members'] > 0 ? round(($stats['active_members'] / $stats['total_members']) * 100) : 0 }}%)</span>
                    </div>
                    <div class="w-full bg-gray-100 rounded-full h-1.5">
                        <div class="bg-green-500 h-1.5 rounded-full" style="width: {{ $stats['total_members'] > 0 ? ($stats['active_members'] / $stats['total_members']) * 100 : 0 }}%"></div>
                    </div>
                </div>
                <div>
                    <div class="flex justify-between text-xs mb-1">
                        <span class="text-gray-600">Expired</span>
                        <span class="font-medium text-gray-800">{{ $stats['expired_members'] }} ({{ $stats['total_members'] > 0 ? round(($stats['expired_members'] / $stats['total_members']) * 100) : 0 }}%)</span>
                    </div>
                    <div class="w-full bg-gray-100 rounded-full h-1.5">
                        <div class="bg-red-400 h-1.5 rounded-full" style="width: {{ $stats['total_members'] > 0 ? ($stats['expired_members'] / $stats['total_members']) * 100 : 0 }}%"></div>
                    </div>
                </div>
                <div class="pt-3 border-t border-gray-100">
                    <div class="flex justify-between text-xs">
                        <span class="text-gray-600">Member Baru Bulan Ini</span>
                        <span class="font-medium text-[#27124A]">{{ $stats['new_members'] ?? '0' }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Data Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Recent Members -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="p-4 border-b border-gray-100 flex justify-between items-center">
                <div>
                    <h3 class="text-sm font-semibold text-gray-800">Member Terbaru</h3>
                    <p class="text-xs text-gray-500 mt-0.5">5 member terakhir</p>
                </div>
                <a href="{{ route('admin.members.index') }}" class="text-xs text-[#27124A] hover:underline">
                    Lihat Semua <i class="fas fa-arrow-right ml-1"></i>
                </a>
            </div>
            
            <div class="divide-y divide-gray-100">
                @forelse($recentMembers->take(5) as $member)
                <div class="p-3 hover:bg-gray-50 transition-colors">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="w-7 h-7 bg-[#27124A]/10 rounded-lg flex items-center justify-center mr-2">
                                <i class="fas fa-user text-[#27124A] text-xs"></i>
                            </div>
                            <div>
                                <p class="text-xs font-medium text-gray-800">{{ $member->nama }}</p>
                                <p class="text-xs text-gray-400">{{ $member->kode_member }}</p>
                            </div>
                        </div>
                        <div class="text-right">
                            @if($member->status == 'active' && $member->tgl_expired >= now())
                                <span class="text-xs bg-green-100 text-green-700 px-2 py-0.5 rounded">Aktif</span>
                            @else
                                <span class="text-xs bg-red-100 text-red-600 px-2 py-0.5 rounded">Expired</span>
                            @endif
                        </div>
                    </div>
                </div>
                @empty
                <div class="p-6 text-center text-gray-400 text-sm">
                    <i class="fas fa-user-friends text-2xl mb-2"></i>
                    <p>Belum ada data member</p>
                </div>
                @endforelse
            </div>
        </div>
        
        <!-- Recent Transactions -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="p-4 border-b border-gray-100 flex justify-between items-center">
                <div>
                    <h3 class="text-sm font-semibold text-gray-800">Transaksi Terbaru</h3>
                    <p class="text-xs text-gray-500 mt-0.5">5 transaksi terakhir</p>
                </div>
                <a href="{{ route('admin.transaksi.index') }}" class="text-xs text-[#27124A] hover:underline">
                    Lihat Semua <i class="fas fa-arrow-right ml-1"></i>
                </a>
            </div>
            
            <div class="divide-y divide-gray-100">
                @forelse($recentTransactions->take(5) as $transaction)
                <div class="p-3 hover:bg-gray-50 transition-colors">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="w-7 h-7 bg-[#27124A]/10 rounded-lg flex items-center justify-center mr-2">
                                <i class="fas fa-receipt text-[#27124A] text-xs"></i>
                            </div>
                            <div>
                                <p class="text-xs font-medium text-gray-800">{{ $transaction->nomor_unik }}</p>
                                <p class="text-xs text-gray-400">{{ $transaction->user->nama }}</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="text-xs font-medium text-[#27124A]">Rp {{ number_format($transaction->total_harga, 0, ',', '.') }}</p>
                            <p class="text-xs text-gray-400">{{ $transaction->created_at->format('H:i') }}</p>
                        </div>
                    </div>
                </div>
                @empty
                <div class="p-6 text-center text-gray-400 text-sm">
                    <i class="fas fa-shopping-cart text-2xl mb-2"></i>
                    <p>Belum ada transaksi</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Simple chart period toggle
    const periodButtons = document.querySelectorAll('.period-btn');
    const chartContainer = document.getElementById('chart-container');
    const chartLoading = document.getElementById('chart-loading');
    const chartEmpty = document.getElementById('chart-empty');
    const chartSubtitle = document.getElementById('chart-subtitle');
    
    periodButtons.forEach(btn => {
        btn.addEventListener('click', function() {
            const period = this.dataset.period;
            
            // Update active state
            periodButtons.forEach(b => {
                b.classList.remove('bg-[#27124A]/10', 'text-[#27124A]');
                b.classList.add('text-gray-500', 'hover:bg-gray-50');
            });
            this.classList.remove('text-gray-500', 'hover:bg-gray-50');
            this.classList.add('bg-[#27124A]/10', 'text-[#27124A]');
            
            // Update subtitle
            chartSubtitle.textContent = period === 'week' ? '7 hari terakhir' : 'Per minggu dalam bulan ini';
            
            // Simulate loading (replace with actual fetch)
            chartContainer.classList.add('hidden');
            chartLoading.classList.remove('hidden');
            
            setTimeout(() => {
                chartLoading.classList.add('hidden');
                chartContainer.classList.remove('hidden');
            }, 500);
        });
    });
});
</script>
@endpush