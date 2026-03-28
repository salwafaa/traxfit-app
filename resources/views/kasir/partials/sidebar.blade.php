<div class="space-y-1 px-3">

    <!-- Dashboard -->
    <a href="{{ route('kasir.dashboard') }}"
       class="nav-item flex items-center {{ request()->routeIs('kasir.dashboard') ? 'text-white bg-gradient-to-r from-primary-light to-secondary active' : 'text-gray-300 hover:text-white hover:bg-primary-light' }} px-3 py-3 rounded-xl transition-all duration-200 mb-2 group nav-tooltip"
       data-tooltip-text="Dashboard"
       data-tooltip="">
        <div class="bg-primary-dark p-2 rounded-lg group-hover:bg-gradient-to-r group-hover:from-secondary group-hover:to-accent transition-all duration-200 flex-shrink-0">
            <i class="fas fa-tachometer-alt w-5 text-center"></i>
        </div>
        <span class="nav-label ml-4 font-medium whitespace-nowrap transition-opacity duration-200">
            Dashboard
        </span>
        @if(request()->routeIs('kasir.dashboard'))
            <i class="nav-chevron fas fa-chevron-right ml-auto text-accent"></i>
        @endif
    </a>

    <!-- Transaksi Baru -->
    <a href="{{ route('kasir.transaksi.index') }}"
       class="nav-item flex items-center {{ request()->routeIs('kasir.transaksi.*') ? 'text-white bg-gradient-to-r from-primary-light to-secondary active' : 'text-gray-300 hover:text-white hover:bg-primary-light' }} px-3 py-3 rounded-xl transition-all duration-200 mb-2 group nav-tooltip"
       data-tooltip-text="Transaksi Baru"
       data-tooltip="">
        <div class="bg-primary-dark p-2 rounded-lg group-hover:bg-gradient-to-r group-hover:from-secondary group-hover:to-accent transition-all duration-200 flex-shrink-0">
            <i class="fas fa-cash-register w-5 text-center"></i>
        </div>
        <span class="nav-label ml-4 font-medium whitespace-nowrap transition-opacity duration-200">
            Transaksi Baru
        </span>
        @if(request()->routeIs('kasir.transaksi.*'))
            <i class="nav-chevron fas fa-chevron-right ml-auto text-accent"></i>
        @endif
    </a>

    <!-- Cek Member -->
    <a href="{{ route('kasir.member.cek') }}"
       class="nav-item flex items-center {{ request()->routeIs('kasir.member.*') ? 'text-white bg-gradient-to-r from-primary-light to-secondary active' : 'text-gray-300 hover:text-white hover:bg-primary-light' }} px-3 py-3 rounded-xl transition-all duration-200 mb-2 group nav-tooltip"
       data-tooltip-text="Cek Member"
       data-tooltip="">
        <div class="bg-primary-dark p-2 rounded-lg group-hover:bg-gradient-to-r group-hover:from-secondary group-hover:to-accent transition-all duration-200 flex-shrink-0">
            <i class="fas fa-search w-5 text-center"></i>
        </div>
        <span class="nav-label ml-4 font-medium whitespace-nowrap transition-opacity duration-200">
            Cek Member
        </span>
        @if(request()->routeIs('kasir.member.*'))
            <i class="nav-chevron fas fa-chevron-right ml-auto text-accent"></i>
        @endif
    </a>

    <!-- Check-in Member -->
    <a href="{{ route('kasir.checkin.index') }}"
       class="nav-item flex items-center {{ request()->routeIs('kasir.checkin.*') ? 'text-white bg-gradient-to-r from-primary-light to-secondary active' : 'text-gray-300 hover:text-white hover:bg-primary-light' }} px-3 py-3 rounded-xl transition-all duration-200 mb-2 group nav-tooltip"
       data-tooltip-text="Check-in Member"
       data-tooltip="">
        <div class="bg-primary-dark p-2 rounded-lg group-hover:bg-gradient-to-r group-hover:from-secondary group-hover:to-accent transition-all duration-200 flex-shrink-0">
            <i class="fas fa-check-circle w-5 text-center"></i>
        </div>
        <span class="nav-label ml-4 font-medium whitespace-nowrap transition-opacity duration-200">
            Check-in Member
        </span>
        @if(request()->routeIs('kasir.checkin.*'))
            <i class="nav-chevron fas fa-chevron-right ml-auto text-accent"></i>
        @endif
    </a>

    <!-- Data Transaksi -->
    <a href="{{ route('kasir.report.transaksi') }}"
       class="nav-item flex items-center {{ request()->routeIs('kasir.report.transaksi') ? 'text-white bg-gradient-to-r from-primary-light to-secondary active' : 'text-gray-300 hover:text-white hover:bg-primary-light' }} px-3 py-3 rounded-xl transition-all duration-200 mb-2 group nav-tooltip"
       data-tooltip-text="Data Transaksi"
       data-tooltip="">
        <div class="bg-primary-dark p-2 rounded-lg group-hover:bg-gradient-to-r group-hover:from-secondary group-hover:to-accent transition-all duration-200 flex-shrink-0">
            <i class="fas fa-history w-5 text-center"></i>
        </div>
        <span class="nav-label ml-4 font-medium whitespace-nowrap transition-opacity duration-200">
            Data Transaksi
        </span>
        @if(request()->routeIs('kasir.report.transaksi'))
            <i class="nav-chevron fas fa-chevron-right ml-auto text-accent"></i>
        @endif
    </a>

    <!-- Cetak Ulang -->
    <a href="{{ route('kasir.report.cetakUlang') }}"
       class="nav-item flex items-center {{ request()->routeIs('kasir.report.cetakUlang') ? 'text-white bg-gradient-to-r from-primary-light to-secondary active' : 'text-gray-300 hover:text-white hover:bg-primary-light' }} px-3 py-3 rounded-xl transition-all duration-200 mb-2 group nav-tooltip"
       data-tooltip-text="Cetak Ulang"
       data-tooltip="">
        <div class="bg-primary-dark p-2 rounded-lg group-hover:bg-gradient-to-r group-hover:from-secondary group-hover:to-accent transition-all duration-200 flex-shrink-0">
            <i class="fas fa-print w-5 text-center"></i>
        </div>
        <span class="nav-label ml-4 font-medium whitespace-nowrap transition-opacity duration-200">
            Cetak Ulang
        </span>
        @if(request()->routeIs('kasir.report.cetakUlang'))
            <i class="nav-chevron fas fa-chevron-right ml-auto text-accent"></i>
        @endif
    </a>
</div>