@extends('layouts.app')

@section('title', 'Transaksi Membership Baru')
@section('page-title', 'Transaksi Membership Baru')

@section('sidebar')
    @include('kasir.partials.sidebar')
@endsection

@section('content')
<div class="container-fluid px-4 py-4">
    <!-- Header -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
        <div class="flex items-center space-x-4">
            <a href="{{ route('kasir.transaksi.index') }}" 
               class="flex items-center px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-xl transition-all duration-300">
                <i class="fas fa-arrow-left mr-2"></i>
                <span>Kembali</span>
            </a>
            <h1 class="text-2xl font-bold text-gray-800">Transaksi Membership Baru</h1>
        </div>
        <div class="bg-[#27124A]/10 text-[#27124A] px-5 py-2.5 rounded-xl border border-[#27124A]/20">
            <span class="font-mono font-bold text-lg">{{ $nomorUnik }}</span>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- KIRI: FORM DATA MEMBER & PAKET -->
        <div class="lg:col-span-2 space-y-6">
            <!-- CARD PILIHAN JENIS MEMBERSHIP -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-6 border-b border-gray-100 bg-gradient-to-r from-purple-50 to-white">
                    <div class="flex items-center">
                        <div class="w-10 h-10 bg-purple-100 rounded-full flex items-center justify-center mr-3">
                            <i class="fas fa-id-card text-[#27124A]"></i>
                        </div>
                        <div>
                            <h2 class="text-lg font-semibold text-gray-800">📋 Pilih Jenis Membership</h2>
                            <p class="text-sm text-gray-500">Klik salah satu untuk memulai</p>
                        </div>
                    </div>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Membership Only -->
                        <div class="border-2 rounded-xl p-4 cursor-pointer transition-all duration-300 hover:border-[#27124A] hover:bg-purple-50 jenis-membership-card selected" 
                             data-jenis="membership" id="jenis-membership">
                            <div class="flex flex-col items-center text-center">
                                <div class="w-16 h-16 bg-purple-50 rounded-full flex items-center justify-center mb-3">
                                    <i class="fas fa-id-card text-2xl text-purple-600"></i>
                                </div>
                                <h3 class="font-semibold text-gray-800">Membership Only</h3>
                                <p class="text-xs text-gray-500 mt-1">Pembelian paket membership</p>
                            </div>
                        </div>

                        <!-- Produk + Membership -->
                        <div class="border-2 rounded-xl p-4 cursor-pointer transition-all duration-300 hover:border-[#27124A] hover:bg-purple-50 jenis-membership-card" 
                             data-jenis="produk_membership" id="jenis-produk-membership">
                            <div class="flex flex-col items-center text-center">
                                <div class="w-16 h-16 bg-red-50 rounded-full flex items-center justify-center mb-3">
                                    <i class="fas fa-box text-2xl text-red-600"></i>
                                    <i class="fas fa-id-card text-lg text-red-600 -ml-2"></i>
                                </div>
                                <h3 class="font-semibold text-gray-800">Produk + Membership</h3>
                                <p class="text-xs text-gray-500 mt-1">Produk sekaligus membership</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- CARD DATA MEMBER BARU -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-6 border-b border-gray-100 bg-gradient-to-r from-blue-50 to-white">
                    <div class="flex items-center">
                        <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center mr-3">
                            <i class="fas fa-user-plus text-blue-600"></i>
                        </div>
                        <div>
                            <h2 class="text-lg font-semibold text-gray-800">👤 Data Member Baru</h2>
                            <p class="text-sm text-gray-500">Isi data member dengan lengkap</p>
                        </div>
                    </div>
                </div>
                <div class="p-6">
                    <form id="memberForm" class="space-y-6">
                        @csrf
                        
                        <!-- Grid 2 Kolom untuk Data Pribadi -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Nama Lengkap <span class="text-red-500">*</span>
                                </label>
                                <input type="text" id="nama" name="nama" 
                                    class="w-full border border-gray-200 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-[#27124A]/20 focus:border-[#27124A] transition-all"
                                    placeholder="Masukkan nama lengkap"
                                    required>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Nomor Telepon <span class="text-red-500">*</span>
                                </label>
                                <input type="tel" id="telepon" name="telepon" 
                                    class="w-full border border-gray-200 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-[#27124A]/20 focus:border-[#27124A] transition-all"
                                    placeholder="08xxxxxxxxxx"
                                    required>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Tanggal Lahir <span class="text-red-500">*</span>
                                </label>
                                <input type="date" id="tgl_lahir" name="tgl_lahir" 
                                    class="w-full border border-gray-200 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-[#27124A]/20 focus:border-[#27124A] transition-all"
                                    required>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Jenis Identitas <span class="text-red-500">*</span>
                                </label>
                                <select id="jenis_identitas" name="jenis_identitas" 
                                    class="w-full border border-gray-200 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-[#27124A]/20 focus:border-[#27124A] transition-all"
                                    required>
                                    <option value="">-- Pilih Jenis Identitas --</option>
                                    <option value="KTP">KTP</option>
                                    <option value="SIM">SIM</option>
                                </select>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Nomor Identitas <span class="text-red-500">*</span>
                                </label>
                                <input type="text" id="no_identitas" name="no_identitas" 
                                    class="w-full border border-gray-200 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-[#27124A]/20 focus:border-[#27124A] transition-all"
                                    placeholder="Nomor KTP/SIM"
                                    required>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Foto Identitas
                                </label>
                                <input type="file" id="foto_identitas" name="foto_identitas" 
                                    class="w-full border border-gray-200 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-[#27124A]/20 focus:border-[#27124A] transition-all"
                                    accept="image/*">
                                <p class="text-xs text-gray-500 mt-1">Format: JPG/PNG, Maks: 2MB</p>
                            </div>
                        </div>
                        
                        <!-- Alamat (Full Width) -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Alamat Lengkap <span class="text-red-500">*</span>
                            </label>
                            <textarea id="alamat" name="alamat" rows="3" 
                                class="w-full border border-gray-200 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-[#27124A]/20 focus:border-[#27124A] transition-all"
                                placeholder="Masukkan alamat lengkap"
                                required></textarea>
                        </div>
                    </form>
                </div>
            </div>

            <!-- CARD PAKET MEMBERSHIP -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-6 border-b border-gray-100 bg-gradient-to-r from-purple-50 to-white">
                    <div class="flex items-center">
                        <div class="w-10 h-10 bg-purple-100 rounded-full flex items-center justify-center mr-3">
                            <i class="fas fa-gift text-purple-600"></i>
                        </div>
                        <div>
                            <h2 class="text-lg font-semibold text-gray-800">🎫 Pilih Paket Membership</h2>
                            <p class="text-sm text-gray-500">Pilih paket yang diinginkan</p>
                        </div>
                    </div>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @foreach($membershipPackages as $package)
                        <div class="border-2 rounded-xl p-5 cursor-pointer transition-all duration-300 hover:border-[#27124A] hover:bg-purple-50 package-card" 
                             data-id="{{ $package->id }}"
                             data-nama="{{ $package->nama_paket }}"
                             data-durasi="{{ $package->durasi_hari }}"
                             data-harga="{{ $package->harga }}">
                            <div class="flex justify-between items-start mb-3">
                                <h3 class="font-semibold text-lg text-gray-800">{{ $package->nama_paket }}</h3>
                                <span class="bg-green-100 text-green-700 text-xs px-2 py-1 rounded-full">{{ $package->durasi_formatted }}</span>
                            </div>
                            <div class="mb-4">
                                <span class="text-2xl font-bold text-[#27124A]">Rp {{ number_format($package->harga, 0, ',', '.') }}</span>
                            </div>
                            <button type="button" 
                                class="select-package-btn w-full bg-[#27124A]/10 hover:bg-[#27124A] text-[#27124A] hover:text-white font-medium py-2.5 px-3 rounded-xl text-sm transition-all duration-300 border border-[#27124A]/20"
                                data-id="{{ $package->id }}"
                                data-nama="{{ $package->nama_paket }}"
                                data-durasi="{{ $package->durasi_hari }}"
                                data-harga="{{ $package->harga }}">
                                Pilih Paket
                            </button>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- CARD PRODUK (Jika produk_membership) -->
            <div id="produkSection" class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hidden">
                <div class="p-6 border-b border-gray-100 bg-gradient-to-r from-orange-50 to-white">
                    <div class="flex items-center">
                        <div class="w-10 h-10 bg-orange-100 rounded-full flex items-center justify-center mr-3">
                            <i class="fas fa-box text-orange-600"></i>
                        </div>
                        <div>
                            <h2 class="text-lg font-semibold text-gray-800">📦 Tambah Produk (Opsional)</h2>
                            <p class="text-sm text-gray-500">Pilih produk tambahan</p>
                        </div>
                    </div>
                </div>
                
                <!-- Search Bar -->
                <div class="px-6 pt-4">
                    <div class="relative">
                        <input type="text" id="searchProduct" 
                            class="w-full border border-gray-200 rounded-xl pl-10 pr-4 py-3 focus:outline-none focus:ring-2 focus:ring-[#27124A]/20 focus:border-[#27124A] transition-all"
                            placeholder="Cari produk...">
                        <i class="fas fa-search absolute left-3 top-3.5 text-gray-400"></i>
                    </div>
                </div>
                
                <!-- GRID PRODUK -->
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 max-h-[400px] overflow-y-auto pr-2">
                        @forelse($products as $product)
                        <div class="border border-gray-200 rounded-xl hover:shadow-md transition-all duration-300 cursor-pointer product-card bg-white hover:border-[#27124A]/30 group" 
                             data-id="{{ $product->id }}"
                             data-nama="{{ $product->nama_produk }}"
                             data-harga="{{ $product->harga }}"
                             data-stok="{{ $product->stok }}">
                            <div class="p-4">
                                <div class="flex justify-between items-start mb-2">
                                    <h3 class="font-semibold text-gray-800 group-hover:text-[#27124A] transition-colors">{{ $product->nama_produk }}</h3>
                                    <span class="text-xs px-2 py-1 bg-purple-50 text-[#27124A] rounded-lg">{{ $product->category->nama_kategori ?? 'Umum' }}</span>
                                </div>
                                <div class="flex justify-between items-center mb-3">
                                    <span class="text-lg font-bold text-[#27124A]">Rp {{ number_format($product->harga, 0, ',', '.') }}</span>
                                    @if($product->stok > 0)
                                        <span class="text-xs px-2 py-1 {{ $product->stok <= 5 ? 'bg-orange-50 text-orange-700' : 'bg-green-50 text-green-700' }} rounded-lg">
                                            Stok: {{ $product->stok }}
                                        </span>
                                    @else
                                        <span class="text-xs px-2 py-1 bg-red-50 text-red-700 rounded-lg">
                                            Habis
                                        </span>
                                    @endif
                                </div>
                                @if($product->stok > 0)
                                <button type="button" 
                                        class="add-to-cart-btn w-full bg-[#27124A]/10 hover:bg-[#27124A] text-[#27124A] hover:text-white font-medium py-2.5 px-3 rounded-xl text-sm transition-all duration-300 border border-[#27124A]/20"
                                        data-id="{{ $product->id }}"
                                        data-nama="{{ $product->nama_produk }}"
                                        data-harga="{{ $product->harga }}"
                                        data-stok="{{ $product->stok }}">
                                    <i class="fas fa-cart-plus mr-2"></i> Tambah
                                </button>
                                @else
                                <button type="button" class="w-full bg-gray-100 text-gray-400 font-medium py-2.5 px-3 rounded-xl text-sm cursor-not-allowed" disabled>
                                    <i class="fas fa-times-circle mr-2"></i> Stok Habis
                                </button>
                                @endif
                            </div>
                        </div>
                        @empty
                        <div class="col-span-2 text-center py-12">
                            <div class="inline-flex items-center justify-center w-20 h-20 bg-purple-50 rounded-full mb-4">
                                <i class="fas fa-box-open text-3xl text-[#27124A]"></i>
                            </div>
                            <h4 class="text-lg font-semibold text-gray-800 mb-2">Belum Ada Produk</h4>
                            <p class="text-gray-400 text-sm">Tidak ada produk tersedia saat ini</p>
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- CART SECTION -->
            <div id="cartSection" class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hidden">
                <div class="p-6 border-b border-gray-100 bg-gradient-to-r from-orange-50 to-white">
                    <div class="flex items-center">
                        <div class="w-10 h-10 bg-orange-100 rounded-full flex items-center justify-center mr-3">
                            <i class="fas fa-shopping-cart text-orange-600"></i>
                        </div>
                        <div>
                            <h2 class="text-lg font-semibold text-gray-800">🛒 Keranjang Produk</h2>
                            <p class="text-sm text-gray-500">Daftar produk tambahan</p>
                        </div>
                    </div>
                </div>
                <div class="p-6">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-100">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Produk</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Harga</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Qty</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Subtotal</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="cartItems" class="bg-white divide-y divide-gray-100">
                                <tr id="emptyCart">
                                    <td colspan="5" class="px-4 py-12 text-center">
                                        <div class="inline-flex items-center justify-center w-16 h-16 bg-blue-50 rounded-full mb-3">
                                            <i class="fas fa-shopping-cart text-2xl text-[#27124A]"></i>
                                        </div>
                                        <p class="text-gray-500 mb-1">Keranjang produk kosong</p>
                                        <p class="text-sm text-gray-400">Pilih produk tambahan di atas</p>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- KANAN: RINGKASAN & PEMBAYARAN -->
        <div class="lg:col-span-1 space-y-6">
            <!-- CARD RINGKASAN -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-6 border-b border-gray-100 bg-gradient-to-r from-yellow-50 to-white">
                    <div class="flex items-center">
                        <div class="w-10 h-10 bg-yellow-100 rounded-full flex items-center justify-center mr-3">
                            <i class="fas fa-file-invoice text-yellow-600"></i>
                        </div>
                        <div>
                            <h2 class="text-lg font-semibold text-gray-800">📋 Ringkasan</h2>
                            <p class="text-sm text-gray-500">Detail transaksi</p>
                        </div>
                    </div>
                </div>
                
                <div class="p-6">
                    <!-- Info Paket Terpilih -->
                    <div id="selectedPackageInfo" class="bg-purple-50 p-4 rounded-xl mb-4 hidden">
                        <h4 class="font-semibold text-[#27124A] mb-2">Paket Membership</h4>
                        <div class="space-y-2">
                            <div class="flex justify-between">
                                <span class="text-sm text-gray-600">Paket</span>
                                <span class="font-medium" id="selectedPackageName">-</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-sm text-gray-600">Durasi</span>
                                <span class="font-medium" id="selectedPackageDurasi">-</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-sm text-gray-600">Harga</span>
                                <span class="font-bold text-[#27124A]" id="selectedPackageHarga">-</span>
                            </div>
                        </div>
                    </div>

                    <!-- Info Tanggal -->
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Tanggal Mulai <span class="text-red-500">*</span>
                        </label>
                        <input type="datetime-local" id="tgl_mulai" 
                            class="w-full border border-gray-200 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-[#27124A]/20 focus:border-[#27124A] transition-all"
                            value="{{ now()->format('Y-m-d\TH:i') }}">
                    </div>

                    <!-- Info Tanggal Selesai -->
                    <div class="bg-blue-50 p-4 rounded-xl mb-4 hidden" id="expiredInfo">
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600">Tanggal Selesai</span>
                            <span class="font-bold text-blue-700" id="tglSelesai">-</span>
                        </div>
                    </div>

                    <!-- Rincian Biaya -->
                    <div class="space-y-3 mb-4 pt-4 border-t border-gray-100">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Harga Paket</span>
                            <span class="font-medium" id="displayHargaPaket">Rp 0</span>
                        </div>
                        
                        <div id="subtotalProdukRow" class="flex justify-between hidden">
                            <span class="text-gray-600">Subtotal Produk</span>
                            <span class="font-medium" id="subtotal">Rp 0</span>
                        </div>
                    </div>

                    <!-- Total -->
                    <div class="bg-gray-50 p-4 rounded-xl mb-6">
                        <div class="flex justify-between items-center">
                            <span class="font-bold text-gray-800">TOTAL</span>
                            <span class="font-bold text-2xl text-[#27124A]" id="total">Rp 0</span>
                        </div>
                    </div>

                    <!-- Hidden Inputs -->
                    <input type="hidden" id="jenis_transaksi" value="membership">
                    <input type="hidden" id="id_paket" value="">
                    <input type="hidden" id="harga_paket" value="0">

                    <!-- Uang Bayar -->
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">💸 Uang Bayar</label>
                        <div class="relative">
                            <span class="absolute left-4 top-3.5 text-gray-500">Rp</span>
                            <input type="text" id="uang_bayar" 
                                class="w-full pl-10 pr-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#27124A]/20 focus:border-[#27124A] transition-all"
                                placeholder="0">
                        </div>
                        
                        <!-- Quick Amount -->
                        <div class="grid grid-cols-3 gap-2 mt-3">
                            <button type="button" class="quick-amount bg-gray-100 hover:bg-gray-200 text-gray-700 px-3 py-2 rounded-xl text-sm font-medium transition-all" data-amount="50000">50K</button>
                            <button type="button" class="quick-amount bg-gray-100 hover:bg-gray-200 text-gray-700 px-3 py-2 rounded-xl text-sm font-medium transition-all" data-amount="100000">100K</button>
                            <button type="button" class="quick-amount bg-gray-100 hover:bg-gray-200 text-gray-700 px-3 py-2 rounded-xl text-sm font-medium transition-all" data-amount="200000">200K</button>
                            <button type="button" class="quick-amount bg-gray-100 hover:bg-gray-200 text-gray-700 px-3 py-2 rounded-xl text-sm font-medium transition-all" data-amount="500000">500K</button>
                            <button type="button" class="quick-amount bg-gray-100 hover:bg-gray-200 text-gray-700 px-3 py-2 rounded-xl text-sm font-medium transition-all" data-amount="1000000">1JT</button>
                            <button type="button" id="btnUangPas" class="bg-[#27124A]/10 hover:bg-[#27124A] text-[#27124A] hover:text-white px-3 py-2 rounded-xl text-sm font-medium transition-all border border-[#27124A]/20">
                                Uang Pas
                            </button>
                        </div>
                    </div>

                    <!-- Uang Kembali -->
                    <div class="mb-6 p-4 bg-gray-50 rounded-xl">
                        <div class="flex justify-between items-center">
                            <span class="font-medium text-gray-700">🔄 Uang Kembali</span>
                            <span class="font-bold text-lg text-green-600" id="uang_kembali">Rp 0</span>
                        </div>
                    </div>

                    <!-- Catatan -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">📝 Catatan</label>
                        <textarea id="catatan" rows="2" 
                            class="w-full border border-gray-200 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-[#27124A]/20 focus:border-[#27124A] transition-all"
                            placeholder="Tambahkan catatan (opsional)"></textarea>
                    </div>

                    <!-- Tombol Aksi -->
                    <div class="space-y-3">
                        <button type="button" id="btnSimpan" 
                            class="w-full bg-[#27124A] hover:bg-[#3a1d6b] text-white font-semibold py-3 px-4 rounded-xl transition-all duration-300 flex items-center justify-center shadow-lg hover:shadow-xl">
                            <i class="fas fa-check-circle mr-2"></i>
                            Proses Membership
                        </button>
                        <button type="button" id="btnBatal" 
                            class="w-full bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold py-3 px-4 rounded-xl transition-all duration-300 flex items-center justify-center">
                            <i class="fas fa-times-circle mr-2"></i>
                            Batalkan
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- MODAL SUKSES -->
<div id="successModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
    <div class="bg-white rounded-2xl shadow-xl w-full max-w-md p-6 transform transition-all">
        <div class="text-center">
            <div class="mx-auto flex items-center justify-center h-20 w-20 rounded-full bg-green-100 mb-4">
                <i class="fas fa-check-circle text-green-600 text-4xl"></i>
            </div>
            <h3 class="text-xl font-bold text-gray-900 mb-2">✅ Transaksi Berhasil!</h3>
            <p class="text-gray-600 mb-4" id="successMessage"></p>
            
            <div class="bg-purple-50 border border-purple-200 rounded-xl p-4 mb-4">
                <p class="text-sm text-gray-600 mb-1">No. Transaksi</p>
                <p class="text-xl font-mono font-bold text-[#27124A]" id="successNomor"></p>
            </div>

            <div class="bg-green-50 border border-green-200 rounded-xl p-4 mb-6">
                <p class="text-sm text-gray-600 mb-2">Data Member</p>
                <p class="font-semibold text-gray-800" id="successNamaMember"></p>
                <p class="text-sm font-mono text-gray-600" id="successKodeMember"></p>
            </div>
            
            <div class="grid grid-cols-2 gap-2">
                <button type="button" id="btnCetakStruk" 
                    class="bg-[#27124A] hover:bg-[#3a1d6b] text-white font-semibold py-2.5 px-4 rounded-xl transition-all duration-300">
                    <i class="fas fa-print mr-2"></i>Struk
                </button>
                <button type="button" id="btnCetakKartu" 
                    class="bg-green-600 hover:bg-green-700 text-white font-semibold py-2.5 px-4 rounded-xl transition-all duration-300">
                    <i class="fas fa-id-card mr-2"></i>Kartu Member
                </button>
                <a href="{{ route('kasir.transaksi.membership.create') }}" 
                    class="col-span-2 bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold py-2.5 px-4 rounded-xl transition-all duration-300 text-center">
                    Transaksi Baru
                </a>
            </div>
        </div>
    </div>
