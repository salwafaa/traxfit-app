<div class="space-y-1 px-3">

    <!-- Dashboard -->
    <a href="{{ route('owner.dashboard') }}"
       class="nav-item flex items-center {{ request()->routeIs('owner.dashboard') ? 'text-white bg-gradient-to-r from-primary-light to-secondary active' : 'text-gray-300 hover:text-white hover:bg-primary-light' }} px-3 py-3 rounded-xl transition-all duration-200 mb-2 group nav-tooltip"
       data-tooltip-text="Dashboard"
       data-tooltip="">
        <div class="bg-primary-dark p-2 rounded-lg group-hover:bg-gradient-to-r group-hover:from-secondary group-hover:to-accent transition-all duration-200 flex-shrink-0">
            <i class="fas fa-tachometer-alt w-5 text-center"></i>
        </div>
        <span class="nav-label ml-4 font-medium whitespace-nowrap transition-opacity duration-200">
            Dashboard
        </span>
        @if(request()->routeIs('owner.dashboard'))
            <i class="nav-chevron fas fa-chevron-right ml-auto text-accent"></i>
        @endif
    </a>

    <!-- Laporan Transaksi -->
    <a href="{{ route('owner.laporan.transaksi') }}"
       class="nav-item flex items-center {{ request()->routeIs('owner.laporan.transaksi') ? 'text-white bg-gradient-to-r from-primary-light to-secondary active' : 'text-gray-300 hover:text-white hover:bg-primary-light' }} px-3 py-3 rounded-xl transition-all duration-200 mb-2 group nav-tooltip"
       data-tooltip-text="Laporan Transaksi"
       data-tooltip="">
        <div class="bg-primary-dark p-2 rounded-lg group-hover:bg-gradient-to-r group-hover:from-secondary group-hover:to-accent transition-all duration-200 flex-shrink-0">
            <i class="fas fa-chart-bar w-5 text-center"></i>
        </div>
        <span class="nav-label ml-4 font-medium whitespace-nowrap transition-opacity duration-200">
            Laporan Transaksi
        </span>
        @if(request()->routeIs('owner.laporan.transaksi'))
            <i class="nav-chevron fas fa-chevron-right ml-auto text-accent"></i>
        @endif
    </a>

    <!-- Laporan Stok -->
    <a href="{{ route('owner.laporan.stok') }}"
       class="nav-item flex items-center {{ request()->routeIs('owner.laporan.stok') ? 'text-white bg-gradient-to-r from-primary-light to-secondary active' : 'text-gray-300 hover:text-white hover:bg-primary-light' }} px-3 py-3 rounded-xl transition-all duration-200 mb-2 group nav-tooltip"
       data-tooltip-text="Laporan Stok"
       data-tooltip="">
        <div class="bg-primary-dark p-2 rounded-lg group-hover:bg-gradient-to-r group-hover:from-secondary group-hover:to-accent transition-all duration-200 flex-shrink-0">
            <i class="fas fa-warehouse w-5 text-center"></i>
        </div>
        <span class="nav-label ml-4 font-medium whitespace-nowrap transition-opacity duration-200">
            Laporan Stok
        </span>
        @if(request()->routeIs('owner.laporan.stok'))
            <i class="nav-chevron fas fa-chevron-right ml-auto text-accent"></i>
        @endif
    </a>

    <!-- Aktivitas User -->
    <a href="{{ route('owner.laporan.aktivitas') }}"
       class="nav-item flex items-center {{ request()->routeIs('owner.laporan.aktivitas') ? 'text-white bg-gradient-to-r from-primary-light to-secondary active' : 'text-gray-300 hover:text-white hover:bg-primary-light' }} px-3 py-3 rounded-xl transition-all duration-200 mb-2 group nav-tooltip"
       data-tooltip-text="Aktivitas User"
       data-tooltip="">
        <div class="bg-primary-dark p-2 rounded-lg group-hover:bg-gradient-to-r group-hover:from-secondary group-hover:to-accent transition-all duration-200 flex-shrink-0">
            <i class="fas fa-history w-5 text-center"></i>
        </div>
        <span class="nav-label ml-4 font-medium whitespace-nowrap transition-opacity duration-200">
            Aktivitas User
        </span>
        @if(request()->routeIs('owner.laporan.aktivitas'))
            <i class="nav-chevron fas fa-chevron-right ml-auto text-accent"></i>
        @endif
    </a>

    <!-- Member Aktif -->
    <a href="{{ route('owner.laporan.member') }}"
       class="nav-item flex items-center {{ request()->routeIs('owner.laporan.member') ? 'text-white bg-gradient-to-r from-primary-light to-secondary active' : 'text-gray-300 hover:text-white hover:bg-primary-light' }} px-3 py-3 rounded-xl transition-all duration-200 mb-2 group nav-tooltip"
       data-tooltip-text="Member Aktif"
       data-tooltip="">
        <div class="bg-primary-dark p-2 rounded-lg group-hover:bg-gradient-to-r group-hover:from-secondary group-hover:to-accent transition-all duration-200 flex-shrink-0">
            <i class="fas fa-user-check w-5 text-center"></i>
        </div>
        <span class="nav-label ml-4 font-medium whitespace-nowrap transition-opacity duration-200">
            Member Aktif
        </span>
        @if(request()->routeIs('owner.laporan.member'))
            <i class="nav-chevron fas fa-chevron-right ml-auto text-accent"></i>
        @endif
    </a>
</div>