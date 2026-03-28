<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\KasirController;
use App\Http\Controllers\OwnerController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\MembershipPackageController;
use App\Http\Controllers\Admin\MemberController as AdminMemberController;
use App\Http\Controllers\Admin\StockController;
use App\Http\Controllers\Kasir\TransactionController as KasirTransactionController;
use App\Http\Controllers\Kasir\MemberController as KasirMemberController;
use App\Http\Controllers\Kasir\CheckinController as KasirCheckinController;
use App\Http\Controllers\Kasir\ReportController as KasirReportController;
use App\Http\Controllers\Owner\ReportController as OwnerReportController;

// Route Auth
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Route untuk role admin
Route::middleware(['auth', 'checkRole:admin'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    
    // API Chart Data
    Route::get('/chart-data/{period}', [AdminController::class, 'chartData'])->name('chart-data');
    
    // Kelola User
    Route::prefix('users')->name('users.')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('index');
        Route::get('/create', [UserController::class, 'create'])->name('create');
        Route::post('/', [UserController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [UserController::class, 'edit'])->name('edit');
        Route::put('/{id}', [UserController::class, 'update'])->name('update');
        Route::delete('/{id}', [UserController::class, 'destroy'])->name('destroy');
        Route::put('/{id}/status', [UserController::class, 'toggleStatus'])->name('toggleStatus');
    });
    
    // Kelola Produk
    Route::prefix('products')->name('products.')->group(function () {
        Route::get('/', [ProductController::class, 'index'])->name('index');
        Route::get('/create', [ProductController::class, 'create'])->name('create');
        Route::post('/', [ProductController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [ProductController::class, 'edit'])->name('edit');
        Route::put('/{id}', [ProductController::class, 'update'])->name('update');
        Route::delete('/{id}', [ProductController::class, 'destroy'])->name('destroy');
        Route::put('/{id}/status', [ProductController::class, 'toggleStatus'])->name('toggleStatus');
    });
    
    // Kelola Kategori
    Route::prefix('categories')->name('categories.')->group(function () {
        Route::get('/', [CategoryController::class, 'index'])->name('index');
        Route::get('/create', [CategoryController::class, 'create'])->name('create');
        Route::post('/', [CategoryController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [CategoryController::class, 'edit'])->name('edit');
        Route::put('/{id}', [CategoryController::class, 'update'])->name('update');
        Route::delete('/{id}', [CategoryController::class, 'destroy'])->name('destroy');
    });
    
    // Kelola Paket Membership
    Route::prefix('membership-packages')->name('packages.')->group(function () {
        Route::get('/', [MembershipPackageController::class, 'index'])->name('index');
        Route::get('/create', [MembershipPackageController::class, 'create'])->name('create');
        Route::post('/', [MembershipPackageController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [MembershipPackageController::class, 'edit'])->name('edit');
        Route::put('/{id}', [MembershipPackageController::class, 'update'])->name('update');
        Route::delete('/{id}', [MembershipPackageController::class, 'destroy'])->name('destroy');
        Route::put('/{id}/status', [MembershipPackageController::class, 'toggleStatus'])->name('toggleStatus');
    });
    
    // Kelola Member (Admin hanya bisa edit, tidak bisa daftarkan)
    Route::prefix('members')->name('members.')->group(function () {
        Route::get('/', [AdminMemberController::class, 'index'])->name('index');
        Route::get('/{id}/edit', [AdminMemberController::class, 'edit'])->name('edit');
        Route::put('/{id}', [AdminMemberController::class, 'update'])->name('update');
        Route::delete('/{id}', [AdminMemberController::class, 'destroy'])->name('destroy');
        Route::put('/{id}/toggle-status', [AdminMemberController::class, 'toggleStatus'])->name('toggleStatus');
    });
    
    // Kelola Stok
    Route::prefix('stock')->name('stock.')->group(function () {
        Route::get('/', [StockController::class, 'index'])->name('index');
        Route::get('/add/{product_id}', [StockController::class, 'create'])->name('create');
        Route::post('/add', [StockController::class, 'store'])->name('store');
        Route::get('/log', [StockController::class, 'log'])->name('log');
    });

    // ===== BARU: KELOLA TRANSAKSI UNTUK ADMIN =====
    Route::prefix('transaksi')->name('transaksi.')->group(function () {
        Route::get('/', [App\Http\Controllers\Admin\TransactionController::class, 'index'])->name('index');
        Route::get('/{id}', [App\Http\Controllers\Admin\TransactionController::class, 'show'])->name('show');
        Route::get('/{id}/struk', [App\Http\Controllers\Admin\TransactionController::class, 'struk'])->name('struk');
        Route::get('/export', [App\Http\Controllers\Admin\TransactionController::class, 'export'])->name('export');
        Route::get('/statistics', [App\Http\Controllers\Admin\TransactionController::class, 'statistics'])->name('statistics');
    });

    // Pengaturan Gym
Route::prefix('settings')->name('settings.')->group(function () {
    Route::get('/', [App\Http\Controllers\Admin\GymSettingController::class, 'index'])->name('index');
    Route::put('/', [App\Http\Controllers\Admin\GymSettingController::class, 'update'])->name('update');
});
});

// Route untuk role kasir
Route::middleware(['auth', 'checkRole:kasir'])->prefix('kasir')->name('kasir.')->group(function () {
    // Dashboard
    Route::get('/dashboard', [KasirController::class, 'dashboard'])->name('dashboard');
    
    // Transaksi
    Route::prefix('transaksi')->name('transaksi.')->group(function () {
        Route::get('/', [KasirTransactionController::class, 'index'])->name('index');
        Route::get('/baru', [KasirTransactionController::class, 'create'])->name('create');
        Route::post('/', [KasirTransactionController::class, 'store'])->name('store');
        Route::get('/{id}', [KasirTransactionController::class, 'show'])->name('show');
        Route::get('/{id}/struk', [KasirTransactionController::class, 'struk'])->name('struk');
        Route::get('/cari-produk', [KasirTransactionController::class, 'cariProduk'])->name('cariProduk');
        Route::get('/cari-member', [KasirTransactionController::class, 'cariMember'])->name('cariMember');
        
        // Routes untuk membership transaction
        Route::prefix('membership')->name('membership.')->group(function () {
            Route::get('/baru', [App\Http\Controllers\Kasir\MembershipTransactionController::class, 'create'])->name('create');
            Route::post('/', [App\Http\Controllers\Kasir\MembershipTransactionController::class, 'store'])->name('store');
            Route::get('/{id}', [App\Http\Controllers\Kasir\MembershipTransactionController::class, 'show'])->name('show');
            Route::get('/{id}/struk', [App\Http\Controllers\Kasir\MembershipTransactionController::class, 'struk'])->name('struk');
            Route::get('/{id}/kartu', [App\Http\Controllers\Kasir\MembershipTransactionController::class, 'kartuMember'])->name('kartu');
        });
    });
    
    // Kelola Member
    Route::prefix('member')->name('member.')->group(function () {
        // Halaman utama member kasir
        Route::get('/', [KasirMemberController::class, 'index'])->name('index');
        
        // Daftar member baru
        Route::get('/daftar', [KasirMemberController::class, 'create'])->name('create');
        Route::post('/daftar', [KasirMemberController::class, 'store'])->name('store');
        
        // Edit member
        Route::get('/{id}/edit', [KasirMemberController::class, 'edit'])->name('edit');
        Route::put('/{id}', [KasirMemberController::class, 'update'])->name('update');
        
        // Perpanjang member
        Route::get('/{id}/perpanjang', [KasirMemberController::class, 'showRenew'])->name('showRenew');
        Route::post('/{id}/perpanjang', [KasirMemberController::class, 'renew'])->name('renew');
        
        // Cek status member - GUNAKAN MemberController
        Route::get('/cek', [App\Http\Controllers\Kasir\MemberController::class, 'cek'])->name('cek');
        Route::get('/cari', [App\Http\Controllers\Kasir\MemberController::class, 'cari'])->name('cari');
        Route::post('/{id}/perpanjang', [App\Http\Controllers\Kasir\MemberController::class, 'perpanjang'])->name('perpanjang');
        Route::get('/packages', [App\Http\Controllers\Kasir\MemberController::class, 'getPackages'])->name('packages');
        
        // Hapus member
        Route::delete('/{id}', [KasirMemberController::class, 'destroy'])->name('destroy');
    });
    
    // Check-in Member - GUNAKAN CheckinController
    Route::prefix('checkin')->name('checkin.')->group(function () {
        Route::get('/', [App\Http\Controllers\Kasir\CheckinController::class, 'index'])->name('index');
        Route::post('/', [App\Http\Controllers\Kasir\CheckinController::class, 'store'])->name('store');
        Route::get('/cari-member', [App\Http\Controllers\Kasir\CheckinController::class, 'cariMember'])->name('cari');
        Route::get('/riwayat', [App\Http\Controllers\Kasir\CheckinController::class, 'riwayat'])->name('riwayat');
        Route::get('/riwayat/export', [App\Http\Controllers\Kasir\CheckinController::class, 'export'])->name('export');
    });
    
    // Report
    Route::prefix('report')->name('report.')->group(function () {
        Route::get('/transaksi', [KasirReportController::class, 'transaksi'])->name('transaksi');
        Route::get('/cetak-ulang', [KasirReportController::class, 'cetakUlang'])->name('cetakUlang');
    });

    // Harga Visit
    Route::get('harga-visit', [App\Http\Controllers\Kasir\TransactionController::class, 'getHargaVisit'])->name('transaksi.hargaVisit');
});

// Route untuk role owner
Route::middleware(['auth', 'checkRole:owner'])->prefix('owner')->name('owner.')->group(function () {
    // Dashboard
    Route::get('/dashboard', [OwnerController::class, 'dashboard'])->name('dashboard');
    
    // Laporan
    Route::prefix('laporan')->name('laporan.')->group(function () {
        // Laporan Transaksi
        Route::get('/transaksi', [OwnerReportController::class, 'transaksi'])->name('transaksi');
            Route::get('/transaksi/{id}', [OwnerReportController::class, 'transaksiShow'])->name('transaksi.show');
        
        // Laporan Stok
        Route::get('/stok', [OwnerReportController::class, 'stok'])->name('stok');
        
        // Laporan Aktivitas User
        Route::get('/aktivitas', [OwnerReportController::class, 'aktivitas'])->name('aktivitas');
        
        // Laporan Member Aktif
        Route::get('/member', [OwnerReportController::class, 'member'])->name('member');
    });
});

// Redirect root berdasarkan role
Route::get('/', function () {
    if (Auth::check()) {
        switch (Auth::user()->role) {
            case 'admin':
                return redirect()->route('admin.dashboard');
            case 'kasir':
                return redirect()->route('kasir.dashboard');
            case 'owner':
                return redirect()->route('owner.dashboard');
            default:
                return redirect()->route('login');
        }
    }
    return redirect()->route('login');
});
