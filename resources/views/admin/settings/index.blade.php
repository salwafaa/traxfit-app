@extends('layouts.app')

@section('title', 'Pengaturan Gym')
@section('page-title', 'Pengaturan Gym')

@section('sidebar')
@include('admin.partials.sidebar')
@endsection

@section('content')
@if(session('success'))
<div class="mb-6 bg-emerald-50 border-l-4 border-emerald-500 rounded-r-xl p-4 shadow-sm">
    <div class="flex items-center">
        <div class="flex-shrink-0">
            <i class="fas fa-check-circle text-emerald-500 text-xl"></i>
        </div>
        <div class="ml-3">
            <p class="text-emerald-700 font-medium">{{ session('success') }}</p>
        </div>
    </div>
</div>
@endif

@if(session('error'))
<div class="mb-6 bg-red-50 border-l-4 border-red-500 rounded-r-xl p-4 shadow-sm">
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

@if($errors->any())
<div class="mb-6 bg-amber-50 border-l-4 border-amber-500 rounded-r-xl p-4 shadow-sm">
    <div class="flex items-start">
        <div class="flex-shrink-0">
            <i class="fas fa-exclamation-triangle text-amber-500 text-xl"></i>
        </div>
        <div class="ml-3">
            <h3 class="text-sm font-semibold text-amber-800">Periksa kembali data berikut:</h3>
            <ul class="mt-2 text-sm text-amber-700 list-disc list-inside space-y-1">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    </div>
</div>
@endif

