@extends('layouts.app')

@section('title', 'Transaksi Baru')
@section('page-title', 'Transaksi Baru')

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
            <h1 class="text-2xl font-bold text-gray-800">Transaksi Baru</h1>
        </div>
        <div class="flex items-center space-x-3">
            <a href="{{ route('kasir.transaksi.membership.create') }}" 
               class="bg-purple-600 hover:bg-purple-700 text-white px-5 py-2.5 rounded-xl transition-all duration-300 flex items-center shadow-sm hover:shadow-md">
                <i class="fas fa-id-card mr-2"></i>
                Transaksi Membership
            </a>
            <div class="bg-[#27124A]/10 text-[#27124A] px-5 py-2.5 rounded-xl border border-[#27124A]/20">
                <span class="font-mono font-bold text-lg">{{ $nomorUnik }}</span>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- KIRI: JENIS TRANSAKSI & RINCIAN -->
        <div class="lg:col-span-2 space-y-6">
            <!-- CARD PILIHAN JENIS TRANSAKSI -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-6 border-b border-gray-100">
                    <h2 class="text-lg font-semibold text-gray-800">📋 Pilih Jenis Transaksi</h2>
                    <p class="text-sm text-gray-500 mt-1">Klik salah satu jenis transaksi untuk memulai</p>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <!-- Produk Only -->
                        <div class="border-2 rounded-xl p-4 cursor-pointer transition-all duration-300 hover:border-[#27124A] hover:bg-purple-50 jenis-transaksi-card" 
                             data-jenis="produk" id="jenis-produk">
                            <div class="flex flex-col items-center text-center">
                                <div class="w-16 h-16 bg-blue-50 rounded-full flex items-center justify-center mb-3">
                                    <i class="fas fa-box text-2xl text-blue-600"></i>
                                </div>
                                <h3 class="font-semibold text-gray-800">Produk Only</h3>
                                <p class="text-xs text-gray-500 mt-1">Pembelian produk saja</p>
                                <span class="mt-2 text-xs px-2 py-1 bg-blue-100 text-blue-700 rounded-full">Klik untuk mulai</span>
                            </div>
                        </div>

                        <!-- Visit Only -->
                        <div class="border-2 rounded-xl p-4 cursor-pointer transition-all duration-300 hover:border-[#27124A] hover:bg-purple-50 jenis-transaksi-card" 
                             data-jenis="visit" id="jenis-visit">
                            <div class="flex flex-col items-center text-center">
                                <div class="w-16 h-16 bg-green-50 rounded-full flex items-center justify-center mb-3">
                                    <i class="fas fa-walking text-2xl text-green-600"></i>
                                </div>
                                <h3 class="font-semibold text-gray-800">Visit Only</h3>
                                <p class="text-xs text-gray-500 mt-1">Visit harian gym</p>
                                <span class="mt-2 text-xs px-2 py-1 bg-green-100 text-green-700 rounded-full">Klik untuk mulai</span>
                            </div>
                        </div>

                        <!-- Produk + Visit -->
                        <div class="border-2 rounded-xl p-4 cursor-pointer transition-all duration-300 hover:border-[#27124A] hover:bg-purple-50 jenis-transaksi-card" 
                             data-jenis="produk_visit" id="jenis-produk-visit">
                            <div class="flex flex-col items-center text-center">
                                <div class="w-16 h-16 bg-orange-50 rounded-full flex items-center justify-center mb-3">
                                    <i class="fas fa-box text-2xl text-orange-600"></i>
                                    <i class="fas fa-walking text-lg text-orange-600 -ml-2"></i>
                                </div>
                                <h3 class="font-semibold text-gray-800">Produk + Visit</h3>
                                <p class="text-xs text-gray-500 mt-1">Produk sekaligus visit</p>
                                <span class="mt-2 text-xs px-2 py-1 bg-orange-100 text-orange-700 rounded-full">Klik untuk mulai</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- CARD PRODUK (Muncul setelah klik jenis yang mengandung produk) -->
            <div id="produkSection" class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hidden">
                <div class="p-6 border-b border-gray-100 bg-gradient-to-r from-purple-50 to-white">
                    <div class="flex items-center">
                        <div class="w-10 h-10 bg-purple-100 rounded-full flex items-center justify-center mr-3">
                            <i class="fas fa-box text-[#27124A]"></i>
                        </div>
                        <div>
                            <h2 class="text-lg font-semibold text-gray-800">📦 Pilih Produk</h2>
                            <p class="text-sm text-gray-500">Klik produk untuk menambahkan ke keranjang</p>
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
                                        class="add-to-cart-btn w-full bg-[#27124A]/10 hover:bg-[#27124A] text-[#27124A] hover:text-white font-medium py-2.5 px-3 rounded-xl text-sm transition-all duration-300 border border-[#27124A]/20 flex items-center justify-center"
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

            <!-- CARD KERANJANG (Muncul setelah klik jenis yang mengandung produk) -->
            <div id="cartSection" class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hidden">
                <div class="p-6 border-b border-gray-100 bg-gradient-to-r from-purple-50 to-white">
                    <div class="flex items-center">
                        <div class="w-10 h-10 bg-purple-100 rounded-full flex items-center justify-center mr-3">
                            <i class="fas fa-shopping-cart text-[#27124A]"></i>
                        </div>
                        <div>
                            <h2 class="text-lg font-semibold text-gray-800">🛒 Keranjang Belanja</h2>
                            <p class="text-sm text-gray-500">Daftar produk yang akan dibeli</p>
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
                                        <p class="text-gray-500 mb-1">Keranjang belanja kosong</p>
                                        <p class="text-sm text-gray-400">Pilih produk di atas</p>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- CARD VISIT (Muncul setelah klik jenis yang mengandung visit) -->
            <div id="visitSection" class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hidden">
                <div class="p-6 border-b border-gray-100 bg-gradient-to-r from-green-50 to-white">
                    <div class="flex items-center">
                        <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center mr-3">
                            <i class="fas fa-walking text-green-600"></i>
                        </div>
                        <div>
                            <h2 class="text-lg font-semibold text-gray-800">🏃‍♂️ Data Visit</h2>
                            <p class="text-sm text-gray-500">Informasi visit gym</p>
                        </div>
                    </div>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Harga Visit
                            </label>
                            <div class="bg-green-50 border border-green-200 rounded-xl p-4">
                                <div class="text-2xl font-bold text-green-600">Rp {{ number_format($hargaVisit ?? 25000, 0, ',', '.') }}</div>
                                <p class="text-xs text-green-600 mt-1 flex items-center">
                                    <i class="fas fa-info-circle mr-1"></i>
                                    Harga diatur oleh admin
                                </p>
                            </div>
                            <input type="hidden" id="harga_visit" value="{{ $hargaVisit ?? 25000 }}">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Tanggal Visit <span class="text-red-500">*</span>
                            </label>
                            <input type="datetime-local" id="tgl_visit" 
                                class="w-full border border-gray-200 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-green-500/20 focus:border-green-500 transition-all"
                                value="{{ now()->format('Y-m-d\TH:i') }}">
                        </div>
                    </div>
                    
                    <!-- INFO TAMBAHAN: Harga visit dari admin -->
                    <div class="mt-4 text-xs text-gray-500 bg-blue-50 p-3 rounded-lg border border-blue-100">
                        <i class="fas fa-info-circle text-blue-500 mr-1"></i>
                        Harga visit ditentukan oleh admin. Jika ingin mengubah harga, hubungi admin.
                    </div>
                </div>
            </div>
        </div>

        <!-- KANAN: PEMBAYARAN -->
        <div class="lg:col-span-1 space-y-6">
            <!-- CARD INFORMASI MEMBER (SEDERHANA) -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-6 border-b border-gray-100 bg-gradient-to-r from-blue-50 to-white">
                    <div class="flex items-center">
                        <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center mr-3">
                            <i class="fas fa-user text-blue-600"></i>
                        </div>
                        <div>
                            <h2 class="text-lg font-semibold text-gray-800">👤 Informasi Member</h2>
                            <p class="text-sm text-gray-500">Opsional - isi jika member</p>
                        </div>
                    </div>
                </div>
                <div class="p-6">
                    <!-- Input Kode Member (Sederhana) -->
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Kode Member (Opsional)</label>
                        <div class="flex gap-2">
                            <input type="text" id="kode_member_input" 
                                class="flex-1 border border-gray-200 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-[#27124A]/20 focus:border-[#27124A] transition-all"
                                placeholder="Masukkan kode member">
                            <button type="button" id="btnCekMember" 
                                class="bg-[#27124A] hover:bg-[#3a1d6b] text-white px-5 py-3 rounded-xl transition-all duration-300">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </div>
                    
                    <!-- Info Member jika ditemukan -->
                    <div id="memberInfoSimple" class="hidden">
                        <div class="bg-green-50 border border-green-200 rounded-xl p-4">
                            <div class="flex justify-between items-start">
                                <div>
                                    <p class="text-xs text-green-600 mb-1">Member Aktif</p>
                                    <h5 id="memberNameSimple" class="font-semibold text-green-800"></h5>
                                    <p id="memberCodeSimple" class="text-sm text-green-600 mt-1"></p>
                                </div>
                                <button type="button" id="btnRemoveMemberSimple" class="text-red-600 hover:text-red-800">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                            <div class="mt-3 flex text-xs text-green-700 bg-white bg-opacity-50 p-2 rounded-lg">
                                <span class="mr-3">Exp: <span id="memberExpiredSimple"></span></span>
                                <span>Sisa: <span id="memberRemainingSimple"></span> hari</span>
                            </div>
                        </div>
                        <input type="hidden" id="memberIdSimple">
                    </div>
                </div>
            </div>

            <!-- CARD RINGKASAN PEMBAYARAN -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-6 border-b border-gray-100 bg-gradient-to-r from-yellow-50 to-white">
                    <div class="flex items-center">
                        <div class="w-10 h-10 bg-yellow-100 rounded-full flex items-center justify-center mr-3">
                            <i class="fas fa-money-bill-wave text-yellow-600"></i>
                        </div>
                        <div>
                            <h2 class="text-lg font-semibold text-gray-800">💰 Pembayaran</h2>
                            <p class="text-sm text-gray-500">Detail total pembayaran</p>
                        </div>
                    </div>
                </div>
                
                <div class="p-6">
                    <!-- Info Jenis Transaksi -->
                    <div id="infoJenisTransaksi" class="bg-purple-50 p-3 rounded-lg mb-4 hidden">
                        <p class="text-sm text-[#27124A]">
                            <span class="font-medium">Jenis:</span> 
                            <span id="jenisTransaksiText">-</span>
                        </p>
                    </div>

                    <!-- Rincian Biaya -->
                    <div class="space-y-3 mb-4">
                        <!-- Produk -->
                        <div id="subtotalProdukRow" class="flex justify-between items-center hidden">
                            <span class="text-gray-600">Subtotal Produk</span>
                            <span class="font-medium text-gray-800" id="subtotal">Rp 0</span>
                        </div>
                        
                        <!-- Visit -->
                        <div id="visitInfo" class="flex justify-between items-center hidden">
                            <span class="text-gray-600">Biaya Visit</span>
                            <span class="font-medium text-green-600" id="biayaVisit">Rp 0</span>
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
                    <input type="hidden" id="jenis_transaksi" name="jenis_transaksi" value="">

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
                            Proses Pembayaran
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
    <div class="bg-white rounded-2xl shadow-xl w-96 p-6 transform transition-all">
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
            <div class="flex gap-2">
                <button type="button" id="btnCetakStruk" 
                    class="flex-1 bg-[#27124A] hover:bg-[#3a1d6b] text-white font-semibold py-2.5 px-4 rounded-xl transition-all duration-300">
                    <i class="fas fa-print mr-2"></i>Cetak Struk
                </button>
                <a href="{{ route('kasir.transaksi.create') }}" 
                    class="flex-1 bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold py-2.5 px-4 rounded-xl transition-all duration-300 text-center">
                    Transaksi Baru
                </a>
            </div>
        </div>
    </div>
</div>

<!-- STYLES -->
<style>
    .jenis-transaksi-card {
        border-color: #e5e7eb;
        transition: all 0.3s ease;
    }
    .jenis-transaksi-card.selected {
        border-color: #27124A;
        background-color: #f5f3ff;
        transform: scale(1.02);
        box-shadow: 0 10px 25px -5px rgba(39, 18, 74, 0.1);
    }
    .jenis-transaksi-card.selected .w-16 {
        background-color: #27124A;
    }
    .jenis-transaksi-card.selected .w-16 i {
        color: white;
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
    console.log('✅ JavaScript Loaded!');
    
    // ============ STATE MANAGEMENT ============
    let cart = [];
    let selectedMember = null;
    let jenisTransaksi = '';

    // ============ DOM ELEMENTS ============
    const elements = {
        // Jenis Transaksi
        jenisCards: document.querySelectorAll('.jenis-transaksi-card'),
        jenisTransaksiInput: document.getElementById('jenis_transaksi'),
        infoJenisTransaksi: document.getElementById('infoJenisTransaksi'),
        jenisTransaksiText: document.getElementById('jenisTransaksiText'),
        
        // Sections
        produkSection: document.getElementById('produkSection'),
        cartSection: document.getElementById('cartSection'),
        visitSection: document.getElementById('visitSection'),
        
        // Products
        productCards: document.querySelectorAll('.product-card'),
        addToCartBtns: document.querySelectorAll('.add-to-cart-btn'),
        searchProduct: document.getElementById('searchProduct'),
        cartItems: document.getElementById('cartItems'),
        emptyCart: document.getElementById('emptyCart'),
        
        // Rincian & Total
        subtotal: document.getElementById('subtotal'),
        subtotalProdukRow: document.getElementById('subtotalProdukRow'),
        total: document.getElementById('total'),
        biayaVisit: document.getElementById('biayaVisit'),
        visitInfo: document.getElementById('visitInfo'),
        
        // Visit
        hargaVisit: document.getElementById('harga_visit'),
        tglVisit: document.getElementById('tgl_visit'),
        
        // Member (Sederhana)
        kodeMemberInput: document.getElementById('kode_member_input'),
        btnCekMember: document.getElementById('btnCekMember'),
        memberInfoSimple: document.getElementById('memberInfoSimple'),
        memberNameSimple: document.getElementById('memberNameSimple'),
        memberCodeSimple: document.getElementById('memberCodeSimple'),
        memberExpiredSimple: document.getElementById('memberExpiredSimple'),
        memberRemainingSimple: document.getElementById('memberRemainingSimple'),
        memberIdSimple: document.getElementById('memberIdSimple'),
        btnRemoveMemberSimple: document.getElementById('btnRemoveMemberSimple'),
        
        // Payment
        uangBayar: document.getElementById('uang_bayar'),
        uangKembali: document.getElementById('uang_kembali'),
        catatan: document.getElementById('catatan'),
        btnSimpan: document.getElementById('btnSimpan'),
        btnBatal: document.getElementById('btnBatal'),
        
        // Modal
        successModal: document.getElementById('successModal'),
        successMessage: document.getElementById('successMessage'),
        successNomor: document.getElementById('successNomor'),
        btnCetakStruk: document.getElementById('btnCetakStruk'),
        
        // Quick Amount
        quickAmounts: document.querySelectorAll('.quick-amount'),
        btnUangPas: document.getElementById('btnUangPas')
    };

    // ============ HELPER FUNCTIONS ============
    function formatCurrency(amount) {
        if (amount === undefined || amount === null) amount = 0;
        return 'Rp ' + new Intl.NumberFormat('id-ID').format(Math.round(amount));
    }

    function parseCurrency(value) {
        if (!value) return 0;
        const cleaned = value.toString().replace(/[^0-9]/g, '');
        return parseInt(cleaned) || 0;
    }

    // ============ JENIS TRANSAKSI ============
    function selectJenisTransaksi(jenis) {
        console.log('Select jenis:', jenis);
        
        // Remove selected class from all cards
        elements.jenisCards.forEach(card => {
            card.classList.remove('selected');
        });
        
        // Add selected class to current card
        const selectedCard = document.getElementById(`jenis-${jenis}`);
        if (selectedCard) {
            selectedCard.classList.add('selected');
        }
        
        jenisTransaksi = jenis;
        if (elements.jenisTransaksiInput) {
            elements.jenisTransaksiInput.value = jenis;
        }
        
        // Update text info
        const jenisLabels = {
            'produk': 'Produk Only',
            'visit': 'Visit Only',
            'produk_visit': 'Produk + Visit'
        };
        
        if (elements.jenisTransaksiText) {
            elements.jenisTransaksiText.textContent = jenisLabels[jenis] || jenis;
        }
        
        if (elements.infoJenisTransaksi) {
            elements.infoJenisTransaksi.classList.remove('hidden');
        }
        
        // Hide all sections first
        if (elements.produkSection) elements.produkSection.classList.add('hidden');
        if (elements.cartSection) elements.cartSection.classList.add('hidden');
        if (elements.visitSection) elements.visitSection.classList.add('hidden');
        
        // Show sections based on jenis
        if (jenis.includes('produk')) {
            if (elements.produkSection) elements.produkSection.classList.remove('hidden');
            if (elements.cartSection) elements.cartSection.classList.remove('hidden');
        }
        
        if (jenis.includes('visit')) {
            if (elements.visitSection) elements.visitSection.classList.remove('hidden');
        }
        
        // Reset cart if changing to non-produk type
        if (!jenis.includes('produk')) {
            cart = [];
            renderCart();
        }
        
        calculateTotals();
    }

    function calculateTotals() {
        console.log('Calculating totals...');
        
        const subtotalProduk = cart.reduce((sum, item) => sum + (item.harga * item.qty), 0);
        
        // Ambil harga visit
        const biayaVisit = (jenisTransaksi.includes('visit') && elements.hargaVisit) 
            ? parseFloat(elements.hargaVisit.value || 0) : 0;
        
        const total = subtotalProduk + biayaVisit;
        
        console.log('Totals:', { subtotalProduk, biayaVisit, total });
        
        // Update display subtotal produk
        if (elements.subtotalProdukRow && elements.subtotal) {
            if (subtotalProduk > 0) {
                elements.subtotalProdukRow.classList.remove('hidden');
                elements.subtotal.textContent = formatCurrency(subtotalProduk);
            } else {
                elements.subtotalProdukRow.classList.add('hidden');
            }
        }
        
        // Update display biaya visit
        if (elements.visitInfo && elements.biayaVisit) {
            if (biayaVisit > 0) {
                elements.visitInfo.classList.remove('hidden');
                elements.biayaVisit.textContent = formatCurrency(biayaVisit);
            } else {
                elements.visitInfo.classList.add('hidden');
            }
        }
        
        // Update total
        if (elements.total) {
            elements.total.textContent = formatCurrency(total);
        }
        
        return total;
    }

    function updateUangKembali() {
        if (!elements.uangBayar || !elements.uangKembali) {
            console.log('Element uangBayar atau uangKembali tidak ditemukan');
            return;
        }
        
        const total = calculateTotals();
        const uangBayar = parseCurrency(elements.uangBayar.value);
        const kembali = uangBayar - total;
        
        console.log('Update uang kembali:', { total, uangBayar, kembali });
        
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
                    <p class="text-gray-500 mb-1">Keranjang belanja kosong</p>
                    <p class="text-sm text-gray-400">Pilih produk di atas</p>
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
            
            // Event Listeners for cart
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
        if (btn && btn.classList.contains('add-to-cart-btn')) {
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

    // ============ PRODUCT SEARCH ============
    function filterProducts() {
        if (!elements.searchProduct) return;
        
        const search = elements.searchProduct.value.toLowerCase().trim();
        const cards = document.querySelectorAll('.product-card');
        
        cards.forEach(card => {
            const nama = card.dataset.nama.toLowerCase();
            if (nama.includes(search) || search === '') {
                card.style.display = 'block';
            } else {
                card.style.display = 'none';
            }
        });
    }

    // ============ MEMBER FUNCTIONS ============
    async function cekMember() {
        if (!elements.kodeMemberInput) return;
        
        const kode = elements.kodeMemberInput.value.trim();
        if (kode.length < 2) {
            alert('Masukkan minimal 2 karakter');
            return;
        }
        
        try {
            const response = await fetch(`{{ route("kasir.transaksi.cariMember") }}?search=${encodeURIComponent(kode)}`);
            const members = await response.json();
            
            if (members.length === 0) {
                alert('Member tidak ditemukan');
                return;
            }
            
            const activeMember = members.find(m => m.is_active);
            if (!activeMember) {
                alert('Member tidak aktif');
                return;
            }
            
            selectMemberSimple(activeMember);
            
        } catch (error) {
            console.error('Error:', error);
            alert('Gagal mencari member');
        }
    }

    function selectMemberSimple(member) {
        selectedMember = member;
        
        if (elements.memberIdSimple) elements.memberIdSimple.value = member.id;
        if (elements.memberNameSimple) elements.memberNameSimple.textContent = member.nama;
        if (elements.memberCodeSimple) elements.memberCodeSimple.textContent = member.kode || '-';
        if (elements.memberExpiredSimple) elements.memberExpiredSimple.textContent = member.expired || '-';
        if (elements.memberRemainingSimple) elements.memberRemainingSimple.textContent = member.sisa_hari || '0';
        if (elements.memberInfoSimple) elements.memberInfoSimple.classList.remove('hidden');
        if (elements.kodeMemberInput) elements.kodeMemberInput.value = '';
    }

    function removeMemberSimple() {
        selectedMember = null;
        
        if (elements.memberIdSimple) elements.memberIdSimple.value = '';
        if (elements.memberInfoSimple) elements.memberInfoSimple.classList.add('hidden');
    }

    // ============ SAVE TRANSACTION ============
    async function saveTransaction() {
        console.log('Saving transaction...');
        
        // Validasi jenis transaksi
        if (!jenisTransaksi) {
            alert('❌ Pilih jenis transaksi terlebih dahulu');
            return;
        }
        
        // Validasi keranjang untuk transaksi yang mengandung produk
        if (jenisTransaksi.includes('produk') && cart.length === 0) {
            alert('❌ Keranjang belanja masih kosong');
            return;
        }
        
        // Validasi visit
        if (jenisTransaksi.includes('visit') && elements.tglVisit && !elements.tglVisit.value) {
            alert('❌ Tanggal visit harus diisi');
            elements.tglVisit.focus();
            return;
        }
        
        const total = calculateTotals();
        const uangBayar = elements.uangBayar ? parseCurrency(elements.uangBayar.value) : 0;
        
        console.log('Payment validation:', { total, uangBayar });
        
        // Validasi pembayaran
        if (uangBayar === 0) {
            alert('❌ Masukkan jumlah uang bayar');
            if (elements.uangBayar) elements.uangBayar.focus();
            return;
        }
        
        if (uangBayar < total) {
            alert('❌ Uang bayar kurang dari total belanja');
            if (elements.uangBayar) elements.uangBayar.focus();
            return;
        }
        
        // Prepare data
        const data = {
            jenis_transaksi: jenisTransaksi,
            items: cart.map(i => ({ product_id: i.id, qty: i.qty })),
            total_harga: total,
            uang_bayar: uangBayar,
            uang_kembali: uangBayar - total,
            metode_bayar: 'cash',
            member_id: selectedMember?.id || null,
            catatan: elements.catatan?.value || '',
            _token: '{{ csrf_token() }}'
        };
        
        // Tambah data visit
        if (jenisTransaksi.includes('visit') && elements.hargaVisit && elements.tglVisit) {
            data.harga_visit = parseFloat(elements.hargaVisit.value);
            data.tgl_visit = elements.tglVisit.value;
        }
        
        console.log('Sending data:', data);
        
        // Disable button
        if (elements.btnSimpan) {
            elements.btnSimpan.disabled = true;
            elements.btnSimpan.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Memproses...';
        }
        
        try {
            const response = await fetch('{{ route("kasir.transaksi.store") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify(data)
            });
            
            const result = await response.json();
            console.log('Response:', result);
            
            if (result.success) {
                const jenisText = {
                    'produk': 'Pembelian produk berhasil!',
                    'visit': 'Visit berhasil dicatat!',
                    'produk_visit': 'Transaksi produk + visit berhasil!'
                };
                
                if (elements.successMessage) {
                    elements.successMessage.textContent = jenisText[result.jenis_transaksi] || 'Transaksi berhasil!';
                }
                
                if (elements.successNomor) {
                    elements.successNomor.textContent = result.nomor_unik;
                }
                
                if (elements.successModal) {
                    elements.successModal.classList.remove('hidden');
                    elements.successModal.style.display = 'flex';
                }
                
                // Set struk URL
                if (result.transaction_id && elements.btnCetakStruk) {
                    elements.btnCetakStruk.onclick = () => {
                        window.open(`{{ url("kasir/transaksi") }}/${result.transaction_id}/struk`, '_blank');
                    };
                }
                
                // Reset setelah 2 detik
                setTimeout(() => {
                    resetForm();
                }, 2000);
                
            } else {
                alert('❌ Error: ' + (result.message || 'Terjadi kesalahan'));
            }
        } catch (error) {
            console.error('Error:', error);
            alert('❌ Gagal memproses transaksi: ' + error.message);
        } finally {
            if (elements.btnSimpan) {
                elements.btnSimpan.disabled = false;
                elements.btnSimpan.innerHTML = '<i class="fas fa-check-circle mr-2"></i> Proses Pembayaran';
            }
        }
    }

    function resetForm() {
        cart = [];
        selectedMember = null;
        jenisTransaksi = '';
        renderCart();
        removeMemberSimple();
        
        if (elements.uangBayar) elements.uangBayar.value = '';
        if (elements.catatan) elements.catatan.value = '';
        
        updateUangKembali();
        
        // Reset selections
        if (elements.jenisCards) {
            elements.jenisCards.forEach(card => {
                card.classList.remove('selected');
            });
        }
        
        if (elements.produkSection) elements.produkSection.classList.add('hidden');
        if (elements.cartSection) elements.cartSection.classList.add('hidden');
        if (elements.visitSection) elements.visitSection.classList.add('hidden');
        if (elements.infoJenisTransaksi) elements.infoJenisTransaksi.classList.add('hidden');
        
        // Reset visit
        if (elements.tglVisit) {
            const now = new Date();
            const year = now.getFullYear();
            const month = String(now.getMonth() + 1).padStart(2, '0');
            const day = String(now.getDate()).padStart(2, '0');
            const hours = String(now.getHours()).padStart(2, '0');
            const minutes = String(now.getMinutes()).padStart(2, '0');
            elements.tglVisit.value = `${year}-${month}-${day}T${hours}:${minutes}`;
        }
    }

    // ============ EVENT LISTENERS ============
    
    // Jenis transaksi click
    if (elements.jenisCards.length > 0) {
        elements.jenisCards.forEach(card => {
            card.addEventListener('click', function() {
                const jenis = this.dataset.jenis;
                selectJenisTransaksi(jenis);
            });
        });
    }
    
    // Add to cart from product grid
    if (elements.addToCartBtns.length > 0) {
        elements.addToCartBtns.forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                
                if (!jenisTransaksi.includes('produk')) {
                    alert('❌ Pilih jenis transaksi yang mengandung produk terlebih dahulu');
                    return;
                }
                
                const product = {
                    id: parseInt(this.dataset.id),
                    nama: this.dataset.nama,
                    harga: parseFloat(this.dataset.harga),
                    stok: parseInt(this.dataset.stok)
                };
                
                if (product.stok > 0) {
                    addToCart(product);
                }
            });
        });
    }
    
    // Click on product card
    if (elements.productCards.length > 0) {
        elements.productCards.forEach(card => {
            card.addEventListener('click', function(e) {
                if (e.target.closest('button')) return;
                
                if (!jenisTransaksi.includes('produk')) {
                    alert('❌ Pilih jenis transaksi yang mengandung produk terlebih dahulu');
                    return;
                }
                
                const product = {
                    id: parseInt(this.dataset.id),
                    nama: this.dataset.nama,
                    harga: parseFloat(this.dataset.harga),
                    stok: parseInt(this.dataset.stok)
                };
                
                if (product.stok > 0) {
                    addToCart(product);
                }
            });
        });
    }
    
    // Product search
    if (elements.searchProduct) {
        elements.searchProduct.addEventListener('input', filterProducts);
    }
    
    // Member
    if (elements.btnCekMember) {
        elements.btnCekMember.addEventListener('click', function(e) {
            e.preventDefault();
            cekMember();
        });
    }
    
    if (elements.kodeMemberInput) {
        elements.kodeMemberInput.addEventListener('keypress', e => {
            if (e.key === 'Enter') {
                e.preventDefault();
                cekMember();
            }
        });
    }
    
    if (elements.btnRemoveMemberSimple) {
        elements.btnRemoveMemberSimple.addEventListener('click', function(e) {
            e.preventDefault();
            removeMemberSimple();
        });
    }
    
    // Payment
    if (elements.uangBayar) {
        elements.uangBayar.addEventListener('input', function() {
            console.log('Uang bayar changed:', this.value);
            updateUangKembali();
        });
        
        // Format input untuk hanya angka
        elements.uangBayar.addEventListener('keypress', function(e) {
            if (!/[\d]/.test(e.key)) {
                e.preventDefault();
            }
        });
    }
    
    if (elements.quickAmounts.length > 0) {
        elements.quickAmounts.forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                if (elements.uangBayar) {
                    elements.uangBayar.value = this.dataset.amount;
                    updateUangKembali();
                }
            });
        });
    }
    
    if (elements.btnUangPas) {
        elements.btnUangPas.addEventListener('click', function(e) {
            e.preventDefault();
            const total = calculateTotals();
            if (elements.uangBayar) {
                elements.uangBayar.value = total;
                updateUangKembali();
            }
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
            if (cart.length === 0 && !selectedMember && !jenisTransaksi) {
                window.location.href = '{{ route("kasir.transaksi.index") }}';
                return;
            }
            if (confirm('Batalkan transaksi? Semua data akan hilang.')) {
                resetForm();
            }
        });
    }
    
    // Click outside to close modal
    if (elements.successModal) {
        elements.successModal.addEventListener('click', function(e) {
            if (e.target === this) {
                this.style.display = 'none';
                this.classList.add('hidden');
            }
        });
    }
    
    // Initialize
    console.log('Initialization complete');
    renderCart();
});
</script>
@endsection