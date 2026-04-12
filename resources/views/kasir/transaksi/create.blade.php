@extends('layouts.app')

@section('title', 'Transaksi Baru')
@section('page-title', 'Transaksi Baru')

@section('sidebar')
    @include('kasir.partials.sidebar')
@endsection

@section('content')
<div class="space-y-6 w-full max-w-full">

    {{-- ===================== PAGE HEADER ===================== --}}
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3">
        <div class="flex items-center gap-3">
            <a href="{{ route('kasir.transaksi.index') }}"
               class="inline-flex items-center gap-2 px-4 py-2 bg-white hover:bg-gray-50 text-gray-700 rounded-xl text-sm font-medium border border-gray-200 shadow-sm transition-all duration-200">
                <i class="fas fa-arrow-left text-xs"></i>
                Kembali
            </a>
            <h1 class="text-xl font-bold text-gray-800">Transaksi Baru</h1>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('kasir.transaksi.membership.create') }}"
               class="inline-flex items-center gap-2 px-4 py-2 bg-[#27124A] hover:bg-[#3a1d6b] text-white text-sm font-medium rounded-xl transition-all duration-200 shadow-sm">
                <i class="fas fa-id-card"></i>
                Transaksi Membership
            </a>
            <div class="bg-[#27124A]/10 text-[#27124A] px-4 py-2 rounded-xl border border-[#27124A]/20">
                <span class="font-mono font-bold text-base">{{ $nomorUnik }}</span>
            </div>
        </div>
    </div>

    {{-- ===================== MAIN GRID ===================== --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- ============ KOLOM KIRI (span 2) ============ --}}
        <div class="lg:col-span-2 space-y-6">

            {{-- ---- CARD: PILIH JENIS TRANSAKSI ---- --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-6 py-4 border-b border-[#27124A]/10 bg-gradient-to-r from-[#27124A]/5 to-white">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-[#27124A]/10 rounded-xl flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-tags text-[#27124A]"></i>
                        </div>
                        <div>
                            <h2 class="text-base font-semibold text-gray-800">Pilih Jenis Transaksi</h2>
                            <p class="text-sm text-gray-500">Klik salah satu untuk memulai</p>
                        </div>
                    </div>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">

                        {{-- Produk Only --}}
                        <div class="jenis-transaksi-card group border-2 border-gray-200 rounded-xl p-5 cursor-pointer transition-all duration-200 hover:border-[#27124A] hover:bg-[#27124A]/5 text-center"
                             data-jenis="produk" id="jenis-produk">
                            <div class="w-14 h-14 bg-[#27124A]/10 rounded-full flex items-center justify-center mx-auto mb-3 transition-colors duration-200">
                                <i class="fas fa-box text-xl text-[#27124A]"></i>
                            </div>
                            <h3 class="font-semibold text-gray-800 text-sm mb-1">Produk Only</h3>
                            <p class="text-xs text-gray-500 mb-3">Pembelian produk saja</p>
                            <span class="text-xs px-3 py-1 bg-[#27124A]/10 text-[#27124A] rounded-full font-medium">Klik untuk mulai</span>
                        </div>

                        {{-- Visit Only --}}
                        <div class="jenis-transaksi-card group border-2 border-gray-200 rounded-xl p-5 cursor-pointer transition-all duration-200 hover:border-[#27124A] hover:bg-[#27124A]/5 text-center"
                             data-jenis="visit" id="jenis-visit">
                            <div class="w-14 h-14 bg-[#27124A]/10 rounded-full flex items-center justify-center mx-auto mb-3 transition-colors duration-200">
                                <i class="fas fa-walking text-xl text-[#27124A]"></i>
                            </div>
                            <h3 class="font-semibold text-gray-800 text-sm mb-1">Visit Only</h3>
                            <p class="text-xs text-gray-500 mb-3">Visit harian gym</p>
                            <span class="text-xs px-3 py-1 bg-[#27124A]/10 text-[#27124A] rounded-full font-medium">Klik untuk mulai</span>
                        </div>

                        {{-- Produk + Visit --}}
                        <div class="jenis-transaksi-card group border-2 border-gray-200 rounded-xl p-5 cursor-pointer transition-all duration-200 hover:border-[#27124A] hover:bg-[#27124A]/5 text-center"
                             data-jenis="produk_visit" id="jenis-produk-visit">
                            <div class="w-14 h-14 bg-[#27124A]/10 rounded-full flex items-center justify-center mx-auto mb-3 transition-colors duration-200">
                                <i class="fas fa-layer-group text-xl text-[#27124A]"></i>
                            </div>
                            <h3 class="font-semibold text-gray-800 text-sm mb-1">Produk + Visit</h3>
                            <p class="text-xs text-gray-500 mb-3">Produk sekaligus visit</p>
                            <span class="text-xs px-3 py-1 bg-[#27124A]/10 text-[#27124A] rounded-full font-medium">Klik untuk mulai</span>
                        </div>

                    </div>
                </div>
            </div>

            {{-- ---- CARD: DAFTAR PRODUK ---- --}}
            <div id="produkSection" class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hidden">
                <div class="px-6 py-4 border-b border-[#27124A]/10 bg-gradient-to-r from-[#27124A]/5 to-white">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-[#27124A]/10 rounded-xl flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-box text-[#27124A]"></i>
                        </div>
                        <div>
                            <h2 class="text-base font-semibold text-gray-800">Daftar Produk</h2>
                            <p class="text-sm text-gray-500">Klik produk atau tombol tambah untuk memasukkan ke keranjang</p>
                        </div>
                    </div>
                </div>

                {{-- Search --}}
                <div class="px-6 pt-5">
                    <div class="relative">
                        <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-[#27124A]/40 text-sm"></i>
                        <input type="text" id="searchProduct"
                            class="w-full border border-gray-200 rounded-xl pl-11 pr-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-[#27124A]/20 focus:border-[#27124A] transition-all text-sm"
                            placeholder="Cari nama produk...">
                    </div>
                </div>

                {{-- Grid Produk --}}
                <div class="p-6">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 max-h-[420px] overflow-y-auto pr-1 custom-scrollbar">
                        @forelse($products as $product)
                        <div class="product-card group bg-white border border-gray-200 rounded-xl hover:shadow-md hover:border-[#27124A]/30 transition-all duration-200 cursor-pointer"
                             data-id="{{ $product->id }}"
                             data-nama="{{ $product->nama_produk }}"
                             data-harga="{{ $product->harga }}"
                             data-stok="{{ $product->stok }}">
                            <div class="p-4">
                                <div class="flex justify-between items-start mb-2">
                                    <div class="flex-1 min-w-0 pr-2">
                                        <h3 class="font-semibold text-gray-800 group-hover:text-[#27124A] text-sm truncate">{{ $product->nama_produk }}</h3>
                                        <p class="text-xs text-gray-400 mt-0.5">{{ $product->category->nama_kategori ?? 'Umum' }}</p>
                                    </div>
                                    @if($product->stok > 0)
                                        <span class="text-xs px-2 py-1 {{ $product->stok <= 5 ? 'bg-amber-100 text-amber-700' : 'bg-[#27124A]/10 text-[#27124A]' }} rounded-lg font-medium flex-shrink-0">
                                            Stok: {{ $product->stok }}
                                        </span>
                                    @else
                                        <span class="text-xs px-2 py-1 bg-red-100 text-red-700 rounded-lg font-medium flex-shrink-0">Habis</span>
                                    @endif
                                </div>
                                <p class="text-base font-bold text-[#27124A] mb-3">Rp {{ number_format($product->harga, 0, ',', '.') }}</p>
                                @if($product->stok > 0)
                                <button type="button"
                                        class="add-to-cart-btn w-full inline-flex items-center justify-center gap-2 bg-[#27124A]/10 hover:bg-[#27124A] text-[#27124A] hover:text-white font-medium py-2 px-3 rounded-xl text-sm transition-all duration-200 border border-[#27124A]/20"
                                        data-id="{{ $product->id }}"
                                        data-nama="{{ $product->nama_produk }}"
                                        data-harga="{{ $product->harga }}"
                                        data-stok="{{ $product->stok }}">
                                    <i class="fas fa-cart-plus text-xs"></i>
                                    Tambah
                                </button>
                                @else
                                <button type="button" class="w-full inline-flex items-center justify-center gap-2 bg-gray-100 text-gray-400 font-medium py-2 px-3 rounded-xl text-sm cursor-not-allowed" disabled>
                                    <i class="fas fa-times-circle text-xs"></i>
                                    Stok Habis
                                </button>
                                @endif
                            </div>
                        </div>
                        @empty
                        <div class="col-span-2 text-center py-10">
                            <div class="inline-flex items-center justify-center w-16 h-16 bg-[#27124A]/10 rounded-full mb-3">
                                <i class="fas fa-box-open text-2xl text-[#27124A]"></i>
                            </div>
                            <h4 class="font-semibold text-gray-800 mb-1">Belum Ada Produk</h4>
                            <p class="text-sm text-gray-400">Tidak ada produk tersedia saat ini</p>
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>

            {{-- ---- CARD: KERANJANG ---- --}}
            <div id="cartSection" class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hidden">
                <div class="px-6 py-4 border-b border-[#27124A]/10 bg-gradient-to-r from-[#27124A]/5 to-white">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-[#27124A]/10 rounded-xl flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-shopping-cart text-[#27124A]"></i>
                            </div>
                            <div>
                                <h2 class="text-base font-semibold text-gray-800">Keranjang Belanja</h2>
                                <p class="text-sm text-gray-500">Daftar produk yang akan dibeli</p>
                            </div>
                        </div>
                        <div id="cartCount" class="text-xs bg-[#27124A] text-white px-2.5 py-1 rounded-full hidden font-semibold">0</div>
                    </div>
                </div>
                <div class="p-6">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-100 text-sm">
                            <thead>
                                <tr class="bg-[#27124A]/5">
                                    <th class="px-4 py-3 text-left text-xs font-semibold text-[#27124A] uppercase tracking-wide">Produk</th>
                                    <th class="px-4 py-3 text-left text-xs font-semibold text-[#27124A] uppercase tracking-wide">Harga</th>
                                    <th class="px-4 py-3 text-left text-xs font-semibold text-[#27124A] uppercase tracking-wide">Qty</th>
                                    <th class="px-4 py-3 text-left text-xs font-semibold text-[#27124A] uppercase tracking-wide">Subtotal</th>
                                    <th class="px-4 py-3 text-center text-xs font-semibold text-[#27124A] uppercase tracking-wide">Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="cartItems" class="bg-white divide-y divide-gray-100">
                                <tr id="emptyCart">
                                    <td colspan="5" class="px-4 py-10 text-center">
                                        <div class="inline-flex items-center justify-center w-14 h-14 bg-[#27124A]/10 rounded-full mb-3">
                                            <i class="fas fa-shopping-cart text-xl text-[#27124A]/40"></i>
                                        </div>
                                        <p class="text-gray-500 text-sm mb-1">Keranjang belanja kosong</p>
                                        <p class="text-xs text-gray-400">Pilih produk di atas</p>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            {{-- ---- CARD: DATA VISIT ---- --}}
            <div id="visitSection" class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hidden">
                <div class="px-6 py-4 border-b border-[#27124A]/10 bg-gradient-to-r from-[#27124A]/5 to-white">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-[#27124A]/10 rounded-xl flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-walking text-[#27124A]"></i>
                        </div>
                        <div>
                            <h2 class="text-base font-semibold text-gray-800">Data Visit</h2>
                            <p class="text-sm text-gray-500">Visit hanya untuk HARI INI (tidak bisa booking)</p>
                        </div>
                    </div>
                </div>
                <div class="p-6 space-y-4">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">

                        {{-- Harga Visit --}}
                        <div class="bg-[#27124A]/5 rounded-xl p-5 border border-[#27124A]/15">
                            <div class="flex items-start justify-between">
                                <div>
                                    <p class="text-xs text-[#27124A] uppercase tracking-wide font-semibold mb-1">Harga Visit</p>
                                    <div class="text-2xl font-bold text-[#27124A]">Rp {{ number_format($hargaVisit ?? 25000, 0, ',', '.') }}</div>
                                    <p class="text-xs text-gray-500 mt-2 flex items-center gap-1">
                                        <i class="fas fa-info-circle text-[#27124A]/60"></i>
                                        Harga diatur oleh admin
                                    </p>
                                </div>
                                <div class="w-11 h-11 bg-[#27124A]/10 rounded-full flex items-center justify-center flex-shrink-0">
                                    <i class="fas fa-tag text-[#27124A] text-lg"></i>
                                </div>
                            </div>
                            <input type="hidden" id="harga_visit" value="{{ $hargaVisit ?? 25000 }}">
                        </div>

                        {{-- Tanggal Visit --}}
                        <div class="bg-amber-50 rounded-xl p-5 border border-amber-100">
                            <div class="flex items-start justify-between">
                                <div class="flex-1 min-w-0 pr-3">
                                    <p class="text-xs text-amber-700 uppercase tracking-wide font-semibold mb-1">Tanggal & Jam Visit</p>
                                    <div class="text-sm font-semibold text-amber-800 mb-2" id="currentDateTimeDisplay"></div>
                                    <div class="flex items-center gap-2 text-xs text-amber-700 bg-amber-100/60 p-2 rounded-lg">
                                        <i class="fas fa-exclamation-triangle flex-shrink-0"></i>
                                        <span>Hanya untuk HARI INI, tidak bisa booking!</span>
                                    </div>
                                </div>
                                <div class="w-11 h-11 bg-yellow-100 rounded-full flex items-center justify-center flex-shrink-0">
                                    <i class="fas fa-calendar-alt text-yellow-600 text-lg"></i>
                                </div>
                            </div>
                            <input type="datetime-local" id="tgl_visit"
                                class="w-full mt-3 border border-gray-200 rounded-xl px-4 py-2.5 text-sm bg-gray-50 cursor-not-allowed focus:outline-none"
                                readonly>
                        </div>
                    </div>

                    {{-- Kebijakan Visit --}}
                    <div class="bg-red-50 rounded-xl p-4 border border-red-200">
                        <div class="flex items-start gap-3">
                            <div class="w-8 h-8 bg-red-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-clock text-red-500 text-sm"></i>
                            </div>
                            <div>
                                <p class="text-sm font-semibold text-red-700 mb-1">Kebijakan Visit</p>
                                <p class="text-xs text-red-600">Member hanya bisa melakukan visit pada <strong>HARI INI</strong> dan <strong>TIDAK BISA</strong> booking untuk tanggal lain. Jam operasional: <strong>06:00 – 22:00 WIB</strong>.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>{{-- end kolom kiri --}}

        {{-- ============ KOLOM KANAN (span 1) ============ --}}
        <div class="lg:col-span-1">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden sticky top-6">

                {{-- Card Header --}}
                <div class="px-6 py-4 border-b border-[#27124A]/10 bg-gradient-to-r from-[#27124A]/5 to-white">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-[#27124A]/10 rounded-xl flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-money-bill-wave text-[#27124A]"></i>
                        </div>
                        <div>
                            <h2 class="text-base font-semibold text-gray-800">Ringkasan Pembayaran</h2>
                            <p class="text-sm text-gray-500">Detail total pembayaran</p>
                        </div>
                    </div>
                </div>

                <div class="p-6 space-y-5">

                    {{-- Jenis Transaksi Badge --}}
                    <div id="infoJenisTransaksi" class="hidden">
                        <div class="bg-[#27124A]/10 border border-[#27124A]/20 rounded-xl px-4 py-2.5 flex items-center gap-2">
                            <i class="fas fa-tag text-[#27124A] text-sm"></i>
                            <span class="text-sm text-[#27124A] font-medium">Jenis: <span id="jenisTransaksiText" class="font-bold"></span></span>
                        </div>
                    </div>

                    {{-- Rincian Biaya --}}
                    <div class="space-y-2 border-b border-gray-100 pb-4">
                        <div id="subtotalProdukRow" class="flex justify-between items-center hidden">
                            <span class="text-sm text-gray-600">Subtotal Produk</span>
                            <span class="text-sm font-semibold text-gray-800" id="subtotal">Rp 0</span>
                        </div>
                        <div id="visitInfo" class="flex justify-between items-center hidden">
                            <span class="text-sm text-gray-600">Biaya Visit</span>
                            <span class="text-sm font-semibold text-[#27124A]" id="biayaVisit">Rp 0</span>
                        </div>
                    </div>

                    {{-- Total --}}
                    <div class="bg-[#27124A] rounded-xl px-4 py-3 flex justify-between items-center">
                        <span class="font-bold text-white/80 text-sm">TOTAL</span>
                        <span class="font-bold text-2xl text-white" id="total">Rp 0</span>
                    </div>

                    <input type="hidden" id="jenis_transaksi" name="jenis_transaksi" value="">

                    {{-- Uang Bayar --}}
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wide mb-1.5">Uang Bayar</label>
                        <div class="relative">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-500 font-medium text-sm">Rp</span>
                            <input type="text" id="uang_bayar"
                                class="w-full pl-11 pr-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#27124A]/20 focus:border-[#27124A] transition-all text-lg font-semibold"
                                placeholder="0">
                        </div>
                        <div class="grid grid-cols-3 gap-2 mt-3">
                            <button type="button" class="quick-amount bg-gray-100 hover:bg-[#27124A]/10 hover:text-[#27124A] text-gray-600 py-2 rounded-lg text-sm font-medium transition-all" data-amount="50000">50K</button>
                            <button type="button" class="quick-amount bg-gray-100 hover:bg-[#27124A]/10 hover:text-[#27124A] text-gray-600 py-2 rounded-lg text-sm font-medium transition-all" data-amount="100000">100K</button>
                            <button type="button" class="quick-amount bg-gray-100 hover:bg-[#27124A]/10 hover:text-[#27124A] text-gray-600 py-2 rounded-lg text-sm font-medium transition-all" data-amount="200000">200K</button>
                            <button type="button" class="quick-amount bg-gray-100 hover:bg-[#27124A]/10 hover:text-[#27124A] text-gray-600 py-2 rounded-lg text-sm font-medium transition-all" data-amount="500000">500K</button>
                            <button type="button" class="quick-amount bg-gray-100 hover:bg-[#27124A]/10 hover:text-[#27124A] text-gray-600 py-2 rounded-lg text-sm font-medium transition-all" data-amount="1000000">1JT</button>
                            <button type="button" id="btnUangPas" class="bg-[#27124A]/10 hover:bg-[#27124A] text-[#27124A] hover:text-white py-2 rounded-lg text-sm font-medium transition-all border border-[#27124A]/20">
                                Uang Pas
                            </button>
                        </div>
                    </div>

                    {{-- Uang Kembali --}}
                    <div class="bg-gray-50 rounded-xl px-4 py-3 flex justify-between items-center">
                        <span class="text-sm font-medium text-gray-700">Uang Kembali</span>
                        <span class="font-bold text-xl text-green-600" id="uang_kembali">Rp 0</span>
                    </div>

                    {{-- Catatan --}}
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wide mb-1.5">Catatan <span class="text-gray-400 font-normal normal-case">(Opsional)</span></label>
                        <textarea id="catatan" rows="2"
                            class="w-full border border-gray-200 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-[#27124A]/20 focus:border-[#27124A] transition-all text-sm resize-none"
                            placeholder="Tambahkan catatan..."></textarea>
                    </div>

                    {{-- Tombol Aksi --}}
                    <div class="space-y-2.5">
                        <button type="button" id="btnSimpan"
                            class="w-full inline-flex items-center justify-center gap-2 bg-[#27124A] hover:bg-[#3a1d6b] text-white font-semibold py-3.5 px-4 rounded-xl transition-all duration-200 shadow-sm hover:shadow-md">
                            <i class="fas fa-check-circle"></i>
                            Proses Pembayaran
                        </button>
                        <button type="button" id="btnBatal"
                            class="w-full inline-flex items-center justify-center gap-2 bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold py-3.5 px-4 rounded-xl transition-all duration-200">
                            <i class="fas fa-times-circle"></i>
                            Batalkan
                        </button>
                    </div>

                </div>
            </div>
        </div>{{-- end kolom kanan --}}

    </div>
</div>

{{-- ===================== MODAL SUKSES ===================== --}}
<div id="successModal" class="fixed inset-0 bg-black/60 hidden items-center justify-center z-50 p-4">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-sm animate-fade-in-up overflow-hidden">
        <div class="h-1.5 bg-gradient-to-r from-[#27124A] to-[#6d3ea0]"></div>
        <div class="p-7 text-center">
            <div class="mx-auto w-20 h-20 rounded-full bg-[#27124A]/10 border-2 border-[#27124A]/20 flex items-center justify-center mb-4">
                <i class="fas fa-check-circle text-[#27124A] text-4xl"></i>
            </div>
            <h3 class="text-xl font-bold text-gray-900 mb-1">Transaksi Berhasil!</h3>
            <p class="text-gray-500 text-sm mb-5" id="successMessage"></p>
            <div class="bg-[#27124A]/5 border border-[#27124A]/15 rounded-xl p-4 mb-6">
                <p class="text-xs text-gray-400 uppercase tracking-wide mb-1">No. Transaksi</p>
                <p class="text-lg font-mono font-bold text-[#27124A]" id="successNomor"></p>
            </div>
            <div class="flex gap-2">
                <button type="button" id="btnCetakStruk"
                    class="flex-1 inline-flex items-center justify-center gap-2 bg-[#27124A] hover:bg-[#3a1d6b] text-white font-semibold py-2.5 px-4 rounded-xl transition-all duration-200">
                    <i class="fas fa-print text-sm"></i>
                    Cetak Struk
                </button>
                <a href="{{ route('kasir.transaksi.create') }}"
                    class="flex-1 inline-flex items-center justify-center gap-2 bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold py-2.5 px-4 rounded-xl transition-all duration-200">
                    <i class="fas fa-plus text-sm"></i>
                    Transaksi Baru
                </a>
            </div>
        </div>
    </div>
</div>

<style>
    .jenis-transaksi-card.selected {
        border-color: #27124A;
        background: linear-gradient(135deg, #f5f3ff 0%, #fdfcff 100%);
        transform: translateY(-3px);
        box-shadow: 0 8px 24px -4px rgba(39, 18, 74, 0.18);
    }
    .jenis-transaksi-card.selected .w-14 { background-color: #27124A; }
    .jenis-transaksi-card.selected .w-14 i { color: white; }
    .jenis-transaksi-card.selected span.rounded-full { background-color: #27124A; color: white; }
    .cart-item td {
        padding: 0.75rem;
        vertical-align: middle;
    }
    .qty-btn {
        width: 30px; height: 30px;
        display: flex; align-items: center; justify-content: center;
        background-color: #f3f4f6;
        border: 1px solid #e5e7eb;
        color: #4b5563;
        font-weight: bold;
        cursor: pointer;
        transition: background-color 0.15s;
    }
    .qty-btn:hover { background-color: #27124A; color: white; border-color: #27124A; }
    .qty-input {
        width: 46px; height: 30px;
        text-align: center;
        border-top: 1px solid #e5e7eb;
        border-bottom: 1px solid #e5e7eb;
        border-left: none; border-right: none;
        -moz-appearance: textfield;
        font-size: 13px;
    }
    .qty-input::-webkit-outer-spin-button,
    .qty-input::-webkit-inner-spin-button { -webkit-appearance: none; margin: 0; }
    .custom-scrollbar::-webkit-scrollbar { width: 5px; }
    .custom-scrollbar::-webkit-scrollbar-track { background: #f1f1f1; border-radius: 10px; }
    .custom-scrollbar::-webkit-scrollbar-thumb { background: rgba(39,18,74,0.25); border-radius: 10px; }
    .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: rgba(39,18,74,0.5); }
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(24px) scale(0.97); }
        to   { opacity: 1; transform: translateY(0) scale(1); }
    }
    .animate-fade-in-up { animation: fadeInUp 0.3s ease-out; }
    @media (max-width: 640px) {
        .qty-input { width: 38px; }
        .qty-btn { width: 26px; height: 26px; }
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {

    // ============ STATE ============
    let cart = [];
    let jenisTransaksi = '';

    // ============ DOM ELEMENTS ============
    const elements = {
        jenisCards:          document.querySelectorAll('.jenis-transaksi-card'),
        jenisTransaksiInput: document.getElementById('jenis_transaksi'),
        infoJenisTransaksi:  document.getElementById('infoJenisTransaksi'),
        jenisTransaksiText:  document.getElementById('jenisTransaksiText'),
        produkSection:       document.getElementById('produkSection'),
        cartSection:         document.getElementById('cartSection'),
        visitSection:        document.getElementById('visitSection'),
        productCards:        document.querySelectorAll('.product-card'),
        addToCartBtns:       document.querySelectorAll('.add-to-cart-btn'),
        searchProduct:       document.getElementById('searchProduct'),
        cartItems:           document.getElementById('cartItems'),
        cartCount:           document.getElementById('cartCount'),
        subtotal:            document.getElementById('subtotal'),
        subtotalProdukRow:   document.getElementById('subtotalProdukRow'),
        total:               document.getElementById('total'),
        biayaVisit:          document.getElementById('biayaVisit'),
        visitInfo:           document.getElementById('visitInfo'),
        hargaVisit:          document.getElementById('harga_visit'),
        tglVisit:            document.getElementById('tgl_visit'),
        currentDateTimeDisplay: document.getElementById('currentDateTimeDisplay'),
        uangBayar:           document.getElementById('uang_bayar'),
        uangKembali:         document.getElementById('uang_kembali'),
        catatan:             document.getElementById('catatan'),
        btnSimpan:           document.getElementById('btnSimpan'),
        btnBatal:            document.getElementById('btnBatal'),
        successModal:        document.getElementById('successModal'),
        successMessage:      document.getElementById('successMessage'),
        successNomor:        document.getElementById('successNomor'),
        btnCetakStruk:       document.getElementById('btnCetakStruk'),
        quickAmounts:        document.querySelectorAll('.quick-amount'),
        btnUangPas:          document.getElementById('btnUangPas')
    };

    // ============ HELPERS ============
    function formatCurrency(amount) {
        return 'Rp ' + new Intl.NumberFormat('id-ID').format(Math.round(amount || 0));
    }
    function parseCurrency(value) {
        return parseInt((value || '').toString().replace(/[^0-9]/g, '')) || 0;
    }

    function setCurrentDateTimeForVisit() {
        if (!elements.tglVisit) return;
        const now = new Date();
        const pad = n => String(n).padStart(2, '0');
        elements.tglVisit.value = `${now.getFullYear()}-${pad(now.getMonth()+1)}-${pad(now.getDate())}T${pad(now.getHours())}:${pad(now.getMinutes())}`;
        if (elements.currentDateTimeDisplay) {
            elements.currentDateTimeDisplay.textContent = now.toLocaleDateString('id-ID', {
                weekday: 'long', year: 'numeric', month: 'long', day: 'numeric', hour: '2-digit', minute: '2-digit'
            });
        }
    }

    function updateCartCount() {
        const total = cart.reduce((s, i) => s + i.qty, 0);
        if (elements.cartCount) {
            elements.cartCount.textContent = total;
            elements.cartCount.classList.toggle('hidden', total === 0);
        }
    }

    function calculateTotals() {
        const subtotalProduk = cart.reduce((s, i) => s + i.harga * i.qty, 0);
        const biayaVisit = (jenisTransaksi.includes('visit') && elements.hargaVisit)
            ? parseFloat(elements.hargaVisit.value || 0) : 0;
        const total = subtotalProduk + biayaVisit;

        if (elements.subtotalProdukRow) elements.subtotalProdukRow.classList.toggle('hidden', subtotalProduk === 0);
        if (elements.subtotal)         elements.subtotal.textContent = formatCurrency(subtotalProduk);
        if (elements.visitInfo)        elements.visitInfo.classList.toggle('hidden', biayaVisit === 0);
        if (elements.biayaVisit)       elements.biayaVisit.textContent = formatCurrency(biayaVisit);
        if (elements.total)            elements.total.textContent = formatCurrency(total);
        return total;
    }

    function updateUangKembali() {
        if (!elements.uangBayar || !elements.uangKembali) return;
        const total    = calculateTotals();
        const bayar    = parseCurrency(elements.uangBayar.value);
        const kembali  = bayar - total;
        if (bayar === 0) {
            elements.uangKembali.textContent = formatCurrency(0);
            elements.uangKembali.className = 'font-bold text-xl text-gray-500';
        } else if (kembali >= 0) {
            elements.uangKembali.textContent = formatCurrency(kembali);
            elements.uangKembali.className = 'font-bold text-xl text-green-600';
        } else {
            elements.uangKembali.textContent = formatCurrency(Math.abs(kembali)) + ' (Kurang)';
            elements.uangKembali.className = 'font-bold text-xl text-red-600';
        }
    }

    // ============ CART ============
    function renderCart() {
        if (!elements.cartItems) return;
        elements.cartItems.innerHTML = '';
        if (cart.length === 0) {
            elements.cartItems.innerHTML = `
                <tr id="emptyCart">
                    <td colspan="5" class="px-4 py-10 text-center">
                        <div class="inline-flex items-center justify-center w-14 h-14 bg-[#27124A]/10 rounded-full mb-3">
                            <i class="fas fa-shopping-cart text-xl text-gray-400"></i>
                        </div>
                        <p class="text-sm text-gray-500 mb-1">Keranjang belanja kosong</p>
                        <p class="text-xs text-gray-400">Pilih produk di atas</p>
                    </td>
                </tr>`;
        } else {
            cart.forEach((item, index) => {
                const row = document.createElement('tr');
                row.className = 'cart-item hover:bg-[#27124A]/5 transition-colors';
                row.innerHTML = `
                    <td class="px-3 py-3">
                        <div class="font-medium text-gray-800 text-sm">${item.nama}</div>
                        <div class="text-xs text-gray-400 mt-0.5">Stok: ${item.stok}</div>
                    </td>
                    <td class="px-3 py-3 font-semibold text-[#27124A] text-sm">${formatCurrency(item.harga)}</td>
                    <td class="px-3 py-3">
                        <div class="flex items-center">
                            <button type="button" class="qty-btn minus rounded-l-lg" data-index="${index}">-</button>
                            <input type="number" class="qty-input" value="${item.qty}" min="1" max="${item.stok}" data-index="${index}">
                            <button type="button" class="qty-btn plus rounded-r-lg" data-index="${index}">+</button>
                        </div>
                    </td>
                    <td class="px-3 py-3 font-semibold text-gray-800 text-sm">${formatCurrency(item.harga * item.qty)}</td>
                    <td class="px-3 py-3 text-center">
                        <button type="button" class="remove-item text-red-500 hover:text-red-700 p-1.5 rounded-lg transition-colors" data-index="${index}">
                            <i class="fas fa-trash-alt text-xs"></i>
                        </button>
                    </td>`;
                elements.cartItems.appendChild(row);
            });
            attachCartEventListeners();
        }
        updateCartCount();
        calculateTotals();
        updateUangKembali();
    }

    function attachCartEventListeners() {
        document.querySelectorAll('.minus').forEach(b => { b.removeEventListener('click', handleMinus); b.addEventListener('click', handleMinus); });
        document.querySelectorAll('.plus').forEach(b  => { b.removeEventListener('click', handlePlus);  b.addEventListener('click', handlePlus); });
        document.querySelectorAll('.qty-input').forEach(i => { i.removeEventListener('change', handleQtyChange); i.addEventListener('change', handleQtyChange); });
        document.querySelectorAll('.remove-item').forEach(b => { b.removeEventListener('click', handleRemove); b.addEventListener('click', handleRemove); });
    }

    function handleMinus(e)     { e.preventDefault(); const i = parseInt(this.dataset.index); if (cart[i]) updateQuantity(i, cart[i].qty - 1); }
    function handlePlus(e)      { e.preventDefault(); const i = parseInt(this.dataset.index); if (cart[i]) updateQuantity(i, cart[i].qty + 1); }
    function handleQtyChange(e) { e.preventDefault(); const i = parseInt(this.dataset.index); const v = parseInt(this.value); if (!isNaN(v) && cart[i]) updateQuantity(i, v); }
    function handleRemove(e)    { e.preventDefault(); const i = parseInt(this.dataset.index); if (confirm('Hapus produk dari keranjang?')) removeFromCart(i); }

    function removeFromCart(index) { cart.splice(index, 1); renderCart(); }

    function updateQuantity(index, newQty) {
        if (!cart[index]) return;
        if (newQty < 1) { removeFromCart(index); }
        else if (newQty > cart[index].stok) { alert(`⚠️ Stok tidak cukup! Maksimal: ${cart[index].stok}`); cart[index].qty = cart[index].stok; renderCart(); }
        else { cart[index].qty = newQty; renderCart(); }
    }

    function addToCart(product) {
        if (!jenisTransaksi.includes('produk')) { alert('❌ Pilih jenis transaksi yang mengandung produk terlebih dahulu'); return false; }
        const existingIndex = cart.findIndex(i => i.id === product.id);
        if (existingIndex !== -1) {
            if (cart[existingIndex].qty + 1 > product.stok) { alert(`⚠️ Stok tidak cukup! Tersedia: ${product.stok}`); return false; }
            cart[existingIndex].qty += 1;
        } else {
            if (product.stok < 1) { alert('⚠️ Stok produk habis!'); return false; }
            cart.push({ id: product.id, nama: product.nama, harga: product.harga, qty: 1, stok: product.stok });
        }
        renderCart();
        return true;
    }

    function getProductFromElement(el) {
        let src = (el.dataset.id) ? el : el.closest('.product-card');
        if (!src) return null;
        const { id, nama, harga, stok } = src.dataset;
        return id && nama && harga ? { id: parseInt(id), nama, harga: parseFloat(harga), stok: parseInt(stok) } : null;
    }

    function onAddToCartClick(event) {
        event.preventDefault(); event.stopPropagation();
        const product = getProductFromElement(this);
        if (!product) { alert('Gagal menambahkan produk'); return; }
        if (addToCart(product)) {
            const orig = this.innerHTML;
            this.innerHTML = '<i class="fas fa-check"></i> Ditambahkan';
            this.classList.add('bg-green-600', 'text-white');
            this.classList.remove('bg-[#27124A]/10', 'text-[#27124A]');
            setTimeout(() => {
                this.innerHTML = orig;
                this.classList.remove('bg-green-600', 'text-white');
                this.classList.add('bg-[#27124A]/10', 'text-[#27124A]');
            }, 1000);
        }
    }

    function onProductCardClick(event) {
        if (event.target.closest('.add-to-cart-btn')) return;
        const p = { id: parseInt(this.dataset.id), nama: this.dataset.nama, harga: parseFloat(this.dataset.harga), stok: parseInt(this.dataset.stok) };
        if (p.stok > 0) addToCart(p); else alert('⚠️ Stok produk habis!');
    }

    // ============ JENIS TRANSAKSI ============
    function selectJenisTransaksi(jenis) {
        elements.jenisCards.forEach(c => c.classList.remove('selected'));
        const sel = document.getElementById(`jenis-${jenis}`);
        if (sel) sel.classList.add('selected');
        jenisTransaksi = jenis;
        if (elements.jenisTransaksiInput) elements.jenisTransaksiInput.value = jenis;
        const labels = { produk: 'Produk Only', visit: 'Visit Only', produk_visit: 'Produk + Visit' };
        if (elements.jenisTransaksiText) elements.jenisTransaksiText.textContent = labels[jenis] || jenis;
        if (elements.infoJenisTransaksi) elements.infoJenisTransaksi.classList.remove('hidden');

        if (elements.produkSection) elements.produkSection.classList.add('hidden');
        if (elements.cartSection)   elements.cartSection.classList.add('hidden');
        if (elements.visitSection)  elements.visitSection.classList.add('hidden');

        if (jenis.includes('produk')) {
            elements.produkSection?.classList.remove('hidden');
            elements.cartSection?.classList.remove('hidden');
        }
        if (jenis.includes('visit')) {
            elements.visitSection?.classList.remove('hidden');
            setCurrentDateTimeForVisit();
        }
        if (!jenis.includes('produk')) { cart = []; renderCart(); }
        calculateTotals();
    }

    // ============ FILTER PRODUK ============
    function filterProducts() {
        const search = elements.searchProduct?.value.toLowerCase().trim() || '';
        document.querySelectorAll('.product-card').forEach(card => {
            card.style.display = card.dataset.nama.toLowerCase().includes(search) || !search ? 'block' : 'none';
        });
    }

    // ============ VALIDASI VISIT ============
    function validateVisit() {
        if (!jenisTransaksi.includes('visit')) return true;
        if (!elements.tglVisit?.value) { alert('❌ Tanggal visit harus diisi'); return false; }
        const visitDate = new Date(elements.tglVisit.value);
        const today = new Date();
        visitDate.setHours(0,0,0,0); today.setHours(0,0,0,0);
        if (visitDate.getTime() !== today.getTime()) { alert('❌ Visit hanya bisa dilakukan untuk HARI INI!'); return false; }
        const hour = new Date(elements.tglVisit.value).getHours();
        if (hour < 6 || hour > 22) { alert('❌ Jam operasional gym adalah 06:00 – 22:00 WIB'); return false; }
        return true;
    }

    // ============ SAVE TRANSAKSI ============
    async function saveTransaction() {
        if (!jenisTransaksi)                                  { alert('❌ Pilih jenis transaksi terlebih dahulu'); return; }
        if (!validateVisit())                                  return;
        if (jenisTransaksi.includes('produk') && cart.length === 0) { alert('❌ Keranjang belanja masih kosong'); return; }

        const total   = calculateTotals();
        const bayar   = parseCurrency(elements.uangBayar?.value);
        if (bayar === 0)   { alert('❌ Masukkan jumlah uang bayar'); elements.uangBayar?.focus(); return; }
        if (bayar < total) { alert('❌ Uang bayar kurang dari total belanja'); elements.uangBayar?.focus(); return; }

        const data = {
            jenis_transaksi: jenisTransaksi,
            items:           cart.map(i => ({ product_id: i.id, qty: i.qty })),
            total_harga:     total,
            uang_bayar:      bayar,
            uang_kembali:    bayar - total,
            metode_bayar:    'cash',
            member_id:       null,
            catatan:         elements.catatan?.value || '',
            _token:          '{{ csrf_token() }}'
        };
        if (jenisTransaksi.includes('visit') && elements.hargaVisit && elements.tglVisit) {
            data.harga_visit = parseFloat(elements.hargaVisit.value);
            data.tgl_visit   = elements.tglVisit.value;
        }

        if (elements.btnSimpan) {
            elements.btnSimpan.disabled = true;
            elements.btnSimpan.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Memproses...';
        }

        try {
            const response = await fetch('{{ route("kasir.transaksi.store") }}', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'Accept': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                body: JSON.stringify(data)
            });
            const result = await response.json();

            if (result.success) {
                const labels = { produk: 'Pembelian produk berhasil!', visit: 'Visit berhasil dicatat!', produk_visit: 'Transaksi produk + visit berhasil!' };
                if (elements.successMessage) elements.successMessage.textContent = labels[result.jenis_transaksi] || 'Transaksi berhasil!';
                if (elements.successNomor)   elements.successNomor.textContent = result.nomor_unik;
                if (elements.successModal)   { elements.successModal.classList.remove('hidden'); elements.successModal.style.display = 'flex'; }
                if (result.transaction_id && elements.btnCetakStruk) {
                    elements.btnCetakStruk.onclick = () => window.open(`{{ url("kasir/transaksi") }}/${result.transaction_id}/struk`, '_blank');
                }
                setTimeout(() => resetForm(), 2000);
            } else {
                alert('❌ ' + (result.message || 'Terjadi kesalahan'));
            }
        } catch (err) {
            alert('❌ Gagal memproses transaksi: ' + err.message);
        } finally {
            if (elements.btnSimpan) {
                elements.btnSimpan.disabled = false;
                elements.btnSimpan.innerHTML = '<i class="fas fa-check-circle"></i> Proses Pembayaran';
            }
        }
    }

    function resetForm() {
        cart = []; jenisTransaksi = '';
        renderCart();
        if (elements.uangBayar) elements.uangBayar.value = '';
        if (elements.catatan)   elements.catatan.value = '';
        updateUangKembali();
        elements.jenisCards.forEach(c => c.classList.remove('selected'));
        elements.produkSection?.classList.add('hidden');
        elements.cartSection?.classList.add('hidden');
        elements.visitSection?.classList.add('hidden');
        elements.infoJenisTransaksi?.classList.add('hidden');
        setCurrentDateTimeForVisit();
    }

    // ============ EVENT LISTENERS ============
    elements.jenisCards.forEach(c => c.addEventListener('click', function() { selectJenisTransaksi(this.dataset.jenis); }));

    elements.addToCartBtns.forEach(b => { b.removeEventListener('click', onAddToCartClick); b.addEventListener('click', onAddToCartClick); });
    elements.productCards.forEach(c  => { c.removeEventListener('click', onProductCardClick); c.addEventListener('click', onProductCardClick); });

    elements.searchProduct?.addEventListener('input', filterProducts);
    elements.uangBayar?.addEventListener('input', updateUangKembali);
    elements.uangBayar?.addEventListener('keypress', e => { if (!/[\d]/.test(e.key)) e.preventDefault(); });

    elements.quickAmounts.forEach(b => {
        b.addEventListener('click', function(e) {
            e.preventDefault();
            if (elements.uangBayar) { elements.uangBayar.value = this.dataset.amount; updateUangKembali(); }
        });
    });

    elements.btnUangPas?.addEventListener('click', function(e) {
        e.preventDefault();
        if (elements.uangBayar) { elements.uangBayar.value = calculateTotals(); updateUangKembali(); }
    });

    elements.btnSimpan?.addEventListener('click', function(e) { e.preventDefault(); saveTransaction(); });

    elements.btnBatal?.addEventListener('click', function(e) {
        e.preventDefault();
        if (cart.length === 0 && !jenisTransaksi) { window.location.href = '{{ route("kasir.transaksi.index") }}'; return; }
        if (confirm('Batalkan transaksi? Semua data akan hilang.')) resetForm();
    });

    elements.successModal?.addEventListener('click', function(e) {
        if (e.target === this) { this.style.display = 'none'; this.classList.add('hidden'); }
    });

    // ============ INIT ============
    renderCart();
    setCurrentDateTimeForVisit();
});
</script>
@endsection