<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden mb-8">
    <div class="px-6 py-5 border-b border-gray-100 bg-gradient-to-r from-[#1a0f2e] to-[#2d1a4e]">
        <div class="flex items-center gap-4">
            <div class="w-11 h-11 bg-white/10 rounded-xl flex items-center justify-center backdrop-blur-sm">
                <i class="fas fa-sliders-h text-white text-lg"></i>
            </div>
            <div>
                <h3 class="text-lg font-semibold text-white tracking-wide">Konfigurasi Gym</h3>
                <p class="text-sm text-white/70">Kelola informasi utama dan harga layanan</p>
            </div>
        </div>
    </div>

    <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-6">
                <div class="col-span-2">
                    <div class="flex items-center gap-2 border-b border-gray-100 pb-3 mb-2">
                        <i class="fas fa-building text-[#2d1a4e] text-lg"></i>
                        <h4 class="font-semibold text-gray-800 text-base">Identitas Gym</h4>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2" for="nama_gym">
                        Nama Gym <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <span class="absolute left-3 top-3.5 text-gray-400"><i class="fas fa-dumbbell text-sm"></i></span>
                        <input type="text" name="nama_gym" id="nama_gym" required
                               value="{{ old('nama_gym', $setting->nama_gym ?? 'TRAXFIT GYM') }}"
                               class="w-full pl-10 pr-4 py-2.5 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#2d1a4e]/20 focus:border-[#2d1a4e] transition-all">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2" for="telepon">
                        Nomor Telepon
                    </label>
                    <div class="relative">
                        <span class="absolute left-3 top-3.5 text-gray-400"><i class="fas fa-phone-alt text-sm"></i></span>
                        <input type="text" name="telepon" id="telepon"
                               value="{{ old('telepon', $setting->telepon ?? '') }}"
                               class="w-full pl-10 pr-4 py-2.5 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#2d1a4e]/20 focus:border-[#2d1a4e] transition-all">
                    </div>
                </div>

                <div class="col-span-2">
                    <label class="block text-sm font-semibold text-gray-700 mb-2" for="alamat">
                        Alamat Lengkap
                    </label>
                    <div class="relative">
                        <span class="absolute left-3 top-3.5 text-gray-400"><i class="fas fa-map-marker-alt text-sm"></i></span>
                        <textarea name="alamat" id="alamat" rows="2"
                                  class="w-full pl-10 pr-4 py-2.5 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#2d1a4e]/20 focus:border-[#2d1a4e] transition-all">{{ old('alamat', $setting->alamat ?? '') }}</textarea>
                    </div>
                </div>

                <div class="col-span-2">
                    <div class="bg-gradient-to-r from-amber-50 to-yellow-50 border border-amber-200 rounded-xl p-5 mt-2">
                        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-amber-100 rounded-xl flex items-center justify-center">
                                    <i class="fas fa-ticket-alt text-amber-600 text-lg"></i>
                                </div>
                                <div>
                                    <label class="block text-sm font-bold text-amber-800" for="harga_visit">
                                        Harga Visit Harian
                                    </label>
                                    <p class="text-xs text-amber-600">Digunakan untuk transaksi kasir (Visit & Produk+Visit)</p>
                                </div>
                            </div>
                            <div class="w-full md:w-64">
                                <div class="relative">
                                    <span class="absolute left-4 top-2.5 text-gray-500 font-medium">Rp</span>
                                    <input type="number" name="harga_visit" id="harga_visit" required min="0" step="1000"
                                           value="{{ old('harga_visit', $setting->harga_visit ?? 25000) }}"
                                           class="w-full pl-12 pr-4 py-2.5 border border-amber-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-amber-500/30 focus:border-amber-500 text-lg font-bold text-amber-800">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-span-2 md:col-span-1">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Logo Gym
                    </label>
                    <div class="border-2 border-dashed border-gray-200 rounded-xl p-5 text-center bg-gray-50/30 hover:bg-gray-50 transition">
                        @if($setting && $setting->logo)
                        <div class="mb-3 flex justify-center">
                            <img src="{{ Storage::url($setting->logo) }}" alt="Logo Gym" class="h-16 w-auto object-contain rounded-lg shadow-sm">
                        </div>
                        @else
                        <div class="mb-2 text-gray-400">
                            <i class="fas fa-image text-3xl"></i>
                        </div>
                        @endif
                        <input type="file" name="logo" id="logo" accept="image/*"
                               class="w-full text-sm text-gray-500 file:mr-3 file:py-1.5 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-[#2d1a4e] file:text-white hover:file:bg-[#1f1038] transition-all">
                        <p class="text-xs text-gray-400 mt-2">JPG, PNG (max 2MB)</p>
                    </div>
                </div>

                <div class="col-span-2 md:col-span-1">
                    <label class="block text-sm font-semibold text-gray-700 mb-2" for="footer_struk">
                        Footer Struk
                    </label>
                    <div class="relative">
                        <span class="absolute left-3 top-2.5 text-gray-400"><i class="fas fa-receipt text-sm"></i></span>
                        <input type="text" name="footer_struk" id="footer_struk"
                               value="{{ old('footer_struk', $setting->footer_struk ?? 'Terima kasih telah berolahraga bersama kami!') }}"
                               class="w-full pl-10 pr-4 py-2.5 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#2d1a4e]/20 focus:border-[#2d1a4e] transition-all">
                    </div>
                    <p class="text-xs text-gray-400 mt-1">Pesan yang muncul di bagian bawah setiap struk</p>
                </div>
            </div>
            
            <div class="mt-8 pt-4 border-t border-gray-100 flex justify-end gap-3">
                <a href="{{ route('admin.dashboard') }}" 
                   class="px-5 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium rounded-xl transition-all duration-200 flex items-center gap-2">
                    <i class="fas fa-times"></i> Batal
                </a>
                <button type="submit"
                        class="px-6 py-2.5 bg-gradient-to-r from-[#2d1a4e] to-[#1f1038] hover:from-[#3a2068] hover:to-[#2d1a4e] text-white font-semibold rounded-xl transition-all duration-200 shadow-sm hover:shadow-md flex items-center gap-2">
                    <i class="fas fa-save"></i> Simpan Pengaturan
                </button>
            </div>
        </div>
    </form>
</div>

@endsection