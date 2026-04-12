{{-- resources/views/owner/partials/sidebar.blade.php --}}

@php
$navItems = [
    ['route' => 'owner.dashboard',          'icon' => 'fa-tachometer-alt', 'label' => 'Dashboard'],
    ['route' => 'owner.users.index',         'icon' => 'fa-users-cog',      'label' => 'Manage Users'],
    ['route' => 'owner.laporan.transaksi',   'icon' => 'fa-chart-bar',      'label' => 'Laporan Transaksi'],
    ['route' => 'owner.laporan.stok',        'icon' => 'fa-warehouse',      'label' => 'Laporan Stok'],
    ['route' => 'owner.laporan.aktivitas',   'icon' => 'fa-history',        'label' => 'Aktivitas User'],
    ['route' => 'owner.laporan.member',      'icon' => 'fa-user-check',     'label' => 'Member Aktif'],
];

$routePatterns = [
    'owner.dashboard'         => 'owner.dashboard',
    'owner.users.index'       => 'owner.users.*',
    'owner.laporan.transaksi' => 'owner.laporan.transaksi*',
    'owner.laporan.stok'      => 'owner.laporan.stok',
    'owner.laporan.aktivitas' => 'owner.laporan.aktivitas',
    'owner.laporan.member'    => 'owner.laporan.member',
];
@endphp

@foreach($navItems as $item)
@php $isActive = request()->routeIs($routePatterns[$item['route']] ?? $item['route']); @endphp
<a href="{{ route($item['route']) }}"
   class="nav-item flex items-center gap-3 px-3 py-2.5 rounded-xl mb-1 relative
          {{ $isActive ? 'active text-white' : 'text-gray-300 hover:text-white hover:bg-primary-light' }}">

    <div class="nav-icon-wrap flex-shrink-0 w-9 h-9 rounded-lg flex items-center justify-center transition-all duration-200
                {{ $isActive ? 'bg-accent/30' : 'bg-primary-dark' }}">
        <i class="fas {{ $item['icon'] }} text-sm {{ $isActive ? 'text-accent' : 'text-gray-400' }}"></i>
    </div>

    <span class="sb-label font-medium text-sm whitespace-nowrap overflow-hidden">{{ $item['label'] }}</span>

    @if($isActive)
        <i class="sb-chevron fas fa-chevron-right ml-auto text-accent text-xs"></i>
    @endif

    <span class="sb-tooltip">{{ $item['label'] }}</span>
</a>
@endforeach