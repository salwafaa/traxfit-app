@extends('layouts.app')

@section('title', 'Pengaturan Gym')
@section('page-title', 'Pengaturan Gym')

@section('sidebar')
@include('admin.partials.sidebar')
@endsection

@section('content')
<!-- TAMPILKAN PESAN SUCCESS -->
@if(session('success'))
<div class="mb-6 bg-green-50 border border-green-200 rounded-xl p-4">
    <div class="flex items-center">
        <div class="flex-shrink-0">
            <i class="fas fa-check-circle text-green-500 text-xl"></i>
        </div>
        <div class="ml-3">
            <p class="text-green-700 font-medium">{{ session('success') }}</p>
        </div>
    </div>
</div>
@endif

<!-- TAMPILKAN PESAN ERROR -->
@if(session('error'))
<div class="mb-6 bg-red-50 border border-red-200 rounded-xl p-4">
    <div class="flex items-center">
        <div class="flex-shrink-0">
            <i class="fas fa-exclamation-circle text-red-500 text-xl"></i>
        </div>
        <div class="ml-3">
            <p class="text-red-700 font-medium">{{ session('error') }}</p>
        </div>
    </div>
</div>
@endif

<!-- TAMPILKAN VALIDATION ERRORS -->
@if($errors->any())
<div class="mb-6 bg-red-50 border border-red-200 rounded-xl p-4">
    <div class="flex items-start">
        <div class="flex-shrink-0">
            <i class="fas fa-exclamation-circle text-red-500 text-xl"></i>
        </div>
        <div class="ml-3">
            <h3 class="text-sm font-medium text-red-800">Terjadi kesalahan:</h3>
            <ul class="mt-2 text-sm text-red-700 list-disc list-inside">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    </div>
</div>
@endif

