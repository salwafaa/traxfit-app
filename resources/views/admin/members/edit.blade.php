@extends('layouts.app')

@section('title', 'Edit Member')
@section('page-title', 'Edit Data Member')

@section('sidebar')
@include('admin.partials.sidebar')
@endsection

@section('content')
<!-- Header Card -->
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden mb-6">
    <div class="px-6 py-5 bg-gradient-to-r from-[#27124A] to-[#3a1d6b]">
        <div class="flex items-center justify-between">
            <div class="flex items-center">
                <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center mr-4">
                    <i class="fas fa-user-edit text-white text-xl"></i>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-white">Edit Data Member</h3>
                    <p class="text-sm text-white/80">Perbarui informasi member yang sudah terdaftar</p>
                </div>
            </div>
            <div class="flex items-center space-x-3">
                <div class="bg-white/20 px-4 py-2 rounded-xl">
                    <div class="text-xs text-white/70">Kode Member</div>
                    <div class="font-mono font-bold text-white">{{ $member->kode_member }}</div>
                </div>
                @if($member->is_active)
                <span class="px-3 py-1.5 bg-green-500/20 text-green-300 rounded-lg text-sm font-medium border border-green-500/30">
                    <i class="fas fa-check-circle mr-1"></i> Aktif
                </span>
                @else
                <span class="px-3 py-1.5 bg-red-500/20 text-red-300 rounded-lg text-sm font-medium border border-red-500/30">
                    <i class="fas fa-times-circle mr-1"></i> {{ $member->status == 'expired' ? 'Expired' : 'Tidak Aktif' }}
                </span>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Main Form -->
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden mb-8">
    <div class="p-6">
        <form action="{{ route('admin.members.update', $member->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <!-- Section 1: Informasi Pribadi -->
            <div class="mb-8">
                <div class="flex items-center mb-5">
                    <div class="w-1 h-6 bg-[#27124A] rounded-full mr-3"></div>
                    <h4 class="text-base font-semibold text-gray-800">
                        <i class="fas fa-user-circle text-[#27124A] mr-2"></i>Informasi Pribadi
                    </h4>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <!-- Nama Lengkap -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2" for="nama">
                            Nama Lengkap <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <input type="text" name="nama" id="nama" required
                                   value="{{ old('nama', $member->nama) }}"
                                   class="w-full px-4 py-3 pl-10 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#27124A]/20 focus:border-[#27124A] transition-all duration-300">
                            <div class="absolute left-3 top-1/2 transform -translate-y-1/2">
                                <i class="fas fa-user text-gray-400 text-sm"></i>
                            </div>
                        </div>
                        @error('nama')
                            <div class="mt-2 text-sm text-red-600 bg-red-50 p-3 rounded-lg">
                                <i class="fas fa-exclamation-circle mr-2"></i>{{ $message }}
                            </div>
                        @enderror
                    </div>
                    
                    <!-- Nomor Telepon -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2" for="telepon">
                            Nomor Telepon
                        </label>
                        <div class="relative">
                            <input type="tel" name="telepon" id="telepon"
                                   value="{{ old('telepon', $member->telepon) }}"
                                   class="w-full px-4 py-3 pl-10 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#27124A]/20 focus:border-[#27124A] transition-all duration-300"
                                   placeholder="0812xxxxxxxx">
                            <div class="absolute left-3 top-1/2 transform -translate-y-1/2">
                                <i class="fas fa-phone text-gray-400 text-sm"></i>
                            </div>
                        </div>
                        @error('telepon')
                            <div class="mt-2 text-sm text-red-600 bg-red-50 p-3 rounded-lg">
                                <i class="fas fa-exclamation-circle mr-2"></i>{{ $message }}
                            </div>
                        @enderror
                    </div>
                    
                    <!-- Alamat (Full width) -->
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-2" for="alamat">
                            Alamat
                        </label>
                        <div class="relative">
                            <textarea name="alamat" id="alamat" rows="3"
                                      class="w-full px-4 py-3 pl-10 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#27124A]/20 focus:border-[#27124A] transition-all duration-300 resize-none">{{ old('alamat', $member->alamat) }}</textarea>
                            <div class="absolute left-3 top-4">
                                <i class="fas fa-map-marker-alt text-gray-400 text-sm"></i>
                            </div>
                        </div>
                        @error('alamat')
                            <div class="mt-2 text-sm text-red-600 bg-red-50 p-3 rounded-lg">
                                <i class="fas fa-exclamation-circle mr-2"></i>{{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
            </div>
            
            <!-- Section 2: Informasi Identitas -->
            <div class="mb-8">
                <div class="flex items-center mb-5">
                    <div class="w-1 h-6 bg-[#27124A] rounded-full mr-3"></div>
                    <h4 class="text-base font-semibold text-gray-800">
                        <i class="fas fa-id-card text-[#27124A] mr-2"></i>Informasi Identitas
                    </h4>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <!-- Jenis Identitas -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2" for="jenis_identitas">
                            Jenis Identitas
                        </label>
                        <div class="relative">
                            <select name="jenis_identitas" id="jenis_identitas"
                                    class="w-full px-4 py-3 pl-10 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#27124A]/20 focus:border-[#27124A] transition-all duration-300 appearance-none">
                                <option value="">Pilih Jenis Identitas</option>
                                <option value="KTP" {{ old('jenis_identitas', $member->jenis_identitas) == 'KTP' ? 'selected' : '' }}>KTP</option>
                                <option value="Passport" {{ old('jenis_identitas', $member->jenis_identitas) == 'Passport' ? 'selected' : '' }}>Passport</option>
                                <option value="SIM" {{ old('jenis_identitas', $member->jenis_identitas) == 'SIM' ? 'selected' : '' }}>SIM</option>
                                <option value="Other" {{ old('jenis_identitas', $member->jenis_identitas) == 'Other' ? 'selected' : '' }}>Lainnya</option>
                            </select>
                            <div class="absolute left-3 top-1/2 transform -translate-y-1/2">
                                <i class="fas fa-id-card text-gray-400 text-sm"></i>
                            </div>
                            <div class="absolute right-3 top-1/2 transform -translate-y-1/2">
                                <i class="fas fa-chevron-down text-gray-400 text-sm"></i>
                            </div>
                        </div>
                        @error('jenis_identitas')
                            <div class="mt-2 text-sm text-red-600 bg-red-50 p-3 rounded-lg">
                                <i class="fas fa-exclamation-circle mr-2"></i>{{ $message }}
                            </div>
                        @enderror
                    </div>
                    
                    <!-- Nomor Identitas -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2" for="no_identitas">
                            Nomor Identitas
                        </label>
                        <div class="relative">
                            <input type="text" name="no_identitas" id="no_identitas"
                                   value="{{ old('no_identitas', $member->no_identitas) }}"
                                   class="w-full px-4 py-3 pl-10 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#27124A]/20 focus:border-[#27124A] transition-all duration-300"
                                   placeholder="Nomor KTP/Passport/SIM">
                            <div class="absolute left-3 top-1/2 transform -translate-y-1/2">
                                <i class="fas fa-hashtag text-gray-400 text-sm"></i>
                            </div>
                        </div>
                        @error('no_identitas')
                            <div class="mt-2 text-sm text-red-600 bg-red-50 p-3 rounded-lg">
                                <i class="fas fa-exclamation-circle mr-2"></i>{{ $message }}
                            </div>
                        @enderror
                    </div>
                    
                    <!-- Tanggal Lahir -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2" for="tgl_lahir">
                            Tanggal Lahir
                        </label>
                        <div class="relative">
                            <input type="date" name="tgl_lahir" id="tgl_lahir"
                                   value="{{ old('tgl_lahir', $member->tgl_lahir ? $member->tgl_lahir->format('Y-m-d') : '') }}"
                                   class="w-full px-4 py-3 pl-10 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#27124A]/20 focus:border-[#27124A] transition-all duration-300">
                            <div class="absolute left-3 top-1/2 transform -translate-y-1/2">
                                <i class="fas fa-birthday-cake text-gray-400 text-sm"></i>
                            </div>
                        </div>
                        @error('tgl_lahir')
                            <div class="mt-2 text-sm text-red-600 bg-red-50 p-3 rounded-lg">
                                <i class="fas fa-exclamation-circle mr-2"></i>{{ $message }}
                            </div>
                        @enderror
                    </div>
                    
                    <!-- Foto Identitas -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2" for="foto_identitas">
                            Foto Identitas
                        </label>
                        <div class="relative">
                            <input type="file" name="foto_identitas" id="foto_identitas" accept="image/jpeg,image/png,image/jpg"
                                   class="w-full px-4 py-3 pl-10 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#27124A]/20 focus:border-[#27124A] transition-all duration-300 file:mr-3 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-[#27124A] file:text-white hover:file:bg-[#3a1d6b]">
                            <div class="absolute left-3 top-1/2 transform -translate-y-1/2">
                                <i class="fas fa-image text-gray-400 text-sm"></i>
                            </div>
                        </div>
                        <p class="mt-1 text-xs text-gray-500">
                            <i class="fas fa-info-circle mr-1"></i> Format: JPG, JPEG, PNG. Maksimal 2MB
                        </p>
                        @error('foto_identitas')
                            <div class="mt-2 text-sm text-red-600 bg-red-50 p-3 rounded-lg">
                                <i class="fas fa-exclamation-circle mr-2"></i>{{ $message }}
                            </div>
                        @enderror
                    </div>
                    
                    <!-- Preview Foto Identitas -->
                    @if($member->foto_identitas_url)
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Foto Identitas Saat Ini</label>
                        <div class="bg-gray-50 p-4 rounded-xl border border-gray-200">
                            <div class="flex items-start gap-4 flex-wrap">
                                <div class="relative group">
                                    <img src="{{ $member->foto_identitas_url }}" 
                                         alt="Foto Identitas {{ $member->nama }}"
                                         class="w-32 h-32 object-cover rounded-lg border border-gray-300 shadow-sm cursor-pointer hover:opacity-90 transition-opacity"
                                         onclick="window.open(this.src, '_blank')">
                                    <button type="button" onclick="window.open('{{ $member->foto_identitas_url }}', '_blank')"
                                            class="absolute bottom-1 right-1 bg-black bg-opacity-50 text-white p-1 rounded-lg text-xs opacity-0 group-hover:opacity-100 transition-opacity">
                                        <i class="fas fa-expand"></i>
                                    </button>
                                </div>
                                <div class="flex-1">
                                    <p class="text-sm text-gray-600 mb-2">Foto identitas yang terdaftar saat ini</p>
                                    <div class="flex gap-2">
                                        <a href="{{ $member->foto_identitas_url }}" 
                                           download
                                           class="inline-flex items-center gap-2 px-3 py-1.5 bg-blue-50 text-blue-600 rounded-lg text-xs hover:bg-blue-100 transition-colors">
                                            <i class="fas fa-download"></i>
                                            Download
                                        </a>
                                        <span class="text-xs text-gray-500 self-center">
                                            Upload file baru untuk mengganti foto ini
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
            
            <!-- Section 3: Detail Membership -->
            <div class="mb-8">
                <div class="flex items-center mb-5">
                    <div class="w-1 h-6 bg-[#27124A] rounded-full mr-3"></div>
                    <h4 class="text-base font-semibold text-gray-800">
                        <i class="fas fa-id-card-alt text-[#27124A] mr-2"></i>Detail Membership
                    </h4>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <!-- Paket Membership -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2" for="id_paket">
                            Paket Membership <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <select name="id_paket" id="id_paket" required
                                    class="w-full px-4 py-3 pl-10 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#27124A]/20 focus:border-[#27124A] transition-all duration-300 appearance-none">
                                <option value="">Pilih Paket Membership</option>
                                @foreach($packages as $package)
                                    <option value="{{ $package->id }}" 
                                            {{ old('id_paket', $member->id_paket) == $package->id ? 'selected' : '' }}
                                            data-durasi="{{ $package->durasi_hari }}">
                                        {{ $package->nama_paket }} ({{ $package->durasi_hari }} hari) - {{ $package->harga_formatted }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="absolute left-3 top-1/2 transform -translate-y-1/2">
                                <i class="fas fa-gift text-gray-400 text-sm"></i>
                            </div>
                            <div class="absolute right-3 top-1/2 transform -translate-y-1/2">
                                <i class="fas fa-chevron-down text-gray-400 text-sm"></i>
                            </div>
                        </div>
                        @error('id_paket')
                            <div class="mt-2 text-sm text-red-600 bg-red-50 p-3 rounded-lg">
                                <i class="fas fa-exclamation-circle mr-2"></i>{{ $message }}
                            </div>
                        @enderror
                    </div>
                    
                    <!-- Tanggal Expired -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2" for="tgl_expired">
                            Tanggal Expired <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <input type="date" name="tgl_expired" id="tgl_expired" required
                                   value="{{ old('tgl_expired', $member->tgl_expired ? $member->tgl_expired->format('Y-m-d') : '') }}"
                                   class="w-full px-4 py-3 pl-10 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#27124A]/20 focus:border-[#27124A] transition-all duration-300">
                            <div class="absolute left-3 top-1/2 transform -translate-y-1/2">
                                <i class="fas fa-calendar text-gray-400 text-sm"></i>
                            </div>
                        </div>
                        <div class="mt-2 text-sm">
                            <i class="fas fa-clock mr-1"></i> Sisa hari: <span id="sisaHariDisplay" class="font-bold"></span>
                        </div>
                        @error('tgl_expired')
                            <div class="mt-2 text-sm text-red-600 bg-red-50 p-3 rounded-lg">
                                <i class="fas fa-exclamation-circle mr-2"></i>{{ $message }}
                            </div>
                        @enderror
                    </div>
                    
                    <!-- Status -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2" for="status">
                            Status <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <select name="status" id="status" required
                                    class="w-full px-4 py-3 pl-10 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#27124A]/20 focus:border-[#27124A] transition-all duration-300 appearance-none">
                                <option value="active" {{ old('status', $member->status) == 'active' ? 'selected' : '' }}>Aktif</option>
                                <option value="expired" {{ old('status', $member->status) == 'expired' ? 'selected' : '' }}>Expired</option>
                            </select>
                            <div class="absolute left-3 top-1/2 transform -translate-y-1/2">
                                <i class="fas fa-power-off text-gray-400 text-sm"></i>
                            </div>
                            <div class="absolute right-3 top-1/2 transform -translate-y-1/2">
                                <i class="fas fa-chevron-down text-gray-400 text-sm"></i>
                            </div>
                        </div>
                        <p class="mt-1 text-xs text-gray-500">
                            <i class="fas fa-info-circle mr-1"></i> Status akan otomatis menyesuaikan dengan tanggal expired
                        </p>
                        @error('status')
                            <div class="mt-2 text-sm text-red-600 bg-red-50 p-3 rounded-lg">
                                <i class="fas fa-exclamation-circle mr-2"></i>{{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
            </div>
            
            <!-- Action Buttons -->
            <div class="mt-10 pt-6 border-t border-gray-100">
                <div class="flex flex-col sm:flex-row justify-between items-center gap-4">
                    <div class="text-sm text-gray-500">
                        <i class="fas fa-exclamation-triangle text-yellow-500 mr-2"></i>
                        Pastikan perubahan data sudah sesuai dengan kebutuhan
                    </div>
                    <div class="flex flex-wrap gap-3">
                        <a href="{{ route('admin.members.show', $member->id) }}" 
                           class="px-5 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium rounded-xl transition-all duration-300 flex items-center border border-gray-200">
                            <i class="fas fa-times mr-2"></i> Batal
                        </a>
                        
                        <!-- Toggle Status Button -->
                        <form action="{{ route('admin.members.toggleStatus', $member->id) }}" method="POST" class="inline">
                            @csrf
                            @method('PUT')
                            <button type="submit" 
                                    class="px-5 py-2.5 {{ $member->is_active ? 'bg-red-500 hover:bg-red-600' : 'bg-green-500 hover:bg-green-600' }} text-white font-medium rounded-xl transition-all duration-300 flex items-center shadow-sm hover:shadow-md"
                                    onclick="return confirm('Yakin ingin {{ $member->is_active ? 'nonaktifkan' : 'aktifkan' }} member {{ $member->nama }}?')">
                                <i class="fas fa-{{ $member->is_active ? 'ban' : 'check-circle' }} mr-2"></i>
                                {{ $member->is_active ? 'Nonaktifkan' : 'Aktifkan' }}
                            </button>
                        </form>
                        
                        <button type="submit"
                                class="px-5 py-2.5 bg-[#27124A] hover:bg-[#3a1d6b] text-white font-medium rounded-xl transition-all duration-300 flex items-center shadow-sm hover:shadow-md">
                            <i class="fas fa-save mr-2"></i> Update Data
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
    const tglExpiredInput = document.getElementById('tgl_expired');
    const sisaHariDisplay = document.getElementById('sisaHariDisplay');
    
    function updateSisaHari() {
        if (tglExpiredInput.value) {
            // Parse tanggal expired (YYYY-MM-DD)
            const expiredParts = tglExpiredInput.value.split('-');
            const expiredDate = new Date(expiredParts[0], expiredParts[1] - 1, expiredParts[2]);
            
            // Dapatkan tanggal hari ini (tanpa waktu)
            const today = new Date();
            today.setHours(0, 0, 0, 0);
            
            // Reset waktu expired date ke 00:00:00
            expiredDate.setHours(0, 0, 0, 0);
            
            // Hitung selisih dalam milidetik
            const diffTime = expiredDate.getTime() - today.getTime();
            
            // Konversi ke hari (1 hari = 24 * 60 * 60 * 1000 milidetik)
            const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
            
            // Tampilkan berdasarkan selisih hari
            if (diffDays < 0) {
                sisaHariDisplay.textContent = 'Expired ' + Math.abs(diffDays) + ' hari yang lalu';
                sisaHariDisplay.className = 'font-bold text-red-600';
            } else if (diffDays === 0) {
                sisaHariDisplay.textContent = 'Expired hari ini';
                sisaHariDisplay.className = 'font-bold text-red-600';
            } else if (diffDays <= 7) {
                sisaHariDisplay.textContent = diffDays + ' hari lagi (segera expired)';
                sisaHariDisplay.className = 'font-bold text-yellow-600';
            } else {
                sisaHariDisplay.textContent = diffDays + ' hari lagi';
                sisaHariDisplay.className = 'font-bold text-green-600';
            }
        } else {
            sisaHariDisplay.textContent = '-';
            sisaHariDisplay.className = 'font-bold text-gray-600';
        }
    }
    
    // Update status otomatis berdasarkan tanggal expired
    function updateStatusBasedOnExpired() {
        const statusSelect = document.getElementById('status');
        
        if (tglExpiredInput.value && statusSelect) {
            const expiredParts = tglExpiredInput.value.split('-');
            const expiredDate = new Date(expiredParts[0], expiredParts[1] - 1, expiredParts[2]);
            
            const today = new Date();
            today.setHours(0, 0, 0, 0);
            expiredDate.setHours(0, 0, 0, 0);
            
            if (expiredDate < today) {
                // Jika tanggal expired sudah lewat, set status ke expired
                if (statusSelect.value !== 'expired') {
                    statusSelect.value = 'expired';
                    // Tampilkan notifikasi
                    const infoDiv = document.createElement('div');
                    infoDiv.className = 'mt-2 text-sm text-yellow-600 bg-yellow-50 p-2 rounded-lg';
                    infoDiv.innerHTML = '<i class="fas fa-info-circle mr-1"></i> Status otomatis diubah menjadi Expired karena tanggal expired sudah lewat.';
                    statusSelect.parentElement.parentElement.appendChild(infoDiv);
                    setTimeout(() => infoDiv.remove(), 3000);
                }
            }
        }
    }
    
    if (tglExpiredInput) {
        tglExpiredInput.addEventListener('change', function() {
            updateSisaHari();
            updateStatusBasedOnExpired();
        });
        
        updateSisaHari(); // Panggil saat halaman dimuat
    }
    
    // Update sisa hari saat paket dipilih
    const paketSelect = document.getElementById('id_paket');
    if (paketSelect) {
        paketSelect.addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            const durasi = selectedOption.getAttribute('data-durasi');
            
            if (durasi && confirm('Apakah Anda ingin mengupdate tanggal expired berdasarkan paket yang dipilih?\n\nPerhitungan: Tanggal hari ini + ' + durasi + ' hari')) {
                // Hitung tanggal expired baru berdasarkan durasi paket
                const today = new Date();
                const newExpired = new Date(today);
                newExpired.setDate(today.getDate() + parseInt(durasi));
                
                // Format ke YYYY-MM-DD untuk input date
                const year = newExpired.getFullYear();
                const month = String(newExpired.getMonth() + 1).padStart(2, '0');
                const day = String(newExpired.getDate()).padStart(2, '0');
                
                tglExpiredInput.value = `${year}-${month}-${day}`;
                updateSisaHari();
                updateStatusBasedOnExpired();
                
                // Tampilkan notifikasi
                const notification = document.createElement('div');
                notification.className = 'fixed top-4 right-4 bg-green-500 text-white px-4 py-2 rounded-lg shadow-lg z-50 animate-pulse';
                notification.innerHTML = '<i class="fas fa-check-circle mr-2"></i> Tanggal expired diperbarui menjadi ' + newExpired.toLocaleDateString('id-ID');
                document.body.appendChild(notification);
                setTimeout(() => notification.remove(), 3000);
            }
        });
    }
    
    // Preview foto sebelum upload
    const fotoInput = document.getElementById('foto_identitas');
    if (fotoInput) {
        fotoInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                // Validasi tipe file
                const allowedTypes = ['image/jpeg', 'image/png', 'image/jpg'];
                if (!allowedTypes.includes(file.type)) {
                    alert('Format file tidak didukung. Gunakan JPG, JPEG, atau PNG.');
                    this.value = '';
                    return;
                }
                
                // Validasi ukuran file (max 2MB)
                if (file.size > 2 * 1024 * 1024) {
                    alert('Ukuran file terlalu besar. Maksimal 2MB.');
                    this.value = '';
                    return;
                }
                
                // Preview
                const reader = new FileReader();
                reader.onload = function(e) {
                    // Cari atau buat elemen preview
                    let previewContainer = document.querySelector('.foto-preview-container');
                    if (!previewContainer) {
                        const parent = fotoInput.closest('.relative').parentElement;
                        previewContainer = document.createElement('div');
                        previewContainer.className = 'foto-preview-container mt-3';
                        parent.appendChild(previewContainer);
                    }
                    
                    previewContainer.innerHTML = `
                        <div class="bg-gray-50 p-3 rounded-lg border border-gray-200">
                            <label class="block text-xs font-medium text-gray-600 mb-2">Preview Foto Baru:</label>
                            <img src="${e.target.result}" alt="Preview" class="w-24 h-24 object-cover rounded-lg border border-gray-300">
                            <p class="text-xs text-gray-500 mt-2">File: ${file.name} (${(file.size / 1024).toFixed(2)} KB)</p>
                        </div>
                    `;
                };
                reader.readAsDataURL(file);
            }
        });
    }
});
</script>
@endpush