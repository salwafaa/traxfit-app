@extends('layouts.app')

@section('title', $isRenewMode ? 'Perpanjang Membership' : 'Transaksi Membership Baru')
@section('page-title', $isRenewMode ? 'Perpanjang Membership' : 'Transaksi Membership Baru')

@section('sidebar')
    @include('kasir.partials.sidebar')
@endsection

@section('content')
<div class="space-y-6 w-full max-w-full">

    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3">
        <div class="flex items-center gap-3">
            <a href="{{ route('kasir.transaksi.index') }}"
               class="inline-flex items-center gap-2 px-4 py-2 bg-white hover:bg-gray-50 text-gray-700 rounded-xl text-sm font-medium border border-gray-200 transition-all duration-200 shadow-sm">
                <i class="fas fa-arrow-left text-xs"></i>
                Kembali
            </a>
            <div>
                <h1 class="text-xl font-bold text-gray-800">
                    {{ $isRenewMode ? 'Perpanjang Membership' : 'Transaksi Membership Baru' }}
                </h1>
                @if($isRenewMode && $preloadMember)
                    <p class="text-xs text-gray-500 mt-0.5 flex flex-wrap gap-x-2">
                        <span class="font-semibold text-[#27124A]">{{ $preloadMember['nama'] }}</span>
                        <span>·</span>
                        <span>{{ $preloadMember['kode_member'] }}</span>
                        <span>·</span>
                        <span>Paket: <span class="font-medium">{{ $preloadMember['paket_lama'] }}</span></span>
                        <span>·</span>
                        <span>Exp: <span class="text-red-600 font-medium">{{ $preloadMember['tgl_expired'] }}</span></span>
                    </p>
                @endif
            </div>
        </div>
        <div class="bg-[#27124A]/10 text-[#27124A] px-4 py-2 rounded-xl border border-[#27124A]/20">
            <span class="font-mono font-bold text-sm">{{ $nomorUnik }}</span>
        </div>
    </div>

    @if($isRenewMode && $preloadMember)
    <div class="bg-green-50 border border-green-200 rounded-2xl p-4 flex items-center gap-3">
        <div class="w-10 h-10 bg-green-100 rounded-xl flex items-center justify-center flex-shrink-0">
            <i class="fas fa-redo text-green-600"></i>
        </div>
        <div>
            <p class="font-semibold text-green-800 text-sm">Mode Perpanjangan Membership</p>
            <p class="text-xs text-green-700 mt-0.5">Data member sudah terisi otomatis. Pilih paket baru dan lakukan pembayaran untuk memperpanjang.</p>
        </div>
    </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <div class="lg:col-span-2 space-y-6">

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-6 py-4 border-b border-[#27124A]/10 bg-gradient-to-r from-[#27124A]/5 to-white">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-[#27124A]/10 rounded-xl flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-id-card text-[#27124A]"></i>
                        </div>
                        <div>
                            <h2 class="text-base font-semibold text-gray-800">Pilih Jenis Membership</h2>
                            <p class="text-sm text-gray-500">Klik salah satu untuk memulai</p>
                        </div>
                    </div>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">

                        <div class="jenis-membership-card border-2 rounded-xl p-5 cursor-pointer transition-all duration-200 hover:border-[#27124A] hover:bg-[#27124A]/5 text-center selected"
                             data-jenis="membership" id="jenis-membership">
                            <div class="w-14 h-14 bg-[#27124A]/10 rounded-full flex items-center justify-center mx-auto mb-3">
                                <i class="fas fa-id-card text-xl text-[#27124A]"></i>
                            </div>
                            <h3 class="font-semibold text-gray-800 text-sm mb-1">Membership Only</h3>
                            <p class="text-xs text-gray-500">Pembelian paket membership</p>
                        </div>

                        <div class="jenis-membership-card border-2 rounded-xl p-5 cursor-pointer transition-all duration-200 hover:border-[#27124A] hover:bg-[#27124A]/5 text-center"
                             data-jenis="produk_membership" id="jenis-produk-membership">
                            <div class="w-14 h-14 bg-orange-50 rounded-full flex items-center justify-center mx-auto mb-3">
                                <i class="fas fa-box text-xl text-orange-500"></i>
                            </div>
                            <h3 class="font-semibold text-gray-800 text-sm mb-1">Produk + Membership</h3>
                            <p class="text-xs text-gray-500">Produk sekaligus membership</p>
                        </div>

                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-6 py-4 border-b border-[#27124A]/10 bg-gradient-to-r from-[#27124A]/5 to-white">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-[#27124A]/10 rounded-xl flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-{{ $isRenewMode ? 'user-edit' : 'user-plus' }} text-[#27124A]"></i>
                            </div>
                            <div>
                                <h2 class="text-base font-semibold text-gray-800">
                                    {{ $isRenewMode ? 'Data Member (Bisa Diedit)' : 'Data Member Baru' }}
                                </h2>
                                <p class="text-sm text-gray-500">
                                    {{ $isRenewMode ? 'Data terisi otomatis, ubah jika diperlukan' : 'Isi data member dengan lengkap' }}
                                </p>
                            </div>
                        </div>
                        @if($isRenewMode && $preloadMember)
                        <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs font-semibold flex-shrink-0">
                            <i class="fas fa-check-circle mr-1"></i> Auto-filled
                        </span>
                        @endif
                    </div>
                </div>
                <div class="p-6">
                    @if($isRenewMode && $preloadMember)
                    <input type="hidden" id="existing_member_id" value="{{ $preloadMember['id'] }}">
                    @endif

                    <form id="memberForm" class="space-y-5">
                        @csrf

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wide mb-1.5">
                                    Nama Lengkap <span class="text-red-500">*</span>
                                </label>
                                <input type="text" id="nama" name="nama"
                                    class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#27124A]/20 focus:border-[#27124A] transition-all"
                                    placeholder="Masukkan nama lengkap"
                                    value="{{ $preloadMember['nama'] ?? '' }}"
                                    required>
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wide mb-1.5">
                                    Nomor Telepon <span class="text-red-500">*</span>
                                </label>
                                <input type="tel" id="telepon" name="telepon"
                                    class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#27124A]/20 focus:border-[#27124A] transition-all"
                                    placeholder="08xxxxxxxxxx"
                                    value="{{ $preloadMember['telepon'] ?? '' }}"
                                    maxlength="14"
                                    inputmode="numeric"
                                    required>
                                <p class="text-xs text-gray-400 mt-1 flex items-center gap-1"><i class="fas fa-info-circle text-[#27124A]/60"></i> Angka saja, maks. 14 digit</p>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wide mb-1.5">
                                    Tanggal Lahir <span class="text-red-500">*</span>
                                </label>
                                <input type="date" id="tgl_lahir" name="tgl_lahir"
                                    class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#27124A]/20 focus:border-[#27124A] transition-all"
                                    value="{{ $preloadMember['tgl_lahir'] ?? '' }}"
                                    required>
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wide mb-1.5">
                                    Jenis Identitas <span class="text-red-500">*</span>
                                </label>
                                <select id="jenis_identitas" name="jenis_identitas"
                                    class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#27124A]/20 focus:border-[#27124A] transition-all"
                                    required>
                                    <option value="">-- Pilih Jenis Identitas --</option>
                                    <option value="KTP" {{ (isset($preloadMember['jenis_identitas']) && $preloadMember['jenis_identitas'] == 'KTP') ? 'selected' : '' }}>KTP</option>
                                    <option value="SIM" {{ (isset($preloadMember['jenis_identitas']) && $preloadMember['jenis_identitas'] == 'SIM') ? 'selected' : '' }}>SIM</option>
                                </select>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wide mb-1.5">
                                    Nomor Identitas <span class="text-red-500">*</span>
                                </label>
                                <input type="text" id="no_identitas" name="no_identitas"
                                    class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#27124A]/20 focus:border-[#27124A] transition-all"
                                    placeholder="Nomor KTP / SIM"
                                    value="{{ $preloadMember['no_identitas'] ?? '' }}"
                                    inputmode="numeric"
                                    required>
                                <p class="text-xs text-gray-400 mt-1 flex items-center gap-1"><i class="fas fa-info-circle text-[#27124A]/60"></i> Angka saja</p>
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wide mb-1.5">
                                    Foto Identitas
                                    @if($isRenewMode && $preloadMember && $preloadMember['foto_identitas'])
                                        <span class="text-xs text-green-600 font-normal ml-1 normal-case">(kosongkan jika tidak diubah)</span>
                                    @endif
                                </label>
                                @if($isRenewMode && $preloadMember && $preloadMember['foto_identitas'])
                                <div class="mb-2 flex items-center gap-3">
                                    <img src="{{ asset('storage/' . $preloadMember['foto_identitas']) }}"
                                         alt="Foto Identitas"
                                         class="w-14 h-14 object-cover rounded-lg border border-gray-200">
                                    <span class="text-xs text-gray-500">Foto saat ini</span>
                                </div>
                                @endif
                                <input type="file" id="foto_identitas" name="foto_identitas"
                                    class="w-full text-sm text-gray-500 border border-gray-200 rounded-xl px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#27124A]/20 focus:border-[#27124A] transition-all file:mr-3 file:py-1 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-medium file:bg-[#27124A]/10 file:text-[#27124A] hover:file:bg-[#27124A]/20"
                                    accept="image/*">
                                <p class="text-xs text-gray-400 mt-1">JPG/PNG, maks. 2MB</p>
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wide mb-1.5">
                                Alamat Lengkap <span class="text-red-500">*</span>
                            </label>
                            <textarea id="alamat" name="alamat" rows="3"
                                class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#27124A]/20 focus:border-[#27124A] transition-all resize-none"
                                placeholder="Masukkan alamat lengkap"
                                required>{{ $preloadMember['alamat'] ?? '' }}</textarea>
                        </div>

                    </form>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-6 py-4 border-b border-[#27124A]/10 bg-gradient-to-r from-[#27124A]/5 to-white">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-[#27124A]/10 rounded-xl flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-gift text-[#27124A]"></i>
                        </div>
                        <div>
                            <h2 class="text-base font-semibold text-gray-800">Pilih Paket Membership</h2>
                            <p class="text-sm text-gray-500">{{ $isRenewMode ? 'Pilih paket untuk perpanjangan' : 'Pilih paket yang diinginkan' }}</p>
                        </div>
                    </div>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        @foreach($membershipPackages as $package)
                        <div class="package-card border-2 border-gray-200 rounded-xl p-5 cursor-pointer transition-all duration-200 hover:border-[#27124A] hover:bg-[#27124A]/5"
                             data-id="{{ $package->id }}"
                             data-nama="{{ $package->nama_paket }}"
                             data-durasi="{{ $package->durasi_hari }}"
                             data-harga="{{ $package->harga }}">
                            <div class="flex justify-between items-start mb-3">
                                <h3 class="font-semibold text-gray-800 text-sm">{{ $package->nama_paket }}</h3>
                                <span class="bg-[#27124A]/10 text-[#27124A] text-xs px-2 py-1 rounded-full font-medium flex-shrink-0 ml-2">{{ $package->durasi_formatted }}</span>
                            </div>
                            <div class="mb-4">
                                <span class="text-xl font-bold text-[#27124A]">Rp {{ number_format($package->harga, 0, ',', '.') }}</span>
                            </div>
                            <button type="button"
                                class="select-package-btn w-full inline-flex items-center justify-center gap-2 bg-[#27124A]/10 hover:bg-[#27124A] text-[#27124A] hover:text-white font-medium py-2 px-3 rounded-xl text-sm transition-all duration-200 border border-[#27124A]/20"
                                data-id="{{ $package->id }}"
                                data-nama="{{ $package->nama_paket }}"
                                data-durasi="{{ $package->durasi_hari }}"
                                data-harga="{{ $package->harga }}">
                                <i class="fas fa-check-circle text-xs"></i>
                                Pilih Paket
                            </button>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div id="produkSection" style="display:none;" class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-6 py-4 border-b border-[#27124A]/10 bg-gradient-to-r from-[#27124A]/5 to-white">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-[#27124A]/10 rounded-xl flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-box text-[#27124A]"></i>
                        </div>
                        <div>
                            <h2 class="text-base font-semibold text-gray-800">Pilih Produk Tambahan</h2>
                            <p class="text-sm text-gray-500">Pilih produk yang ingin dibeli bersama membership</p>
                        </div>
                    </div>
                </div>
                <div class="px-6 pt-5">
                    <div class="relative">
                        <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 text-sm"></i>
                        <input type="text" id="searchProduct"
                            class="w-full border border-gray-200 rounded-xl pl-11 pr-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#27124A]/20 focus:border-[#27124A] transition-all"
                            placeholder="Cari produk...">
                    </div>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 max-h-[400px] overflow-y-auto pr-1 custom-scrollbar">
                        @forelse($products as $product)
                        <div class="product-card border border-gray-200 rounded-xl hover:shadow-md hover:border-[#27124A]/30 transition-all duration-200 cursor-pointer bg-white group"
                             data-id="{{ $product->id }}"
                             data-nama="{{ $product->nama_produk }}"
                             data-harga="{{ $product->harga }}"
                             data-stok="{{ $product->stok }}">
                            <div class="p-4">
                                <div class="flex justify-between items-start mb-2">
                                    <h3 class="font-semibold text-sm text-gray-800 group-hover:text-[#27124A] truncate flex-1 pr-2">{{ $product->nama_produk }}</h3>
                                    <span class="text-xs px-2 py-1 bg-[#27124A]/10 text-[#27124A] rounded-lg flex-shrink-0">{{ $product->category->nama_kategori ?? 'Umum' }}</span>
                                </div>
                                <div class="flex justify-between items-center mb-3">
                                    <span class="text-base font-bold text-[#27124A]">Rp {{ number_format($product->harga, 0, ',', '.') }}</span>
                                    @if($product->stok > 0)
                                        <span class="text-xs px-2 py-1 {{ $product->stok <= 5 ? 'bg-orange-50 text-orange-700' : 'bg-green-50 text-green-700' }} rounded-lg">
                                            Stok: {{ $product->stok }}
                                        </span>
                                    @else
                                        <span class="text-xs px-2 py-1 bg-red-50 text-red-700 rounded-lg">Habis</span>
                                    @endif
                                </div>
                                @if($product->stok > 0)
                                <button type="button"
                                        class="add-to-cart-btn w-full inline-flex items-center justify-center gap-2 bg-[#27124A]/10 hover:bg-[#27124A] text-[#27124A] hover:text-white font-medium py-2 px-3 rounded-xl text-sm transition-all duration-200 border border-[#27124A]/20"
                                        data-id="{{ $product->id }}"
                                        data-nama="{{ $product->nama_produk }}"
                                        data-harga="{{ $product->harga }}"
                                        data-stok="{{ $product->stok }}">
                                    <i class="fas fa-cart-plus text-xs"></i> Tambah
                                </button>
                                @else
                                <button type="button" class="w-full inline-flex items-center justify-center gap-2 bg-gray-100 text-gray-400 font-medium py-2 px-3 rounded-xl text-sm cursor-not-allowed" disabled>
                                    <i class="fas fa-times-circle text-xs"></i> Stok Habis
                                </button>
                                @endif
                            </div>
                        </div>
                        @empty
                        <div class="col-span-2 text-center py-10">
                            <div class="inline-flex items-center justify-center w-14 h-14 bg-[#27124A]/10 rounded-full mb-3">
                                <i class="fas fa-box-open text-xl text-[#27124A]"></i>
                            </div>
                            <h4 class="font-semibold text-gray-800 mb-1">Belum Ada Produk</h4>
                            <p class="text-sm text-gray-400">Tidak ada produk tersedia</p>
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>

            <div id="cartSection" style="display:none;" class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-6 py-4 border-b border-[#27124A]/10 bg-gradient-to-r from-[#27124A]/5 to-white">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-[#27124A]/10 rounded-xl flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-shopping-cart text-[#27124A]"></i>
                        </div>
                        <div>
                            <h2 class="text-base font-semibold text-gray-800">Keranjang Produk</h2>
                            <p class="text-sm text-gray-500">Daftar produk yang akan dibeli</p>
                        </div>
                    </div>
                </div>
                <div class="p-6">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-100 text-sm">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wide">Produk</th>
                                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wide">Harga</th>
                                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wide">Qty</th>
                                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wide">Subtotal</th>
                                    <th class="px-4 py-3 text-center text-xs font-semibold text-gray-500 uppercase tracking-wide">Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="cartItems" class="bg-white divide-y divide-gray-100"></tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>

        <div class="lg:col-span-1">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden sticky top-6">

                <div class="px-6 py-4 border-b border-[#27124A]/10 bg-gradient-to-r from-[#27124A]/5 to-white">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-[#27124A]/10 rounded-xl flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-file-invoice text-[#27124A]"></i>
                        </div>
                        <div>
                            <h2 class="text-base font-semibold text-gray-800">Ringkasan Pembayaran</h2>
                            <p class="text-sm text-gray-500">Detail transaksi</p>
                        </div>
                    </div>
                </div>

                <div class="p-6 space-y-5">

                    <div id="selectedPackageInfo" style="display:none;" class="bg-[#27124A]/5 border border-[#27124A]/15 rounded-xl p-4">
                        <h4 class="text-xs font-semibold text-[#27124A] uppercase tracking-wide mb-3">Paket Dipilih</h4>
                        <div class="space-y-2">
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-gray-500">Paket</span>
                                <span class="text-sm font-semibold text-gray-800" id="selectedPackageName">-</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-gray-500">Durasi</span>
                                <span class="text-sm font-semibold text-gray-800" id="selectedPackageDurasi">-</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-gray-500">Harga</span>
                                <span class="text-sm font-bold text-[#27124A]" id="selectedPackageHarga">-</span>
                            </div>
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wide mb-1.5">
                            Tanggal Mulai <span class="text-red-500">*</span>
                        </label>
                        <input type="datetime-local" id="tgl_mulai"
                            class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm bg-gray-50 cursor-not-allowed focus:outline-none"
                            value="{{ now()->format('Y-m-d\TH:i') }}"
                            readonly>
                        <p class="text-xs text-[#27124A]/70 mt-1 flex items-center gap-1">
                            <i class="fas fa-lock"></i> Otomatis mulai hari ini
                        </p>
                    </div>

                    <div id="expiredInfo" style="display:none;" class="bg-blue-50 border border-blue-100 rounded-xl p-4">
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600">Tanggal Selesai</span>
                            <span class="text-sm font-bold text-blue-700" id="tglSelesai">-</span>
                        </div>
                    </div>

                    <div class="space-y-2 border-t border-gray-100 pt-4">
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600">Harga Paket</span>
                            <span class="text-sm font-semibold text-gray-800" id="displayHargaPaket">Rp 0</span>
                        </div>
                        <div id="subtotalProdukRow" style="display:none;" class="flex justify-between items-center">
                            <span class="text-sm text-gray-600">Subtotal Produk</span>
                            <span class="text-sm font-semibold text-gray-800" id="subtotal">Rp 0</span>
                        </div>
                    </div>

                    <div class="bg-[#27124A] rounded-xl px-4 py-3 flex justify-between items-center">
                        <span class="font-bold text-white/80 text-sm">TOTAL</span>
                        <span class="font-bold text-2xl text-white" id="total">Rp 0</span>
                    </div>

                    <input type="hidden" id="jenis_transaksi" value="membership">
                    <input type="hidden" id="id_paket" value="">
                    <input type="hidden" id="harga_paket" value="0">

                    <div>
                        <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wide mb-1.5">Uang Bayar</label>
                        <div class="relative">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-500 text-sm font-medium">Rp</span>
                            <input type="text" id="uang_bayar"
                                class="w-full pl-11 pr-4 py-3 border border-gray-200 rounded-xl text-lg font-semibold focus:outline-none focus:ring-2 focus:ring-[#27124A]/20 focus:border-[#27124A] transition-all"
                                placeholder="0"
                                inputmode="numeric">
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

                    <div class="bg-gray-50 border border-gray-100 rounded-xl px-4 py-3 flex justify-between items-center">
                        <span class="text-sm font-medium text-gray-700">Uang Kembali</span>
                        <span id="uang_kembali" style="font-weight:700; font-size:1.15rem; color:#4b5563;">Rp 0</span>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wide mb-1.5">
                            Catatan <span class="text-gray-400 font-normal normal-case">(Opsional)</span>
                        </label>
                        <textarea id="catatan" rows="2"
                            class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#27124A]/20 focus:border-[#27124A] transition-all resize-none"
                            placeholder="Tambahkan catatan..."></textarea>
                    </div>

                    <div class="space-y-2.5">
                        <button type="button" id="btnSimpan"
                            class="w-full inline-flex items-center justify-center gap-2 bg-[#27124A] hover:bg-[#3a1d6b] text-white font-semibold py-3.5 px-4 rounded-xl transition-all duration-200 shadow-sm hover:shadow-md">
                            <i class="fas fa-{{ $isRenewMode ? 'redo' : 'check-circle' }}"></i>
                            {{ $isRenewMode ? 'Proses Perpanjangan' : 'Proses Membership' }}
                        </button>
                        <button type="button" id="btnBatal"
                            class="w-full inline-flex items-center justify-center gap-2 bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold py-3.5 px-4 rounded-xl transition-all duration-200">
                            <i class="fas fa-times-circle"></i>
                            Batalkan
                        </button>
                    </div>

                </div>
            </div>
        </div>

    </div>
</div>

<div id="successModal" style="
    display: none;
    position: fixed;
    top: 0; left: 0; right: 0; bottom: 0;
    background: rgba(0,0,0,0.65);
    z-index: 999999;
    align-items: center;
    justify-content: center;
    padding: 1rem;
">
    <div id="successModalBox" style="
        background: #ffffff;
        border-radius: 1.25rem;
        box-shadow: 0 30px 70px rgba(0,0,0,0.3);
        width: 100%;
        max-width: 26rem;
        padding: 2rem 1.75rem;
        position: relative;
        pointer-events: auto;
    ">
        <div style="text-align:center; margin-bottom:1.5rem;">
            <div style="width:5rem;height:5rem;background:#f0fdf4;border-radius:50%;display:inline-flex;align-items:center;justify-content:center;margin-bottom:0.75rem;border:2px solid #bbf7d0;">
                <i class="fas fa-check-circle" style="font-size:2.5rem;color:#16a34a;"></i>
            </div>
            <h3 id="successTitle" style="font-size:1.15rem;font-weight:700;color:#111827;margin:0 0 0.35rem;"></h3>
            <p id="successMessage" style="font-size:0.875rem;color:#6b7280;margin:0;"></p>
        </div>
        <div style="background:#f5f3ff;border:1px solid #ddd6fe;border-radius:0.75rem;padding:0.875rem 1rem;text-align:center;margin-bottom:0.75rem;">
            <p style="font-size:0.65rem;color:#9ca3af;margin:0 0 0.3rem;text-transform:uppercase;letter-spacing:0.06em;">No. Transaksi</p>
            <p id="successNomor" style="font-size:1.1rem;font-family:monospace;font-weight:700;color:#27124A;margin:0;"></p>
        </div>
        <div style="background:#f0fdf4;border:1px solid #bbf7d0;border-radius:0.75rem;padding:0.875rem 1rem;text-align:center;margin-bottom:1.5rem;">
            <p style="font-size:0.65rem;color:#9ca3af;margin:0 0 0.4rem;text-transform:uppercase;letter-spacing:0.06em;">Data Member</p>
            <p id="successNamaMember" style="font-weight:600;color:#111827;margin:0 0 0.2rem;font-size:0.95rem;"></p>
            <p id="successKodeMember" style="font-size:0.8rem;font-family:monospace;color:#6b7280;margin:0;"></p>
        </div>
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:0.5rem;margin-bottom:0.5rem;">
            <button type="button" id="btnCetakStruk" style="background:#27124A;color:#fff;border:none;border-radius:0.75rem;padding:0.75rem 0.5rem;font-size:0.875rem;font-weight:600;cursor:pointer;display:flex;align-items:center;justify-content:center;gap:0.4rem;">
                <i class="fas fa-print"></i> Cetak Struk
            </button>
            <button type="button" id="btnCetakKartu" style="background:#16a34a;color:#fff;border:none;border-radius:0.75rem;padding:0.75rem 0.5rem;font-size:0.875rem;font-weight:600;cursor:pointer;display:flex;align-items:center;justify-content:center;gap:0.4rem;">
                <i class="fas fa-id-card"></i> Kartu Member
            </button>
        </div>
        <button type="button" id="btnTransaksiBaru" style="width:100%;background:#f3f4f6;color:#374151;border:none;border-radius:0.75rem;padding:0.75rem 1rem;font-size:0.875rem;font-weight:600;cursor:pointer;display:flex;align-items:center;justify-content:center;gap:0.4rem;">
            <i class="fas fa-plus"></i> Transaksi Baru
        </button>
    </div>
</div>

<style>
    .jenis-membership-card { border-color: #e5e7eb; }
    .jenis-membership-card.selected {
        border-color: #27124A;
        background: linear-gradient(135deg, #f5f3ff 0%, #faf8ff 100%);
        box-shadow: 0 4px 15px -3px rgba(39, 18, 74, 0.15);
    }
    .package-card.selected {
        border-color: #27124A;
        background: linear-gradient(135deg, #f5f3ff 0%, #faf8ff 100%);
        box-shadow: 0 4px 15px -3px rgba(39, 18, 74, 0.1);
    }
    .cart-item td { padding: 0.75rem 1rem; vertical-align: middle; }
    .qty-btn {
        width: 30px; height: 30px;
        display: flex; align-items: center; justify-content: center;
        background: #f3f4f6; border: 1px solid #e5e7eb;
        color: #4b5563; font-weight: bold; cursor: pointer; transition: background 0.15s;
    }
    .qty-btn:hover { background: #e5e7eb; }
    .qty-input {
        width: 46px; height: 30px; text-align: center;
        border-top: 1px solid #e5e7eb; border-bottom: 1px solid #e5e7eb;
        border-left: none; border-right: none;
        font-size: 13px; -moz-appearance: textfield;
    }
    .qty-input::-webkit-outer-spin-button,
    .qty-input::-webkit-inner-spin-button { -webkit-appearance: none; margin: 0; }
    .custom-scrollbar::-webkit-scrollbar { width: 5px; }
    .custom-scrollbar::-webkit-scrollbar-track { background: #f1f1f1; border-radius: 10px; }
    .custom-scrollbar::-webkit-scrollbar-thumb { background: #c1c1c1; border-radius: 10px; }
    #btnCetakStruk:hover  { background: #3a1d6b !important; }
    #btnCetakKartu:hover  { background: #15803d !important; }
    #btnTransaksiBaru:hover { background: #e5e7eb !important; }
</style>

<script>
document.addEventListener('DOMContentLoaded', function () {

    let cart = [];
    let selectedPackage    = null;
    let jenisTransaksi     = 'membership';
    let savedTransactionId = null;

    const IS_RENEW_MODE      = {{ $isRenewMode ? 'true' : 'false' }};
    const EXISTING_MEMBER_ID = {{ ($isRenewMode && $preloadMember) ? $preloadMember['id'] : 'null' }};
    const MEMBERSHIP_URL     = '{{ url("kasir/transaksi/membership") }}';
    const STORE_URL          = '{{ route("kasir.transaksi.membership.store") }}';
    const TRANSAKSI_URL      = '{{ route("kasir.transaksi.index") }}';
    const CREATE_URL         = '{{ route("kasir.transaksi.membership.create") }}';
    const CSRF_TOKEN         = '{{ csrf_token() }}';

    const el = {
        jenisCards:            document.querySelectorAll('.jenis-membership-card'),
        jenisTransaksiInput:   document.getElementById('jenis_transaksi'),
        produkSection:         document.getElementById('produkSection'),
        cartSection:           document.getElementById('cartSection'),
        productCards:          document.querySelectorAll('.product-card'),
        addToCartBtns:         document.querySelectorAll('.add-to-cart-btn'),
        searchProduct:         document.getElementById('searchProduct'),
        cartItems:             document.getElementById('cartItems'),
        packageCards:          document.querySelectorAll('.package-card'),
        selectPackageBtns:     document.querySelectorAll('.select-package-btn'),
        selectedPackageInfo:   document.getElementById('selectedPackageInfo'),
        selectedPackageName:   document.getElementById('selectedPackageName'),
        selectedPackageDurasi: document.getElementById('selectedPackageDurasi'),
        selectedPackageHarga:  document.getElementById('selectedPackageHarga'),
        idPaket:               document.getElementById('id_paket'),
        hargaPaket:            document.getElementById('harga_paket'),
        displayHargaPaket:     document.getElementById('displayHargaPaket'),
        tglMulai:              document.getElementById('tgl_mulai'),
        tglSelesai:            document.getElementById('tglSelesai'),
        expiredInfo:           document.getElementById('expiredInfo'),
        subtotalProdukRow:     document.getElementById('subtotalProdukRow'),
        subtotal:              document.getElementById('subtotal'),
        total:                 document.getElementById('total'),
        uangBayar:             document.getElementById('uang_bayar'),
        uangKembali:           document.getElementById('uang_kembali'),
        catatan:               document.getElementById('catatan'),
        btnSimpan:             document.getElementById('btnSimpan'),
        btnBatal:              document.getElementById('btnBatal'),
        quickAmounts:          document.querySelectorAll('.quick-amount'),
        btnUangPas:            document.getElementById('btnUangPas'),
        nama:                  document.getElementById('nama'),
        telepon:               document.getElementById('telepon'),
        alamat:                document.getElementById('alamat'),
        tglLahir:              document.getElementById('tgl_lahir'),
        jenisIdentitas:        document.getElementById('jenis_identitas'),
        noIdentitas:           document.getElementById('no_identitas'),
        fotoIdentitas:         document.getElementById('foto_identitas'),
        successModal:          document.getElementById('successModal'),
        successTitle:          document.getElementById('successTitle'),
        successMessage:        document.getElementById('successMessage'),
        successNomor:          document.getElementById('successNomor'),
        successNamaMember:     document.getElementById('successNamaMember'),
        successKodeMember:     document.getElementById('successKodeMember'),
        btnCetakStruk:         document.getElementById('btnCetakStruk'),
        btnCetakKartu:         document.getElementById('btnCetakKartu'),
        btnTransaksiBaru:      document.getElementById('btnTransaksiBaru'),
    };

    const fmt   = n => 'Rp ' + new Intl.NumberFormat('id-ID').format(Math.round(n || 0));
    const parse = v => parseInt((v || '').toString().replace(/\D/g, '')) || 0;
    const esc   = t => { if (!t) return ''; const d = document.createElement('div'); d.textContent = t; return d.innerHTML; };

    function expDate(durasi, start) {
        if (!durasi) return '-';
        const d = start ? new Date(start) : new Date();
        d.setDate(d.getDate() + parseInt(durasi));
        return d.toLocaleDateString('id-ID', { day:'2-digit', month:'2-digit', year:'numeric', hour:'2-digit', minute:'2-digit' });
    }

    function lockTglMulaiToToday() {
        if (!el.tglMulai) return;
        const now = new Date();
        const pad = n => String(n).padStart(2, '0');
        el.tglMulai.value = `${now.getFullYear()}-${pad(now.getMonth()+1)}-${pad(now.getDate())}T${pad(now.getHours())}:${pad(now.getMinutes())}`;
    }

    function showModal() { if (el.successModal) el.successModal.style.display = 'flex'; }
    function hideModal() { if (el.successModal) el.successModal.style.display = 'none'; }

    function selectJenis(jenis) {
        el.jenisCards.forEach(c => c.classList.remove('selected'));
        document.getElementById(jenis === 'membership' ? 'jenis-membership' : 'jenis-produk-membership')?.classList.add('selected');
        jenisTransaksi = jenis;
        if (el.jenisTransaksiInput) el.jenisTransaksiInput.value = jenis;
        const show = jenis === 'produk_membership';
        if (el.produkSection) el.produkSection.style.display = show ? 'block' : 'none';
        if (el.cartSection)   el.cartSection.style.display   = show ? 'block' : 'none';
        if (!show) { cart = []; renderCart(); }
        calculateTotals();
    }

    function selectPackage(pkg) {
        selectedPackage = pkg;
        if (el.selectedPackageInfo)   el.selectedPackageInfo.style.display   = 'block';
        if (el.selectedPackageName)   el.selectedPackageName.textContent     = pkg.nama;
        if (el.selectedPackageDurasi) el.selectedPackageDurasi.textContent   = pkg.durasi + ' Hari';
        if (el.selectedPackageHarga)  el.selectedPackageHarga.textContent    = fmt(pkg.harga);
        if (el.displayHargaPaket)     el.displayHargaPaket.textContent       = fmt(pkg.harga);
        if (el.idPaket)    el.idPaket.value    = pkg.id;
        if (el.hargaPaket) el.hargaPaket.value = pkg.harga;
        updateExpiredDate();
        calculateTotals();
    }

    function updateExpiredDate() {
        if (!selectedPackage || !el.tglMulai?.value) return;
        if (el.tglSelesai)  el.tglSelesai.textContent    = expDate(selectedPackage.durasi, el.tglMulai.value);
        if (el.expiredInfo) el.expiredInfo.style.display = 'block';
    }

    function addToCart(p) {
        const i = cart.findIndex(x => x.id === p.id);
        if (i !== -1) {
            if (cart[i].qty + 1 > p.stok) { alert('⚠️ Stok tidak cukup! Tersedia: ' + p.stok); return; }
            cart[i].qty++;
        } else {
            if (p.stok < 1) { alert('⚠️ Stok habis!'); return; }
            cart.push({ id: p.id, nama: p.nama, harga: p.harga, qty: 1, stok: p.stok });
        }
        renderCart();
    }

    function renderCart() {
        if (!el.cartItems) return;
        el.cartItems.innerHTML = '';
        if (!cart.length) {
            el.cartItems.innerHTML = `<tr><td colspan="5" style="text-align:center;padding:3rem 1rem;">
                <i class="fas fa-shopping-cart" style="font-size:1.5rem;color:#27124A;display:block;margin-bottom:0.5rem;"></i>
                <p style="color:#6b7280;font-size:0.875rem;">Keranjang kosong</p>
            </td></tr>`;
        } else {
            cart.forEach((item, idx) => {
                const tr = document.createElement('tr');
                tr.className = 'cart-item hover:bg-gray-50 transition-colors';
                tr.innerHTML = `
                    <td class="px-4 py-3">
                        <div class="font-medium text-sm text-gray-800">${esc(item.nama)}</div>
                        <div class="text-xs text-gray-400 mt-0.5">Stok: ${item.stok}</div>
                    </td>
                    <td class="px-4 py-3 text-sm font-semibold text-[#27124A]">${fmt(item.harga)}</td>
                    <td class="px-4 py-3">
                        <div style="display:flex;align-items:center;">
                            <button type="button" class="qty-btn minus rounded-l-lg" data-index="${idx}">-</button>
                            <input type="number" class="qty-input" value="${item.qty}" min="1" max="${item.stok}" data-index="${idx}">
                            <button type="button" class="qty-btn plus rounded-r-lg" data-index="${idx}">+</button>
                        </div>
                    </td>
                    <td class="px-4 py-3 text-sm font-medium text-gray-800">${fmt(item.harga * item.qty)}</td>
                    <td class="px-4 py-3 text-center">
                        <button type="button" class="remove-item text-red-500 hover:text-red-700 p-1.5 rounded-lg transition-colors" data-index="${idx}">
                            <i class="fas fa-trash text-xs"></i>
                        </button>
                    </td>`;
                el.cartItems.appendChild(tr);
            });
            document.querySelectorAll('.minus').forEach(b => b.addEventListener('click', function() { updateQty(+this.dataset.index, cart[+this.dataset.index].qty - 1); }));
            document.querySelectorAll('.plus').forEach(b  => b.addEventListener('click', function() { updateQty(+this.dataset.index, cart[+this.dataset.index].qty + 1); }));
            document.querySelectorAll('.qty-input').forEach(i => i.addEventListener('change', function() { updateQty(+this.dataset.index, parseInt(this.value) || 1); }));
            document.querySelectorAll('.remove-item').forEach(b => b.addEventListener('click', function() {
                if (confirm('Hapus produk dari keranjang?')) { cart.splice(+this.dataset.index, 1); renderCart(); }
            }));
        }
        calculateTotals();
        updateKembali();
    }

    function updateQty(idx, qty) {
        if (!cart[idx]) return;
        if (qty < 1) { cart.splice(idx, 1); renderCart(); return; }
        if (qty > cart[idx].stok) { alert('⚠️ Maks: ' + cart[idx].stok); cart[idx].qty = cart[idx].stok; }
        else cart[idx].qty = qty;
        renderCart();
    }

    function calculateTotals() {
        const sp  = cart.reduce((s, i) => s + i.harga * i.qty, 0);
        const hp  = selectedPackage ? selectedPackage.harga : 0;
        const tot = hp + sp;
        if (el.subtotalProdukRow) el.subtotalProdukRow.style.display = sp > 0 ? 'flex' : 'none';
        if (el.subtotal)          el.subtotal.textContent            = fmt(sp);
        if (el.total)             el.total.textContent               = fmt(tot);
        return tot;
    }

    function updateKembali() {
        const tot   = calculateTotals();
        const bayar = parse(el.uangBayar?.value);
        const kmbl  = bayar - tot;
        if (!el.uangKembali) return;
        if (bayar === 0) {
            el.uangKembali.textContent = fmt(0);
            el.uangKembali.style.color = '#4b5563';
        } else if (kmbl >= 0) {
            el.uangKembali.textContent = fmt(kmbl);
            el.uangKembali.style.color = '#16a34a';
        } else {
            el.uangKembali.textContent = fmt(Math.abs(kmbl)) + ' (Kurang)';
            el.uangKembali.style.color = '#dc2626';
        }
    }

    function validateForm() {
        const checks = [
            [el.nama,           !el.nama?.value.trim(),        '❌ Nama harus diisi'],
            [el.telepon,        !el.telepon?.value.trim(),     '❌ Nomor telepon harus diisi'],
            [el.alamat,         !el.alamat?.value.trim(),      '❌ Alamat harus diisi'],
            [el.tglLahir,       !el.tglLahir?.value,          '❌ Tanggal lahir harus diisi'],
            [el.jenisIdentitas, !el.jenisIdentitas?.value,     '❌ Jenis identitas harus dipilih'],
            [el.noIdentitas,    !el.noIdentitas?.value.trim(), '❌ Nomor identitas harus diisi'],
        ];
        for (const [field, invalid, msg] of checks) {
            if (invalid) { alert(msg); field?.focus(); return false; }
        }
        if (!selectedPackage) { alert('❌ Pilih paket membership terlebih dahulu'); return false; }
        if (!el.tglMulai?.value) { alert('❌ Tanggal mulai harus diisi'); return false; }
        const tot   = calculateTotals();
        const bayar = parse(el.uangBayar?.value);
        if (bayar === 0)   { alert('❌ Masukkan jumlah uang bayar'); el.uangBayar?.focus(); return false; }
        if (bayar < tot)   { alert('❌ Uang bayar kurang dari total'); el.uangBayar?.focus(); return false; }
        return true;
    }

    async function saveTransaction() {
        if (!validateForm()) return;
        const tot   = calculateTotals();
        const bayar = parse(el.uangBayar?.value);
        const fd    = new FormData();
        fd.append('nama',            el.nama.value.trim());
        fd.append('telepon',         el.telepon.value.trim());
        fd.append('alamat',          el.alamat.value.trim());
        fd.append('tgl_lahir',       el.tglLahir.value);
        fd.append('jenis_identitas', el.jenisIdentitas.value);
        fd.append('no_identitas',    el.noIdentitas.value.trim());
        if (el.fotoIdentitas?.files.length) fd.append('foto_identitas', el.fotoIdentitas.files[0]);
        if (IS_RENEW_MODE && EXISTING_MEMBER_ID) fd.append('existing_member_id', EXISTING_MEMBER_ID);
        fd.append('jenis_transaksi', jenisTransaksi);
        fd.append('id_paket',        selectedPackage.id);
        fd.append('tgl_mulai',       el.tglMulai.value);
        fd.append('total_harga',     tot);
        fd.append('uang_bayar',      bayar);
        fd.append('uang_kembali',    bayar - tot);
        fd.append('catatan',         el.catatan?.value || '');
        if (cart.length) fd.append('items', JSON.stringify(cart.map(i => ({ product_id: i.id, qty: i.qty }))));

        if (el.btnSimpan) {
            el.btnSimpan.disabled  = true;
            el.btnSimpan.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Memproses...';
        }
        try {
            const res = await fetch(STORE_URL, {
                method:  'POST',
                headers: { 'X-CSRF-TOKEN': CSRF_TOKEN, 'Accept': 'application/json' },
                body:    fd,
            });
            if (!(res.headers.get('content-type') || '').includes('application/json')) {
                throw new Error('Response bukan JSON: ' + (await res.text()).substring(0, 200));
            }
            const result = await res.json();
            if (result.success) {
                savedTransactionId = result.transaction_id;
                if (el.successTitle)      el.successTitle.textContent      = result.is_renewal ? '✅ Perpanjangan Berhasil!' : '✅ Transaksi Berhasil!';
                if (el.successMessage)    el.successMessage.textContent    = result.message;
                if (el.successNomor)      el.successNomor.textContent      = result.nomor_unik;
                if (el.successNamaMember) el.successNamaMember.textContent = result.member.nama;
                if (el.successKodeMember) el.successKodeMember.textContent = result.member.kode;
                showModal();
                setTimeout(function () {
                    if (confirm('Cetak struk pembayaran?')) {
                        window.open(MEMBERSHIP_URL + '/' + savedTransactionId + '/struk', '_blank');
                    }
                }, 900);
            } else {
                alert('❌ ' + (result.message || 'Terjadi kesalahan'));
            }
        } catch (e) {
            console.error(e);
            alert('❌ Gagal: ' + e.message);
        } finally {
            if (el.btnSimpan) {
                el.btnSimpan.disabled  = false;
                el.btnSimpan.innerHTML = IS_RENEW_MODE
                    ? '<i class="fas fa-redo mr-2"></i> Proses Perpanjangan'
                    : '<i class="fas fa-check-circle mr-2"></i> Proses Membership';
            }
        }
    }

    el.btnCetakStruk?.addEventListener('click', function () {
        if (!savedTransactionId) { alert('ID transaksi belum tersedia'); return; }
        window.open(MEMBERSHIP_URL + '/' + savedTransactionId + '/struk', '_blank');
    });
    el.btnCetakKartu?.addEventListener('click', function () {
        if (!savedTransactionId) { alert('ID transaksi belum tersedia'); return; }
        window.open(MEMBERSHIP_URL + '/' + savedTransactionId + '/kartu', '_blank');
    });
    el.btnTransaksiBaru?.addEventListener('click', function () { window.location.href = CREATE_URL; });
    el.successModal?.addEventListener('click', function (e) { if (e.target === el.successModal) hideModal(); });

    el.jenisCards.forEach(c => c.addEventListener('click', function () { selectJenis(this.dataset.jenis); }));

    el.selectPackageBtns.forEach(btn => {
        btn.addEventListener('click', function (e) {
            e.preventDefault(); e.stopPropagation();
            el.packageCards.forEach(c => c.classList.remove('selected'));
            this.closest('.package-card')?.classList.add('selected');
            selectPackage({ id: +this.dataset.id, nama: this.dataset.nama, durasi: +this.dataset.durasi, harga: +this.dataset.harga });
        });
    });
    el.packageCards.forEach(card => {
        card.addEventListener('click', function (e) {
            if (e.target.closest('button')) return;
            el.packageCards.forEach(c => c.classList.remove('selected'));
            this.classList.add('selected');
            selectPackage({ id: +this.dataset.id, nama: this.dataset.nama, durasi: +this.dataset.durasi, harga: +this.dataset.harga });
        });
    });
    el.addToCartBtns.forEach(btn => {
        btn.addEventListener('click', function (e) {
            e.preventDefault(); e.stopPropagation();
            if (jenisTransaksi !== 'produk_membership') { alert('❌ Pilih jenis "Produk + Membership" terlebih dahulu'); return; }
            addToCart({ id: +this.dataset.id, nama: this.dataset.nama, harga: +this.dataset.harga, stok: +this.dataset.stok });
        });
    });
    el.productCards.forEach(card => {
        card.addEventListener('click', function (e) {
            if (e.target.closest('button')) return;
            if (jenisTransaksi !== 'produk_membership') { alert('❌ Pilih jenis "Produk + Membership" terlebih dahulu'); return; }
            addToCart({ id: +this.dataset.id, nama: this.dataset.nama, harga: +this.dataset.harga, stok: +this.dataset.stok });
        });
    });
    el.searchProduct?.addEventListener('input', function () {
        const q = this.value.toLowerCase();
        document.querySelectorAll('.product-card').forEach(c => {
            c.style.display = c.dataset.nama.toLowerCase().includes(q) || !q ? 'block' : 'none';
        });
    });

    el.telepon?.addEventListener('input', function () {
        this.value = this.value.replace(/\D/g, '').slice(0, 14);
    });
    el.telepon?.addEventListener('keypress', e => { if (!/\d/.test(e.key)) e.preventDefault(); });

    el.noIdentitas?.addEventListener('input', function () {
        this.value = this.value.replace(/\D/g, '');
    });
    el.noIdentitas?.addEventListener('keypress', e => { if (!/\d/.test(e.key)) e.preventDefault(); });

    el.uangBayar?.addEventListener('input', updateKembali);
    el.uangBayar?.addEventListener('keypress', e => { if (!/\d/.test(e.key)) e.preventDefault(); });

    el.quickAmounts.forEach(btn => btn.addEventListener('click', function (e) {
        e.preventDefault();
        if (el.uangBayar) { el.uangBayar.value = this.dataset.amount; updateKembali(); }
    }));
    el.btnUangPas?.addEventListener('click', function (e) {
        e.preventDefault();
        if (el.uangBayar) { el.uangBayar.value = calculateTotals(); updateKembali(); }
    });
    el.btnSimpan?.addEventListener('click', e => { e.preventDefault(); saveTransaction(); });
    el.btnBatal?.addEventListener('click', function (e) {
        e.preventDefault();
        if (confirm('Batalkan transaksi? Semua data akan hilang.')) window.location.href = TRANSAKSI_URL;
    });

    renderCart();
    selectJenis('membership');
    lockTglMulaiToToday();
});
</script>
@endsection