</div>

<!-- STYLES -->
<style>
    .jenis-membership-card {
        border-color: #e5e7eb;
        transition: all 0.3s ease;
    }
    .jenis-membership-card.selected {
        border-color: #27124A;
        background-color: #f5f3ff;
        transform: scale(1.02);
        box-shadow: 0 10px 25px -5px rgba(39, 18, 74, 0.1);
    }
    .package-card.selected {
        border-color: #27124A;
        background-color: #f5f3ff;
    }
    .cart-item td {
        padding: 1rem 1rem;
        vertical-align: middle;
    }
    .qty-btn {
        width: 32px;
        height: 32px;
        display: flex;
        align-items: center;
        justify-content: center;
        background-color: #f3f4f6;
        border: 1px solid #e5e7eb;
        color: #4b5563;
        font-weight: bold;
        transition: all 0.2s;
    }
    .qty-btn:hover {
        background-color: #e5e7eb;
    }
    .qty-input {
        width: 50px;
        height: 32px;
        text-align: center;
        border-top: 1px solid #e5e7eb;
        border-bottom: 1px solid #e5e7eb;
        border-left: none;
        border-right: none;
        -moz-appearance: textfield;
    }
    .qty-input::-webkit-outer-spin-button,
    .qty-input::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    console.log('✅ Membership Transaction JS Loaded!');
    
    // State
    let cart = [];
    let selectedPackage = null;
    let jenisTransaksi = 'membership';
    
    // Elements
    const elements = {
        jenisCards: document.querySelectorAll('.jenis-membership-card'),
        jenisTransaksiInput: document.getElementById('jenis_transaksi'),
        produkSection: document.getElementById('produkSection'),
        cartSection: document.getElementById('cartSection'),
        
        // Products
        productCards: document.querySelectorAll('.product-card'),
        addToCartBtns: document.querySelectorAll('.add-to-cart-btn'),
        searchProduct: document.getElementById('searchProduct'),
        cartItems: document.getElementById('cartItems'),
        emptyCart: document.getElementById('emptyCart'),
        
        // Package
        packageCards: document.querySelectorAll('.package-card'),
        selectPackageBtns: document.querySelectorAll('.select-package-btn'),
        selectedPackageInfo: document.getElementById('selectedPackageInfo'),
        selectedPackageName: document.getElementById('selectedPackageName'),
        selectedPackageDurasi: document.getElementById('selectedPackageDurasi'),
        selectedPackageHarga: document.getElementById('selectedPackageHarga'),
        idPaket: document.getElementById('id_paket'),
        hargaPaket: document.getElementById('harga_paket'),
        displayHargaPaket: document.getElementById('displayHargaPaket'),
        
        // Dates
        tglMulai: document.getElementById('tgl_mulai'),
        tglSelesai: document.getElementById('tglSelesai'),
        expiredInfo: document.getElementById('expiredInfo'),
        
        // Totals
        subtotalProdukRow: document.getElementById('subtotalProdukRow'),
        subtotal: document.getElementById('subtotal'),
        total: document.getElementById('total'),
        
        // Payment
        uangBayar: document.getElementById('uang_bayar'),
        uangKembali: document.getElementById('uang_kembali'),
        catatan: document.getElementById('catatan'),
        btnSimpan: document.getElementById('btnSimpan'),
        btnBatal: document.getElementById('btnBatal'),
        
        // Quick Amount
        quickAmounts: document.querySelectorAll('.quick-amount'),
        btnUangPas: document.getElementById('btnUangPas'),
        
        // Member Form
        nama: document.getElementById('nama'),
        telepon: document.getElementById('telepon'),
        alamat: document.getElementById('alamat'),
        tglLahir: document.getElementById('tgl_lahir'),
        jenisIdentitas: document.getElementById('jenis_identitas'),
        noIdentitas: document.getElementById('no_identitas'),
        fotoIdentitas: document.getElementById('foto_identitas'),
        
        // Modal
        successModal: document.getElementById('successModal'),
        successMessage: document.getElementById('successMessage'),
        successNomor: document.getElementById('successNomor'),
        successNamaMember: document.getElementById('successNamaMember'),
        successKodeMember: document.getElementById('successKodeMember'),
        btnCetakStruk: document.getElementById('btnCetakStruk'),
        btnCetakKartu: document.getElementById('btnCetakKartu')
    };

    // Helper Functions
    function formatCurrency(amount) {
        return 'Rp ' + new Intl.NumberFormat('id-ID').format(Math.round(amount || 0));
    }

    function parseCurrency(value) {
        if (!value) return 0;
        const cleaned = value.toString().replace(/[^0-9]/g, '');
        return parseInt(cleaned) || 0;
    }

    function calculateExpiredDate(durasiHari, startDate = null) {
        if (!durasiHari) return '-';
        let date = startDate ? new Date(startDate) : new Date();
        date.setDate(date.getDate() + parseInt(durasiHari));
        return date.toLocaleDateString('id-ID', {
            day: '2-digit',
            month: '2-digit',
            year: 'numeric',
            hour: '2-digit',
            minute: '2-digit'
        });
    }

    // Jenis Transaksi
    function selectJenisTransaksi(jenis) {
        console.log('Select jenis:', jenis);
        
        elements.jenisCards.forEach(card => card.classList.remove('selected'));
        document.getElementById(`jenis-${jenis}`).classList.add('selected');
        
        jenisTransaksi = jenis;
        if (elements.jenisTransaksiInput) {
            elements.jenisTransaksiInput.value = jenis;
        }
        
        if (jenis === 'produk_membership') {
            elements.produkSection.classList.remove('hidden');
            elements.cartSection.classList.remove('hidden');
        } else {
            elements.produkSection.classList.add('hidden');
            elements.cartSection.classList.add('hidden');
            cart = [];
            renderCart();
        }
        
        calculateTotals();
    }

    // Select Package
    function selectPackage(pkg) {
        selectedPackage = pkg;
        
        elements.selectedPackageInfo.classList.remove('hidden');
        elements.selectedPackageName.textContent = pkg.nama;
        elements.selectedPackageDurasi.textContent = pkg.durasi + ' Hari';
        elements.selectedPackageHarga.textContent = formatCurrency(pkg.harga);
        elements.displayHargaPaket.textContent = formatCurrency(pkg.harga);
        elements.idPaket.value = pkg.id;
        elements.hargaPaket.value = pkg.harga;
        
        // Update expired date
        if (elements.tglMulai.value) {
            updateExpiredDate();
        }
        
        calculateTotals();
    }

    // Update Expired Date
    function updateExpiredDate() {
        if (!selectedPackage || !elements.tglMulai.value) return;
        
        const tglSelesai = calculateExpiredDate(selectedPackage.durasi, elements.tglMulai.value);
        elements.tglSelesai.textContent = tglSelesai;
        elements.expiredInfo.classList.remove('hidden');
    }

    // Cart Functions
    function addToCart(product) {
        const existingIndex = cart.findIndex(i => i.id === product.id);
        
        if (existingIndex !== -1) {
            if (cart[existingIndex].qty + 1 > product.stok) {
                alert(`⚠️ Stok tidak cukup! Tersedia: ${product.stok}`);
                return;
            }
            cart[existingIndex].qty += 1;
        } else {
            if (product.stok < 1) {
                alert(`⚠️ Stok produk habis!`);
                return;
            }
            cart.push({
                id: product.id,
                nama: product.nama,
                harga: product.harga,
                qty: 1,
                stok: product.stok
            });
        }
        
        renderCart();
        
        // Animasi feedback
        const btn = event?.target?.closest('button');
        if (btn) {
            const originalText = btn.innerHTML;
            btn.innerHTML = '<i class="fas fa-check mr-1"></i> Ditambahkan';
            btn.classList.remove('bg-[#27124A]/10', 'text-[#27124A]', 'border-[#27124A]/20');
            btn.classList.add('bg-green-600', 'text-white', 'border-green-600');
            setTimeout(() => {
                btn.innerHTML = originalText;
                btn.classList.add('bg-[#27124A]/10', 'text-[#27124A]', 'border-[#27124A]/20');
                btn.classList.remove('bg-green-600', 'text-white', 'border-green-600');
            }, 1000);
        }
    }

    function renderCart() {
        if (!elements.cartItems) return;
        
        elements.cartItems.innerHTML = '';
        
        if (cart.length === 0) {
            const emptyRow = document.createElement('tr');
            emptyRow.id = 'emptyCart';
            emptyRow.innerHTML = `
                <td colspan="5" class="px-4 py-12 text-center">
                    <div class="inline-flex items-center justify-center w-16 h-16 bg-blue-50 rounded-full mb-3">
                        <i class="fas fa-shopping-cart text-2xl text-[#27124A]"></i>
                    </div>
                    <p class="text-gray-500 mb-1">Keranjang produk kosong</p>
                    <p class="text-sm text-gray-400">Pilih produk tambahan di atas</p>
                </td>
            `;
            elements.cartItems.appendChild(emptyRow);
        } else {
            cart.forEach((item, index) => {
                const subtotal = item.harga * item.qty;
                const row = document.createElement('tr');
                row.className = 'cart-item hover:bg-gray-50 transition-colors';
                row.innerHTML = `
                    <td class="px-4 py-3">
                        <div class="font-medium text-gray-800">${item.nama}</div>
                        <div class="text-xs text-gray-500 mt-0.5">Stok: ${item.stok}</div>
                    </td>
                    <td class="px-4 py-3 font-medium text-[#27124A]">${formatCurrency(item.harga)}</td>
                    <td class="px-4 py-3">
                        <div class="flex items-center">
                            <button type="button" class="qty-btn minus rounded-l-lg" data-index="${index}">-</button>
                            <input type="number" class="qty-input" value="${item.qty}" min="1" max="${item.stok}" data-index="${index}">
                            <button type="button" class="qty-btn plus rounded-r-lg" data-index="${index}">+</button>
                        </div>
                    </td>
                    <td class="px-4 py-3 font-medium text-gray-800">${formatCurrency(subtotal)}</td>
                    <td class="px-4 py-3">
                        <button type="button" class="remove-item text-red-600 hover:text-red-800 p-2" data-index="${index}">
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>
                `;
                elements.cartItems.appendChild(row);
            });
            
            attachCartEventListeners();
        }
        
        calculateTotals();
        updateUangKembali();
    }

    function attachCartEventListeners() {
        document.querySelectorAll('.minus').forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                const index = parseInt(this.dataset.index);
                if (cart[index]) {
                    updateQuantity(index, cart[index].qty - 1);
                }
            });
        });
        
        document.querySelectorAll('.plus').forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                const index = parseInt(this.dataset.index);
                if (cart[index]) {
                    updateQuantity(index, cart[index].qty + 1);
                }
            });
        });
        
        document.querySelectorAll('.qty-input').forEach(input => {
            input.addEventListener('change', function(e) {
                e.preventDefault();
                const index = parseInt(this.dataset.index);
                const value = parseInt(this.value);
                if (!isNaN(value) && cart[index]) {
                    updateQuantity(index, value);
                }
            });
        });
        
        document.querySelectorAll('.remove-item').forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                const index = parseInt(this.dataset.index);
                if (confirm('Hapus produk dari keranjang?')) {
                    removeFromCart(index);
                }
            });
        });
    }

    function removeFromCart(index) {
        cart.splice(index, 1);
        renderCart();
    }

    function updateQuantity(index, newQty) {
        if (!cart[index]) return;
        
        if (newQty < 1) {
            removeFromCart(index);
        } else if (newQty > cart[index].stok) {
            alert(`⚠️ Stok tidak cukup! Maksimal: ${cart[index].stok}`);
            cart[index].qty = cart[index].stok;
            renderCart();
        } else {
            cart[index].qty = newQty;
            renderCart();
        }
    }

    // Calculate Totals
    function calculateTotals() {
        const subtotalProduk = cart.reduce((sum, item) => sum + (item.harga * item.qty), 0);
        const hargaPaket = selectedPackage ? selectedPackage.harga : 0;
        const total = hargaPaket + subtotalProduk;
        
        // Update display
        if (subtotalProduk > 0) {
            elements.subtotalProdukRow.classList.remove('hidden');
            elements.subtotal.textContent = formatCurrency(subtotalProduk);
        } else {
            elements.subtotalProdukRow.classList.add('hidden');
        }
        
        elements.total.textContent = formatCurrency(total);
        
        return total;
    }

    // Update Uang Kembali
    function updateUangKembali() {
        const total = calculateTotals();
        const uangBayar = parseCurrency(elements.uangBayar.value);
        const kembali = uangBayar - total;
        
        if (uangBayar === 0) {
            elements.uangKembali.textContent = formatCurrency(0);
            elements.uangKembali.className = 'font-bold text-lg text-gray-600';
        } else if (kembali >= 0) {
            elements.uangKembali.textContent = formatCurrency(kembali);
            elements.uangKembali.className = 'font-bold text-lg text-green-600';
        } else {
            elements.uangKembali.textContent = formatCurrency(Math.abs(kembali)) + ' (Kurang)';
            elements.uangKembali.className = 'font-bold text-lg text-red-600';
        }
    }

    // Filter Products
    function filterProducts() {
        const search = elements.searchProduct.value.toLowerCase().trim();
        document.querySelectorAll('.product-card').forEach(card => {
            const nama = card.dataset.nama.toLowerCase();
            card.style.display = nama.includes(search) || search === '' ? 'block' : 'none';
        });
    }

    // Validate Form
    function validateForm() {
        // Validate Member Data
        if (!elements.nama.value.trim()) {
            alert('❌ Nama harus diisi');
            elements.nama.focus();
            return false;
        }
        if (!elements.telepon.value.trim()) {
            alert('❌ Nomor telepon harus diisi');
            elements.telepon.focus();
            return false;
        }
        if (!elements.alamat.value.trim()) {
            alert('❌ Alamat harus diisi');
            elements.alamat.focus();
            return false;
        }
        if (!elements.tglLahir.value) {
            alert('❌ Tanggal lahir harus diisi');
            elements.tglLahir.focus();
            return false;
        }
        if (!elements.jenisIdentitas.value) {
            alert('❌ Jenis identitas harus dipilih');
            elements.jenisIdentitas.focus();
            return false;
        }
        if (!elements.noIdentitas.value.trim()) {
            alert('❌ Nomor identitas harus diisi');
            elements.noIdentitas.focus();
            return false;
        }
        
        // Validate Package
        if (!selectedPackage) {
            alert('❌ Pilih paket membership');
            return false;
        }
        
        // Validate Start Date
        if (!elements.tglMulai.value) {
            alert('❌ Tanggal mulai harus diisi');
            elements.tglMulai.focus();
            return false;
        }
        
        // Validate Payment
        const total = calculateTotals();
        const uangBayar = parseCurrency(elements.uangBayar.value);
        
        if (uangBayar === 0) {
            alert('❌ Masukkan jumlah uang bayar');
            elements.uangBayar.focus();
            return false;
        }
        
        if (uangBayar < total) {
            alert('❌ Uang bayar kurang dari total');
            elements.uangBayar.focus();
            return false;
        }
        
        return true;
    }

    // Save Transaction
    async function saveTransaction() {
        if (!validateForm()) return;
        
        const total = calculateTotals();
        const uangBayar = parseCurrency(elements.uangBayar.value);
        
        // Prepare FormData
        const formData = new FormData();
        
        // Member Data
        formData.append('nama', elements.nama.value.trim());
        formData.append('telepon', elements.telepon.value.trim());
        formData.append('alamat', elements.alamat.value.trim());
        formData.append('tgl_lahir', elements.tglLahir.value);
        formData.append('jenis_identitas', elements.jenisIdentitas.value);
        formData.append('no_identitas', elements.noIdentitas.value.trim());
        formData.append('_token', '{{ csrf_token() }}');
        
        // Foto (if any)
        if (elements.fotoIdentitas.files.length > 0) {
            formData.append('foto_identitas', elements.fotoIdentitas.files[0]);
        }
        
        // Transaction Data
        formData.append('jenis_transaksi', jenisTransaksi);
        formData.append('id_paket', selectedPackage.id);
        formData.append('tgl_mulai', elements.tglMulai.value);
        formData.append('total_harga', total);
        formData.append('uang_bayar', uangBayar);
        formData.append('uang_kembali', uangBayar - total);
        formData.append('catatan', elements.catatan.value || '');
        
        // Items
        if (cart.length > 0) {
            formData.append('items', JSON.stringify(cart.map(item => ({
                product_id: item.id,
                qty: item.qty
            }))));
        }
        
        // Disable button
        elements.btnSimpan.disabled = true;
        elements.btnSimpan.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Memproses...';
        
        try {
            const response = await fetch('{{ route("kasir.transaksi.membership.store") }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: formData
            });
            
            const result = await response.json();
            console.log('Response:', result);
            
            if (result.success) {
                elements.successMessage.textContent = 'Transaksi membership berhasil!';
                elements.successNomor.textContent = result.nomor_unik;
                elements.successNamaMember.textContent = result.member.nama;
                elements.successKodeMember.textContent = result.member.kode;
                
                elements.btnCetakStruk.onclick = () => {
                    window.open(`{{ url("kasir/transaksi/membership") }}/${result.transaction_id}/struk`, '_blank');
                };
                
                elements.btnCetakKartu.onclick = () => {
                    window.open(`{{ url("kasir/transaksi/membership") }}/${result.transaction_id}/kartu`, '_blank');
                };
                
                elements.successModal.classList.remove('hidden');
                elements.successModal.style.display = 'flex';
                
                // Auto print struk after 1 second
                setTimeout(() => {
                    if (confirm('Cetak struk pembayaran?')) {
                        window.open(`{{ url("kasir/transaksi/membership") }}/${result.transaction_id}/struk`, '_blank');
                    }
                }, 1000);
                
            } else {
                alert('❌ Error: ' + (result.message || 'Terjadi kesalahan'));
            }
        } catch (error) {
            console.error('Error:', error);
            alert('❌ Gagal memproses transaksi: ' + error.message);
        } finally {
            elements.btnSimpan.disabled = false;
            elements.btnSimpan.innerHTML = '<i class="fas fa-check-circle mr-2"></i> Proses Membership';
        }
    }

    // Event Listeners
    elements.jenisCards.forEach(card => {
        card.addEventListener('click', function() {
            selectJenisTransaksi(this.dataset.jenis);
        });
    });

    elements.selectPackageBtns.forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            // Remove selected class from all package cards
            elements.packageCards.forEach(card => card.classList.remove('selected'));
            
            // Add selected class to parent card
            this.closest('.package-card').classList.add('selected');
            
            selectPackage({
                id: parseInt(this.dataset.id),
                nama: this.dataset.nama,
                durasi: parseInt(this.dataset.durasi),
                harga: parseFloat(this.dataset.harga)
            });
        });
    });

    elements.packageCards.forEach(card => {
        card.addEventListener('click', function(e) {
            if (e.target.closest('button')) return;
            
            // Remove selected class from all
            elements.packageCards.forEach(c => c.classList.remove('selected'));
            
            // Add selected class to this
            this.classList.add('selected');
            
            selectPackage({
                id: parseInt(this.dataset.id),
                nama: this.dataset.nama,
                durasi: parseInt(this.dataset.durasi),
                harga: parseFloat(this.dataset.harga)
            });
        });
    });

    elements.addToCartBtns.forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            if (jenisTransaksi !== 'produk_membership') {
                alert('❌ Pilih jenis "Produk + Membership" terlebih dahulu');
                return;
            }
            
            addToCart({
                id: parseInt(this.dataset.id),
                nama: this.dataset.nama,
                harga: parseFloat(this.dataset.harga),
                stok: parseInt(this.dataset.stok)
            });
        });
    });

    elements.productCards.forEach(card => {
        card.addEventListener('click', function(e) {
            if (e.target.closest('button')) return;
            
            if (jenisTransaksi !== 'produk_membership') {
                alert('❌ Pilih jenis "Produk + Membership" terlebih dahulu');
                return;
            }
            
            addToCart({
                id: parseInt(this.dataset.id),
                nama: this.dataset.nama,
                harga: parseFloat(this.dataset.harga),
                stok: parseInt(this.dataset.stok)
            });
        });
    });

    if (elements.searchProduct) {
        elements.searchProduct.addEventListener('input', filterProducts);
    }

    if (elements.tglMulai) {
        elements.tglMulai.addEventListener('change', updateExpiredDate);
    }

    if (elements.uangBayar) {
        elements.uangBayar.addEventListener('input', updateUangKembali);
        elements.uangBayar.addEventListener('keypress', function(e) {
            if (!/[\d]/.test(e.key)) e.preventDefault();
        });
    }

    elements.quickAmounts.forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            elements.uangBayar.value = this.dataset.amount;
            updateUangKembali();
        });
    });

    if (elements.btnUangPas) {
        elements.btnUangPas.addEventListener('click', function(e) {
            e.preventDefault();
            elements.uangBayar.value = calculateTotals();
            updateUangKembali();
        });
    }

    if (elements.btnSimpan) {
        elements.btnSimpan.addEventListener('click', function(e) {
            e.preventDefault();
            saveTransaction();
        });
    }

    if (elements.btnBatal) {
        elements.btnBatal.addEventListener('click', function(e) {
            e.preventDefault();
            if (confirm('Batalkan transaksi? Semua data akan hilang.')) {
                window.location.href = '{{ route("kasir.transaksi.index") }}';
            }
        });
    }

    if (elements.successModal) {
        elements.successModal.addEventListener('click', function(e) {
            if (e.target === this) {
                this.style.display = 'none';
                this.classList.add('hidden');
            }
        });
    }

    // Initialize
    renderCart();
    selectJenisTransaksi('membership');
});
</script>
@endsection