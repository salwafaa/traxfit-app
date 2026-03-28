@extends('layouts.app')

@section('title', 'Tambah Paket Membership')
@section('page-title', 'Tambah Paket Membership Baru')

@section('sidebar')
@include('admin.partials.sidebar')
@endsection

@section('content')
<!-- Header Card -->
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden mb-6">
    <div class="px-6 py-5 bg-gradient-to-r from-[#27124A] to-[#3a1d6b]">
        <div class="flex items-center">
            <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center mr-4">
                <i class="fas fa-gift text-white text-xl"></i>
            </div>
            <div>
                <h3 class="text-lg font-semibold text-white">Form Tambah Paket Membership</h3>
                <p class="text-sm text-white/80">Buat paket membership baru untuk member gym</p>
            </div>
        </div>
    </div>
</div>

<!-- Main Form -->
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden mb-8">
    <div class="p-6">
        <form action="{{ route('admin.packages.store') }}" method="POST">
            @csrf
            
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Left Column - Form Fields -->
                <div class="space-y-6">
                    <!-- Nama Paket -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2" for="nama_paket">
                            Nama Paket <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <input type="text" name="nama_paket" id="nama_paket" required
                                   value="{{ old('nama_paket') }}"
                                   class="w-full px-4 py-3 pl-11 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#27124A]/20 focus:border-[#27124A] transition-all duration-300"
                                   placeholder="Contoh: Paket 1 Bulan, Paket 3 Bulan">
                            <div class="absolute left-3 top-1/2 transform -translate-y-1/2">
                                <i class="fas fa-tag text-gray-400"></i>
                            </div>
                        </div>
                        @error('nama_paket')
                            <div class="mt-2 text-sm text-red-600 bg-red-50 p-3 rounded-lg">
                                <i class="fas fa-exclamation-circle mr-2"></i>{{ $message }}
                            </div>
                        @enderror
                    </div>
                    
                    <!-- Durasi Hari -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2" for="durasi_hari">
                            Durasi (hari) <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <input type="number" name="durasi_hari" id="durasi_hari" required min="1"
                                   value="{{ old('durasi_hari') }}"
                                   class="w-full px-4 py-3 pl-11 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#27124A]/20 focus:border-[#27124A] transition-all duration-300"
                                   placeholder="Masukkan jumlah hari">
                            <div class="absolute left-3 top-1/2 transform -translate-y-1/2">
                                <i class="fas fa-calendar text-gray-400"></i>
                            </div>
                        </div>
                        <div class="mt-2 text-xs text-gray-500 flex items-center">
                            <i class="fas fa-lightbulb text-yellow-500 mr-1"></i>
                            Contoh: 30 (1 bulan), 90 (3 bulan), 365 (1 tahun)
                        </div>
                        @error('durasi_hari')
                            <div class="mt-2 text-sm text-red-600 bg-red-50 p-3 rounded-lg">
                                <i class="fas fa-exclamation-circle mr-2"></i>{{ $message }}
                            </div>
                        @enderror
                    </div>
                    
                    <!-- Harga -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2" for="harga">
                            Harga (Rp) <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <input type="number" name="harga" id="harga" required min="0"
                                   value="{{ old('harga') }}"
                                   class="w-full px-4 py-3 pl-11 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#27124A]/20 focus:border-[#27124A] transition-all duration-300"
                                   placeholder="Masukkan harga">
                            <div class="absolute left-3 top-1/2 transform -translate-y-1/2">
                                <i class="fas fa-money-bill text-gray-400"></i>
                            </div>
                        </div>
                        @error('harga')
                            <div class="mt-2 text-sm text-red-600 bg-red-50 p-3 rounded-lg">
                                <i class="fas fa-exclamation-circle mr-2"></i>{{ $message }}
                            </div>
                        @enderror
                    </div>
                    
                    <!-- Status -->
                    <div class="flex items-center p-4 bg-gray-50 rounded-xl border border-gray-200">
                        <input type="checkbox" name="status" id="status" value="1" {{ old('status', true) ? 'checked' : '' }}
                               class="h-5 w-5 text-[#27124A] focus:ring-[#27124A]/20 border-gray-300 rounded transition-all duration-300">
                        <label for="status" class="ml-3 block text-sm font-medium text-gray-700">
                            <i class="fas fa-toggle-on text-[#27124A] mr-2"></i>Aktifkan paket setelah dibuat
                        </label>
                    </div>
                </div>
                
                <!-- Right Column - Preview -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-3">
                        <i class="fas fa-eye text-[#27124A] mr-2"></i>Preview Paket
                    </label>
                    <div id="preview" class="border-2 border-dashed border-gray-200 rounded-2xl p-6 bg-gradient-to-br from-gray-50 to-white hover:border-[#27124A]/30 transition-all duration-300">
                        <div class="text-center">
                            <!-- Icon -->
                            <div class="inline-flex items-center justify-center w-20 h-20 bg-[#27124A]/10 rounded-2xl mb-4">
                                <i class="fas fa-gift text-[#27124A] text-3xl"></i>
                            </div>
                            
                            <!-- Nama Paket -->
                            <h5 class="text-xl font-bold text-gray-800 mb-4" id="preview_nama">-</h5>
                            
                            <!-- Info Cards -->
                            <div class="grid grid-cols-2 gap-4 mb-4">
                                <div class="bg-white p-4 rounded-xl border border-gray-100">
                                    <div class="text-xs text-gray-500 mb-1">Durasi</div>
                                    <div class="text-lg font-bold text-[#27124A]" id="preview_durasi">-</div>
                                </div>
                                <div class="bg-white p-4 rounded-xl border border-gray-100">
                                    <div class="text-xs text-gray-500 mb-1">Harga Total</div>
                                    <div class="text-lg font-bold text-green-600" id="preview_harga">Rp 0</div>
                                </div>
                            </div>
                            
                            <!-- Harga per Hari -->
                            <div class="bg-[#27124A]/5 p-4 rounded-xl border border-[#27124A]/10">
                                <div class="text-sm text-gray-600 mb-1">Harga per Hari:</div>
                                <div class="text-xl font-bold text-[#27124A]" id="preview_harian">Rp 0/hari</div>
                                <div class="text-xs text-gray-500 mt-2">*Semakin panjang durasi, semakin hemat</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Action Buttons -->
            <div class="mt-10 pt-6 border-t border-gray-100">
                <div class="flex flex-col sm:flex-row justify-between items-center gap-4">
                    <div class="text-sm text-gray-500">
                        <i class="fas fa-info-circle text-[#27124A] mr-2"></i>
                        Pastikan data paket sudah benar sebelum disimpan
                    </div>
                    <div class="flex space-x-3">
                        <a href="{{ route('admin.packages.index') }}" 
                           class="px-6 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium rounded-xl transition-all duration-300 flex items-center border border-gray-200">
                            <i class="fas fa-times mr-2"></i> Batal
                        </a>
                        <button type="submit"
                                class="px-6 py-2.5 bg-[#27124A] hover:bg-[#3a1d6b] text-white font-medium rounded-xl transition-all duration-300 flex items-center shadow-sm hover:shadow-md">
                            <i class="fas fa-save mr-2"></i> Simpan Paket
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const namaInput = document.getElementById('nama_paket');
    const durasiInput = document.getElementById('durasi_hari');
    const hargaInput = document.getElementById('harga');
    
    function updatePreview() {
        const nama = namaInput.value || '-';
        const durasi = durasiInput.value ? parseInt(durasiInput.value) : 0;
        const harga = hargaInput.value ? parseInt(hargaInput.value) : 0;
        
        // Update preview
        document.getElementById('preview_nama').textContent = nama;
        
        if (durasi > 0) {
            let durasiText = durasi + ' hari';
            if (durasi >= 365) {
                const tahun = Math.floor(durasi / 365);
                durasiText += ` (${tahun} tahun)`;
            } else if (durasi >= 30) {
                const bulan = Math.floor(durasi / 30);
                durasiText += ` (${bulan} bulan)`;
            }
            document.getElementById('preview_durasi').textContent = durasiText;
        } else {
            document.getElementById('preview_durasi').textContent = '-';
        }
        
        if (harga > 0) {
            document.getElementById('preview_harga').textContent = formatRupiah(harga);
            
            if (durasi > 0) {
                const hargaPerHari = Math.round(harga / durasi);
                document.getElementById('preview_harian').textContent = formatRupiah(hargaPerHari) + '/hari';
            } else {
                document.getElementById('preview_harian').textContent = 'Rp 0/hari';
            }
        } else {
            document.getElementById('preview_harga').textContent = 'Rp 0';
            document.getElementById('preview_harian').textContent = 'Rp 0/hari';
        }
    }
    
    function formatRupiah(angka) {
        return 'Rp ' + angka.toLocaleString('id-ID');
    }
    
    // Event listeners
    namaInput.addEventListener('input', updatePreview);
    durasiInput.addEventListener('input', updatePreview);
    hargaInput.addEventListener('input', updatePreview);
    
    // Initial preview
    updatePreview();
});
</script>
@endpush