@extends('layouts.app')

@section('title', 'Dashboard Owner')
@section('page-title', 'Dashboard Owner')

@section('sidebar')
@include('owner.partials.sidebar')
@endsection

@section('content')
<div class="space-y-6">
    <!-- Welcome Message - Clean and Simple -->
    <div class="bg-gradient-to-r from-[#27124A] to-[#3a1d6b] rounded-2xl shadow-lg overflow-hidden">
        <div class="p-6 md:p-8">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-xl md:text-2xl font-bold text-white mb-2">
                        Selamat Datang, {{ Auth::user()->nama }}! 👋
                    </h2>
                    <p class="text-purple-200 text-sm md:text-base">
                        Anda login sebagai <span class="font-semibold text-white">Owner</span>
                    </p>
                    <div class="flex items-center mt-3 text-purple-200 text-xs md:text-sm">
                        <i class="fas fa-calendar-alt mr-2"></i>
                        <span>{{ now()->translatedFormat('l, d F Y - H:i') }}</span>
                    </div>
                </div>
                <div class="hidden md:block">
                    <div class="w-20 h-20 bg-white/10 rounded-2xl flex items-center justify-center">
                        <i class="fas fa-store text-white text-3xl"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Key Stats - Only 4 Most Important Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <!-- Pendapatan Bulan Ini -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs text-gray-500 uppercase tracking-wider">Pendapatan Bulan Ini</p>
                    <p class="text-2xl font-bold text-gray-800 mt-1">Rp {{ number_format($pendapatanBulanIni, 0, ',', '.') }}</p>
                </div>
                <div class="w-10 h-10 bg-blue-50 rounded-lg flex items-center justify-center">
                    <i class="fas fa-money-bill-wave text-[#27124A] text-lg"></i>
                </div>
            </div>
            <div class="mt-3 text-xs text-gray-500">
                <i class="fas fa-circle text-blue-500 text-[8px] mr-1"></i> Bulan {{ now()->format('F Y') }}
            </div>
        </div>

        <!-- Member Aktif -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs text-gray-500 uppercase tracking-wider">Member Aktif</p>
                    <p class="text-2xl font-bold text-gray-800 mt-1">{{ $memberAktif }}</p>
                </div>
                <div class="w-10 h-10 bg-green-50 rounded-lg flex items-center justify-center">
                    <i class="fas fa-users text-[#27124A] text-lg"></i>
                </div>
            </div>
            <div class="mt-3 text-xs text-gray-500">
                <i class="fas fa-circle text-green-500 text-[8px] mr-1"></i> Dari {{ $totalMember }} total member
            </div>
        </div>

        <!-- Transaksi Bulan Ini -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs text-gray-500 uppercase tracking-wider">Transaksi Bulan Ini</p>
                    <p class="text-2xl font-bold text-gray-800 mt-1">{{ $transaksiBulanIni }}</p>
                </div>
                <div class="w-10 h-10 bg-purple-50 rounded-lg flex items-center justify-center">
                    <i class="fas fa-shopping-cart text-[#27124A] text-lg"></i>
                </div>
            </div>
            <div class="mt-3 text-xs text-gray-500">
                <i class="fas fa-circle text-purple-500 text-[8px] mr-1"></i> Visit: {{ $visitHariIni }} | Member Baru: {{ $membershipBaru }}
            </div>
        </div>

        <!-- Produk Tersedia -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs text-gray-500 uppercase tracking-wider">Produk Tersedia</p>
                    <p class="text-2xl font-bold text-gray-800 mt-1">{{ $produkTersedia }}</p>
                </div>
                <div class="w-10 h-10 bg-yellow-50 rounded-lg flex items-center justify-center">
                    <i class="fas fa-box text-[#27124A] text-lg"></i>
                </div>
            </div>
            <div class="mt-3 text-xs text-gray-500">
                <i class="fas fa-circle text-yellow-500 text-[8px] mr-1"></i> Siap jual
            </div>
        </div>
    </div>

    <!-- Charts Row -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Grafik Pendapatan -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h3 class="text-sm font-semibold text-gray-800">Grafik Pendapatan</h3>
                    <p class="text-xs text-gray-500 mt-1">7 hari terakhir</p>
                </div>
                <div class="w-8 h-8 bg-blue-50 rounded-lg flex items-center justify-center">
                    <i class="fas fa-chart-line text-[#27124A] text-sm"></i>
                </div>
            </div>
            <div class="h-48">
                <canvas id="revenueChart"></canvas>
            </div>
        </div>

        <!-- Statistik Member - Simplified -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h3 class="text-sm font-semibold text-gray-800">Statistik Member</h3>
                    <p class="text-xs text-gray-500 mt-1">Aktif vs Expired</p>
                </div>
                <div class="w-8 h-8 bg-green-50 rounded-lg flex items-center justify-center">
                    <i class="fas fa-pie-chart text-[#27124A] text-sm"></i>
                </div>
            </div>
            <div class="space-y-3">
                <div>
                    <div class="flex justify-between text-xs mb-1">
                        <span class="text-gray-600">Member Aktif</span>
                        <span class="font-medium text-gray-800">{{ $memberAktif }} ({{ $totalMember > 0 ? round(($memberAktif / $totalMember) * 100) : 0 }}%)</span>
                    </div>
                    <div class="w-full bg-gray-100 rounded-full h-1.5">
                        @php $aktifPersen = $totalMember > 0 ? ($memberAktif / $totalMember) * 100 : 0 @endphp
                        <div class="bg-green-500 h-1.5 rounded-full" style="width: {{ $aktifPersen }}%"></div>
                    </div>
                </div>
                <div>
                    <div class="flex justify-between text-xs mb-1">
                        <span class="text-gray-600">Member Expired</span>
                        <span class="font-medium text-gray-800">{{ $memberExpired }} ({{ $totalMember > 0 ? round(($memberExpired / $totalMember) * 100) : 0 }}%)</span>
                    </div>
                    <div class="w-full bg-gray-100 rounded-full h-1.5">
                        @php $expiredPersen = $totalMember > 0 ? ($memberExpired / $totalMember) * 100 : 0 @endphp
                        <div class="bg-red-500 h-1.5 rounded-full" style="width: {{ $expiredPersen }}%"></div>
                    </div>
                </div>
                <div class="pt-3 border-t border-gray-100">
                    <div class="flex justify-between text-xs">
                        <span class="text-gray-600">Total Member</span>
                        <span class="font-medium text-gray-800">{{ $totalMember }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Top 5 Produk Terlaris -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="p-4 border-b border-gray-100">
                <div class="flex justify-between items-center">
                    <div>
                        <h3 class="text-sm font-semibold text-gray-800">Top 5 Produk Terlaris</h3>
                        <p class="text-xs text-gray-500 mt-0.5">Bulan {{ now()->format('F Y') }}</p>
                    </div>
                    <div class="w-8 h-8 bg-yellow-50 rounded-lg flex items-center justify-center">
                        <i class="fas fa-crown text-[#27124A] text-sm"></i>
                    </div>
                </div>
            </div>
            
            <div class="p-4">
                @if($topProducts->count() > 0)
                    <div class="space-y-3">
                        @foreach($topProducts->take(5) as $index => $product)
                        <div>
                            <div class="flex items-center justify-between mb-1">
                                <div class="flex items-center">
                                    <span class="w-5 h-5 {{ $index == 0 ? 'bg-yellow-100 text-yellow-600' : ($index == 1 ? 'bg-gray-100 text-gray-600' : ($index == 2 ? 'bg-orange-100 text-orange-600' : 'bg-blue-50 text-blue-600')) }} rounded-full flex items-center justify-center text-xs font-bold mr-2">
                                        {{ $index + 1 }}
                                    </span>
                                    <span class="text-xs font-medium text-gray-700">{{ $product->nama_produk }}</span>
                                </div>
                                <span class="text-xs font-semibold text-gray-800">{{ $product->total_qty }} terjual</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-1">
                                @php $maxQty = $topProducts->max('total_qty') ?: 1 @endphp
                                <div class="bg-[#27124A] h-1 rounded-full" style="width: {{ ($product->total_qty / $maxQty) * 100 }}%"></div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-6">
                        <i class="fas fa-box-open text-2xl text-gray-300 mb-2"></i>
                        <p class="text-xs text-gray-400">Belum ada data penjualan</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Transaksi Terbaru -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="p-4 border-b border-gray-100 flex justify-between items-center">
                <div>
                    <h3 class="text-sm font-semibold text-gray-800">Transaksi Terbaru</h3>
                    <p class="text-xs text-gray-500 mt-0.5">5 transaksi terakhir</p>
                </div>
                <div class="w-8 h-8 bg-purple-50 rounded-lg flex items-center justify-center">
                    <i class="fas fa-history text-[#27124A] text-sm"></i>
                </div>
            </div>
            
            <div class="divide-y divide-gray-100">
                @forelse($recentTransactions->take(5) as $transaction)
                <div class="p-3 hover:bg-gray-50 transition-colors">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="w-7 h-7 bg-purple-50 rounded-lg flex items-center justify-center mr-2">
                                <i class="fas fa-receipt text-[#27124A] text-xs"></i>
                            </div>
                            <div>
                                <p class="text-xs font-medium text-gray-800">{{ $transaction->nomor_unik }}</p>
                                <p class="text-xs text-gray-400">{{ $transaction->user->nama ?? 'N/A' }}</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="text-xs font-medium text-[#27124A]">Rp {{ number_format($transaction->total_harga, 0, ',', '.') }}</p>
                            <p class="text-xs text-gray-400">{{ $transaction->created_at->format('H:i') }}</p>
                        </div>
                    </div>
                </div>
                @empty
                <div class="p-6 text-center">
                    <i class="fas fa-shopping-cart text-2xl text-gray-300 mb-2"></i>
                    <p class="text-xs text-gray-400">Belum ada transaksi</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('revenueChart')?.getContext('2d');
    if (!ctx) return;
    
    const chartData = @json($last7Days ?? []);
    
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: chartData.map(item => item.date),
            datasets: [{
                data: chartData.map(item => item.total / 1000),
                borderColor: '#27124A',
                backgroundColor: 'rgba(39, 18, 74, 0.1)',
                borderWidth: 2,
                fill: true,
                tension: 0.4,
                pointBackgroundColor: '#27124A',
                pointBorderColor: '#fff',
                pointBorderWidth: 2,
                pointRadius: 3
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return 'Rp ' + new Intl.NumberFormat('id-ID').format(context.raw * 1000);
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: { display: true, color: 'rgba(0, 0, 0, 0.05)' },
                    ticks: { callback: value => 'Rp ' + value + 'k' }
                },
                x: { grid: { display: false } }
            }
        }
    });
});
</script>
@endpush