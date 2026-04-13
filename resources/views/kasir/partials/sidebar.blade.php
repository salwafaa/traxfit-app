@php
$navItems = [
    ['route' => 'kasir.dashboard',      'icon' => 'fa-tachometer-alt', 'label' => 'Dashboard'],
    ['route' => 'kasir.transaksi.index','icon' => 'fa-cash-register',  'label' => 'Transaksi'],
    ['route' => 'kasir.member.cek',     'icon' => 'fa-search',         'label' => 'Cek Member'],
    ['route' => 'kasir.checkin.index',  'icon' => 'fa-check-circle',   'label' => 'Check-in Member'],
];

$routePatterns = [
    'kasir.dashboard'       => 'kasir.dashboard',
    'kasir.transaksi.index' => 'kasir.transaksi.*',
    'kasir.member.cek'      => 'kasir.member.*',
    'kasir.checkin.index'   => 'kasir.checkin.*',
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