<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden mb-8">
    <!-- Header -->
    <div class="p-6 border-b border-gray-100 bg-gradient-to-r from-[#27124A] to-[#3a1d6b]">
        <div class="flex items-center">
            <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center mr-4">
                <i class="fas fa-cog text-white text-xl"></i>
            </div>
            <div>
                <h3 class="text-lg font-semibold text-white">Pengaturan Gym</h3>
                <p class="text-sm text-white/80">Atur informasi dan harga layanan gym</p>
            </div>
        </div>
    </div>

    <!-- Form -->
    <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Informasi Dasar -->
                <div class="col-span-2">
                    <h4 class="font-semibold text-gray-800 mb-4 flex items-center">
                        <i class="fas fa-info-circle text-[#27124A] mr-2"></i>
                        Informasi Dasar
                    </h4>
                </div>

                <!-- Nama Gym -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2" for="nama_gym">
                        Nama Gym <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="nama_gym" id="nama_gym" required
                           value="{{ old('nama_gym', $setting->nama_gym ?? 'TRAXFIT GYM') }}"
                           class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#27124A]/20 focus:border-[#27124A] transition-all @error('nama_gym') border-red-300 bg-red-50 @enderror">
                    @error('nama_gym')
                        <div class="mt-1 text-xs text-red-600">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Telepon -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2" for="telepon">
                        Nomor Telepon
                    </label>
                    <input type="text" name="telepon" id="telepon"
                           value="{{ old('telepon', $setting->telepon ?? '') }}"
                           class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#27124A]/20 focus:border-[#27124A] transition-all @error('telepon') border-red-300 bg-red-50 @enderror">
                    @error('telepon')
                        <div class="mt-1 text-xs text-red-600">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Email -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2" for="email">
                        Email
                    </label>
                    <input type="email" name="email" id="email"
                           value="{{ old('email', $setting->email ?? '') }}"
                           class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#27124A]/20 focus:border-[#27124A] transition-all @error('email') border-red-300 bg-red-50 @enderror">
                    @error('email')
                        <div class="mt-1 text-xs text-red-600">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Alamat -->
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2" for="alamat">
                        Alamat
                    </label>
                    <textarea name="alamat" id="alamat" rows="3"
                              class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#27124A]/20 focus:border-[#27124A] transition-all @error('alamat') border-red-300 bg-red-50 @enderror">{{ old('alamat', $setting->alamat ?? '') }}</textarea>
                    @error('alamat')
                        <div class="mt-1 text-xs text-red-600">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Harga Visit -->
                <div class="col-span-2 md:col-span-1">
                    <div class="bg-yellow-50 border border-yellow-200 rounded-xl p-5 mt-4">
                        <label class="block text-sm font-medium text-yellow-800 mb-2" for="harga_visit">
                            <i class="fas fa-walking text-yellow-600 mr-2"></i>
                            Harga Visit Harian <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <span class="absolute left-4 top-3.5 text-gray-500">Rp</span>
                            <input type="number" name="harga_visit" id="harga_visit" required min="0" step="1000"
                                   value="{{ old('harga_visit', $setting->harga_visit ?? 25000) }}"
                                   class="w-full pl-12 pr-4 py-3 border border-yellow-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-yellow-500/20 focus:border-yellow-500 transition-all text-lg font-bold @error('harga_visit') border-red-300 bg-red-50 @enderror">
                        </div>
                        @error('harga_visit')
                            <div class="mt-1 text-xs text-red-600">{{ $message }}</div>
                        @enderror
                        <p class="text-xs text-yellow-600 mt-2">
                            <i class="fas fa-info-circle mr-1"></i>
                            Harga ini akan digunakan untuk transaksi "Visit Only" dan "Produk + Visit" di kasir.
                        </p>
                    </div>
                </div>

                <!-- Logo -->
                <div class="col-span-2 md:col-span-1">
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Logo Gym
                    </label>
                    <div class="border-2 border-dashed border-gray-200 rounded-xl p-6 text-center">
                        @if($setting && $setting->logo)
                        <div class="mb-4">
                            <img src="{{ Storage::url($setting->logo) }}" alt="Logo" class="h-20 mx-auto object-contain">
                        </div>
                        @endif
                        <input type="file" name="logo" id="logo" accept="image/*"
                               class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-[#27124A]/10 file:text-[#27124A] hover:file:bg-[#27124A]/20 transition-all">
                        <p class="text-xs text-gray-400 mt-2">Format: JPG, PNG. Maks: 2MB</p>
                    </div>
                </div>

                <!-- Footer Struk -->
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2" for="footer_struk">
                        Footer Struk
                    </label>
                    <input type="text" name="footer_struk" id="footer_struk"
                           value="{{ old('footer_struk', $setting->footer_struk ?? 'Terima kasih telah berolahraga bersama kami!') }}"
                           class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#27124A]/20 focus:border-[#27124A] transition-all @error('footer_struk') border-red-300 bg-red-50 @enderror"
                           placeholder="Contoh: Gym Sehat, Jasmani Kuat">
                    @error('footer_struk')
                        <div class="mt-1 text-xs text-red-600">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <!-- Info Penting -->
            <div class="mt-8 bg-blue-50 border border-blue-200 rounded-xl p-5">
                <div class="flex items-start">
                    <div class="flex-shrink-0 w-10 h-10 bg-blue-500 rounded-xl flex items-center justify-center shadow-sm">
                        <i class="fas fa-lightbulb text-white"></i>
                    </div>
                    <div class="ml-4 flex-1">
                        <h4 class="font-semibold text-blue-800 mb-2">Informasi Penting</h4>
                        <ul class="space-y-2 text-sm text-blue-700">
                            <li class="flex items-start">
                                <i class="fas fa-check-circle mt-0.5 mr-2 flex-shrink-0"></i>
                                <span><strong>Harga Visit</strong> - Harga ini akan digunakan untuk transaksi visit di kasir. Pastikan sudah sesuai dengan tarif yang berlaku.</span>
                            </li>
                            <li class="flex items-start">
                                <i class="fas fa-check-circle mt-0.5 mr-2 flex-shrink-0"></i>
                                <span><strong>Logo</strong> - Akan muncul di struk dan laporan.</span>
                            </li>
                            <li class="flex items-start">
                                <i class="fas fa-check-circle mt-0.5 mr-2 flex-shrink-0"></i>
                                <span><strong>Footer Struk</strong> - Pesan yang akan muncul di bagian bawah setiap struk.</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="mt-10 pt-6 border-t border-gray-100">
                <div class="flex justify-end space-x-4">
                    <a href="{{ route('admin.dashboard') }}" 
                       class="px-6 py-3 bg-gray-100 hover:bg-gray-200 text-gray-800 font-medium rounded-xl transition-all duration-300">
                        <i class="fas fa-times mr-2"></i> Batal
                    </a>
                    <button type="submit"
                            class="px-6 py-3 bg-[#27124A] hover:bg-[#3a1d6b] text-white font-medium rounded-xl transition-all duration-300 shadow-sm hover:shadow-md">
                        <i class="fas fa-save mr-2"></i> Simpan Pengaturan
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>

<!-- Preview Harga Visit -->
<div class="bg-gradient-to-r from-purple-50 to-pink-50 border border-purple-200 rounded-2xl p-6">
    <h3 class="font-semibold text-[#27124A] mb-4">🔄 Preview Penggunaan Harga Visit</h3>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="bg-white p-4 rounded-xl border border-purple-100">
            <div class="flex items-center">
                <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center mr-4">
                    <i class="fas fa-walking text-green-600 text-xl"></i>
                </div>
                <div>
                    <h4 class="font-semibold text-gray-800">Visit Only</h4>
                    <p class="text-sm text-gray-500">Transaksi hanya visit gym</p>
                    <p class="text-lg font-bold text-green-600 mt-2">Rp {{ number_format($setting->harga_visit ?? 25000, 0, ',', '.') }}</p>
                </div>
            </div>
        </div>
        <div class="bg-white p-4 rounded-xl border border-purple-100">
            <div class="flex items-center">
                <div class="w-12 h-12 bg-orange-100 rounded-xl flex items-center justify-center mr-4">
                    <i class="fas fa-box text-orange-600 text-xl"></i>
                    <i class="fas fa-walking text-orange-600 text-lg -ml-2"></i>
                </div>
                <div>
                    <h4 class="font-semibold text-gray-800">Produk + Visit</h4>
                    <p class="text-sm text-gray-500">Total = Harga Produk + Harga Visit</p>
                    <p class="text-lg font-bold text-orange-600 mt-2">Rp (Produk) + {{ number_format($setting->harga_visit ?? 25000, 0, ',', '.') }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection