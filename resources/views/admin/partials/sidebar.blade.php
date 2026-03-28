@php
    $isCollapsed = false; // Akan di-handle oleh Alpine.js
@endphp

<div class="space-y-1 px-3">

    <!-- Dashboard -->
    <a href="{{ route('admin.dashboard') }}"
       class="nav-item flex items-center {{ request()->routeIs('admin.dashboard') ? 'text-white bg-gradient-to-r from-primary-light to-secondary active' : 'text-gray-300 hover:text-white hover:bg-primary-light' }} px-3 py-3 rounded-xl transition-all duration-200 mb-2 group nav-tooltip"
       data-tooltip-text="Dashboard"
       data-tooltip="">
        <div class="bg-primary-dark p-2 rounded-lg group-hover:bg-gradient-to-r group-hover:from-secondary group-hover:to-accent transition-all duration-200 flex-shrink-0">
            <i class="fas fa-tachometer-alt w-5 text-center"></i>
        </div>
        <span class="nav-label ml-4 font-medium whitespace-nowrap transition-opacity duration-200">
            Dashboard
        </span>
        @if(request()->routeIs('admin.dashboard'))
            <i class="nav-chevron fas fa-chevron-right ml-auto text-accent"></i>
        @endif
    </a>

    <!-- Kelola Transaksi -->
    <a href="{{ route('admin.transaksi.index') }}"
       class="nav-item flex items-center {{ request()->routeIs('admin.transaksi.*') ? 'text-white bg-gradient-to-r from-primary-light to-secondary active' : 'text-gray-300 hover:text-white hover:bg-primary-light' }} px-3 py-3 rounded-xl transition-all duration-200 mb-2 group nav-tooltip"
       data-tooltip-text="Kelola Transaksi"
       data-tooltip="">
        <div class="bg-primary-dark p-2 rounded-lg group-hover:bg-gradient-to-r group-hover:from-secondary group-hover:to-accent transition-all duration-200 flex-shrink-0">
            <i class="fas fa-cash-register w-5 text-center"></i>
        </div>
        <span class="nav-label ml-4 font-medium whitespace-nowrap transition-opacity duration-200">
            Kelola Transaksi
        </span>
        @if(request()->routeIs('admin.transaksi.*'))
            <i class="nav-chevron fas fa-chevron-right ml-auto text-accent"></i>
        @endif
    </a>

    <!-- Kelola User -->
    <a href="{{ route('admin.users.index') }}"
       class="nav-item flex items-center {{ request()->routeIs('admin.users.*') ? 'text-white bg-gradient-to-r from-primary-light to-secondary active' : 'text-gray-300 hover:text-white hover:bg-primary-light' }} px-3 py-3 rounded-xl transition-all duration-200 mb-2 group nav-tooltip"
       data-tooltip-text="Kelola User"
       data-tooltip="">
        <div class="bg-primary-dark p-2 rounded-lg group-hover:bg-gradient-to-r group-hover:from-secondary group-hover:to-accent transition-all duration-200 flex-shrink-0">
            <i class="fas fa-users w-5 text-center"></i>
        </div>
        <span class="nav-label ml-4 font-medium whitespace-nowrap transition-opacity duration-200">
            Kelola User
        </span>
        @if(request()->routeIs('admin.users.*'))
            <i class="nav-chevron fas fa-chevron-right ml-auto text-accent"></i>
        @endif
    </a>

    <!-- Kelola Produk -->
    <a href="{{ route('admin.products.index') }}"
       class="nav-item flex items-center {{ request()->routeIs('admin.products.*') ? 'text-white bg-gradient-to-r from-primary-light to-secondary active' : 'text-gray-300 hover:text-white hover:bg-primary-light' }} px-3 py-3 rounded-xl transition-all duration-200 mb-2 group nav-tooltip"
       data-tooltip-text="Kelola Produk"
       data-tooltip="">
        <div class="bg-primary-dark p-2 rounded-lg group-hover:bg-gradient-to-r group-hover:from-secondary group-hover:to-accent transition-all duration-200 flex-shrink-0">
            <i class="fas fa-box w-5 text-center"></i>
        </div>
        <span class="nav-label ml-4 font-medium whitespace-nowrap transition-opacity duration-200">
            Kelola Produk
        </span>
        @if(request()->routeIs('admin.products.*'))
            <i class="nav-chevron fas fa-chevron-right ml-auto text-accent"></i>
        @endif
    </a>

    <!-- Kelola Kategori -->
    <a href="{{ route('admin.categories.index') }}"
       class="nav-item flex items-center {{ request()->routeIs('admin.categories.*') ? 'text-white bg-gradient-to-r from-primary-light to-secondary active' : 'text-gray-300 hover:text-white hover:bg-primary-light' }} px-3 py-3 rounded-xl transition-all duration-200 mb-2 group nav-tooltip"
       data-tooltip-text="Kelola Kategori"
       data-tooltip="">
        <div class="bg-primary-dark p-2 rounded-lg group-hover:bg-gradient-to-r group-hover:from-secondary group-hover:to-accent transition-all duration-200 flex-shrink-0">
            <i class="fas fa-tags w-5 text-center"></i>
        </div>
        <span class="nav-label ml-4 font-medium whitespace-nowrap transition-opacity duration-200">
            Kelola Kategori
        </span>
        @if(request()->routeIs('admin.categories.*'))
            <i class="nav-chevron fas fa-chevron-right ml-auto text-accent"></i>
        @endif
    </a>

    <!-- Kelola Paket Membership -->
    <a href="{{ route('admin.packages.index') }}"
       class="nav-item flex items-center {{ request()->routeIs('admin.packages.*') ? 'text-white bg-gradient-to-r from-primary-light to-secondary active' : 'text-gray-300 hover:text-white hover:bg-primary-light' }} px-3 py-3 rounded-xl transition-all duration-200 mb-2 group nav-tooltip"
       data-tooltip-text="Kelola Paket"
       data-tooltip="">
        <div class="bg-primary-dark p-2 rounded-lg group-hover:bg-gradient-to-r group-hover:from-secondary group-hover:to-accent transition-all duration-200 flex-shrink-0">
            <i class="fas fa-id-card w-5 text-center"></i>
        </div>
        <span class="nav-label ml-4 font-medium whitespace-nowrap transition-opacity duration-200">
            Kelola Paket
        </span>
        @if(request()->routeIs('admin.packages.*'))
            <i class="nav-chevron fas fa-chevron-right ml-auto text-accent"></i>
        @endif
    </a>

    <!-- Kelola Member -->
    <a href="{{ route('admin.members.index') }}"
       class="nav-item flex items-center {{ request()->routeIs('admin.members.*') ? 'text-white bg-gradient-to-r from-primary-light to-secondary active' : 'text-gray-300 hover:text-white hover:bg-primary-light' }} px-3 py-3 rounded-xl transition-all duration-200 mb-2 group nav-tooltip"
       data-tooltip-text="Kelola Member"
       data-tooltip="">
        <div class="bg-primary-dark p-2 rounded-lg group-hover:bg-gradient-to-r group-hover:from-secondary group-hover:to-accent transition-all duration-200 flex-shrink-0">
            <i class="fas fa-user-friends w-5 text-center"></i>
        </div>
        <span class="nav-label ml-4 font-medium whitespace-nowrap transition-opacity duration-200">
            Kelola Member
        </span>
        @if(request()->routeIs('admin.members.*'))
            <i class="nav-chevron fas fa-chevron-right ml-auto text-accent"></i>
        @endif
    </a>

    <!-- Kelola Stok -->
    <a href="{{ route('admin.stock.index') }}"
       class="nav-item flex items-center {{ request()->routeIs('admin.stock.*') ? 'text-white bg-gradient-to-r from-primary-light to-secondary active' : 'text-gray-300 hover:text-white hover:bg-primary-light' }} px-3 py-3 rounded-xl transition-all duration-200 mb-2 group nav-tooltip"
       data-tooltip-text="Kelola Stok"
       data-tooltip="">
        <div class="bg-primary-dark p-2 rounded-lg group-hover:bg-gradient-to-r group-hover:from-secondary group-hover:to-accent transition-all duration-200 flex-shrink-0">
            <i class="fas fa-warehouse w-5 text-center"></i>
        </div>
        <span class="nav-label ml-4 font-medium whitespace-nowrap transition-opacity duration-200">
            Kelola Stok
        </span>
        @if(request()->routeIs('admin.stock.*'))
            <i class="nav-chevron fas fa-chevron-right ml-auto text-accent"></i>
        @endif
    </a>

    <!-- Settings / Pengaturan -->
    <a href="{{ route('admin.settings.index') }}"
       class="nav-item flex items-center {{ request()->routeIs('admin.settings.*') ? 'text-white bg-gradient-to-r from-primary-light to-secondary active' : 'text-gray-300 hover:text-white hover:bg-primary-light' }} px-3 py-3 rounded-xl transition-all duration-200 mb-2 group nav-tooltip"
       data-tooltip-text="Pengaturan Gym"
       data-tooltip="">
        <div class="bg-primary-dark p-2 rounded-lg group-hover:bg-gradient-to-r group-hover:from-secondary group-hover:to-accent transition-all duration-200 flex-shrink-0">
            <i class="fas fa-cog w-5 text-center"></i>
        </div>
        <span class="nav-label ml-4 font-medium whitespace-nowrap transition-opacity duration-200">
            Pengaturan Gym
        </span>
        @if(request()->routeIs('admin.settings.*'))
            <i class="nav-chevron fas fa-chevron-right ml-auto text-accent"></i>
        @endif
    </a>
</div>