{{-- resources/views/admin/partials/sidebar.blade.php --}}

@php
$navItems = [
    ['route' => 'admin.dashboard',      'icon' => 'fa-tachometer-alt',  'label' => 'Dashboard'],
    ['route' => 'admin.transaksi.index','icon' => 'fa-cash-register',   'label' => 'Kelola Transaksi'],
    ['route' => 'admin.users.index',    'icon' => 'fa-users',           'label' => 'Kelola User'],
    ['route' => 'admin.products.index', 'icon' => 'fa-box',             'label' => 'Kelola Produk'],
    ['route' => 'admin.categories.index','icon'=> 'fa-tags',            'label' => 'Kelola Kategori'],
    ['route' => 'admin.packages.index', 'icon' => 'fa-id-card',         'label' => 'Kelola Paket'],
    ['route' => 'admin.members.index',  'icon' => 'fa-user-friends',    'label' => 'Kelola Member'],
    ['route' => 'admin.stock.index',    'icon' => 'fa-warehouse',       'label' => 'Kelola Stok'],
    ['route' => 'admin.settings.index', 'icon' => 'fa-cog',             'label' => 'Pengaturan Gym'],
];

$routePatterns = [
    'admin.dashboard'       => 'admin.dashboard',
    'admin.transaksi.index' => 'admin.transaksi.*',
    'admin.users.index'     => 'admin.users.*',
    'admin.products.index'  => 'admin.products.*',
    'admin.categories.index'=> 'admin.categories.*',
    'admin.packages.index'  => 'admin.packages.*',
    'admin.members.index'   => 'admin.members.*',
    'admin.stock.index'     => 'admin.stock.*',
    'admin.settings.index'  => 'admin.settings.*',
];
@endphp

@foreach($navItems as $item)
@php $isActive = request()->routeIs($routePatterns[$item['route']] ?? $item['route']); @endphp
<a href="{{ route($item['route']) }}"
   class="nav-item flex items-center gap-3 px-3 py-2.5 rounded-xl mb-1 relative
          {{ $isActive ? 'active text-white' : 'text-gray-300 hover:text-white hover:bg-primary-light' }}">

    {{-- Icon --}}
    <div class="nav-icon-wrap flex-shrink-0 w-9 h-9 rounded-lg flex items-center justify-center transition-all duration-200
                {{ $isActive ? 'bg-accent/30' : 'bg-primary-dark group-hover:bg-secondary/40' }}">
        <i class="fas {{ $item['icon'] }} text-sm {{ $isActive ? 'text-accent' : 'text-gray-400' }}"></i>
    </div>

    {{-- Label --}}
    <span class="sb-label font-medium text-sm whitespace-nowrap overflow-hidden">{{ $item['label'] }}</span>

    {{-- Chevron aktif --}}
    @if($isActive)
        <i class="sb-chevron fas fa-chevron-right ml-auto text-accent text-xs"></i>
    @endif

    {{-- Tooltip (muncul hanya saat collapsed) --}}
    <span class="sb-tooltip">{{ $item['label'] }}</span>
</a>
@endforeach