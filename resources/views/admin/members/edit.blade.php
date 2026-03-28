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
        <form action="{{ route('admin.members.update', $member->id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <!-- Section 1: Informasi Member -->
            <div class="mb-8">
                <div class="flex items-center mb-5">
                    <div class="w-1 h-6 bg-[#27124A] rounded-full mr-3"></div>
                    <h4 class="text-base font-semibold text-gray-800">
                        <i class="fas fa-user-edit text-[#27124A] mr-2"></i>Informasi Pribadi
                    </h4>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <!-- Nama -->
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
                    
                    <!-- Telepon -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2" for="telepon">
                            Nomor Telepon
                        </label>
                        <div class="relative">
                            <input type="text" name="telepon" id="telepon"
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
                    
                    <!-- Alamat -->
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
            
            <!-- Section 2: Membership -->
            <div class="mb-8">
                <div class="flex items-center mb-5">
                    <div class="w-1 h-6 bg-[#27124A] rounded-full mr-3"></div>
                    <h4 class="text-base font-semibold text-gray-800">
                        <i class="fas fa-id-card-alt text-[#27124A] mr-2"></i>Informasi Membership
                    </h4>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <!-- Jenis Member -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2" for="jenis_member">
                            Jenis Member
                        </label>
                        <div class="relative">
                            <select name="jenis_member" id="jenis_member"
                                    class="w-full px-4 py-3 pl-10 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#27124A]/20 focus:border-[#27124A] transition-all duration-300 appearance-none">
                                <option value="">Pilih Jenis Member</option>
                                <option value="Regular" {{ old('jenis_member', $member->jenis_member) == 'Regular' ? 'selected' : '' }}>Regular</option>
                                <option value="Premium" {{ old('jenis_member', $member->jenis_member) == 'Premium' ? 'selected' : '' }}>Premium</option>
                                <option value="VIP" {{ old('jenis_member', $member->jenis_member) == 'VIP' ? 'selected' : '' }}>VIP</option>
                                <option value="Student" {{ old('jenis_member', $member->jenis_member) == 'Student' ? 'selected' : '' }}>Student</option>
                                <option value="Corporate" {{ old('jenis_member', $member->jenis_member) == 'Corporate' ? 'selected' : '' }}>Corporate</option>
                            </select>
                            <div class="absolute left-3 top-1/2 transform -translate-y-1/2">
                                <i class="fas fa-crown text-gray-400 text-sm"></i>
                            </div>
                            <div class="absolute right-3 top-1/2 transform -translate-y-1/2">
                                <i class="fas fa-chevron-down text-gray-400 text-sm"></i>
                            </div>
                        </div>
                        @error('jenis_member')
                            <div class="mt-2 text-sm text-red-600 bg-red-50 p-3 rounded-lg">
                                <i class="fas fa-exclamation-circle mr-2"></i>{{ $message }}
                            </div>
                        @enderror
                    </div>
                    
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
                        <div class="mt-2 text-sm text-gray-500">
                            <i class="fas fa-info-circle mr-1"></i> Sisa hari: <span id="sisaHariDisplay" class="font-bold"></span>
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
            
            <!-- Info Saat Ini -->
            <div class="mb-8 bg-gray-50 border border-gray-200 rounded-xl p-5">
                <h4 class="text-base font-semibold text-gray-800 mb-4 flex items-center">
                    <i class="fas fa-info-circle text-[#27124A] mr-2"></i>Informasi Saat Ini
                </h4>
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div class="bg-white p-4 rounded-xl border border-gray-200">
                        <div class="flex items-center">
                            <div class="w-10 h-10 bg-blue-50 rounded-lg flex items-center justify-center mr-3">
                                <i class="fas fa-calendar-plus text-blue-600"></i>
                            </div>
                            <div>
                                <div class="text-xs text-gray-500">Tanggal Daftar</div>
                                <div class="font-medium text-gray-800">{{ $member->tgl_daftar_formatted }}</div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="bg-white p-4 rounded-xl border border-gray-200">
                        <div class="flex items-center">
                            <div class="w-10 h-10 bg-green-50 rounded-lg flex items-center justify-center mr-3">
                                <i class="fas fa-box-open text-green-600"></i>
                            </div>
                            <div>
                                <div class="text-xs text-gray-500">Paket Saat Ini</div>
                                <div class="font-medium text-gray-800">{{ $member->package->nama_paket ?? '-' }}</div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="bg-white p-4 rounded-xl border border-gray-200">
                        <div class="flex items-center">
                            <div class="w-10 h-10 bg-purple-50 rounded-lg flex items-center justify-center mr-3">
                                <i class="fas fa-clock text-purple-600"></i>
                            </div>
                            <div>
                                <div class="text-xs text-gray-500">Sisa Hari</div>
                                <div class="font-medium {{ $member->sisa_hari_class }}">
                                    {{ $member->sisa_hari_text }}
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="bg-white p-4 rounded-xl border border-gray-200">
                        <div class="flex items-center">
                            <div class="w-10 h-10 {{ $member->is_active ? 'bg-green-50' : 'bg-red-50' }} rounded-lg flex items-center justify-center mr-3">
                                <i class="fas {{ $member->is_active ? 'fa-check-circle text-green-600' : 'fa-times-circle text-red-600' }}"></i>
                            </div>
                            <div>
                                <div class="text-xs text-gray-500">Status</div>
                                <div class="font-medium {{ $member->is_active ? 'text-green-700' : 'text-red-700' }}">
                                    {{ $member->is_active ? 'Aktif' : ($member->status == 'expired' ? 'Expired' : 'Tidak Aktif') }}
                                </div>
                            </div>
                        </div>
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
                        <a href="{{ route('admin.members.index') }}" 
                           class="px-5 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium rounded-xl transition-all duration-300 flex items-center border border-gray-200">
                            <i class="fas fa-times mr-2"></i> Batal
                        </a>
                        
                        <!-- Toggle Status Button -->
                        <form action="{{ route('admin.members.toggleStatus', $member->id) }}" method="POST" class="inline">
                            @csrf
                            @method('PUT')
                            <button type="submit" 
                                    class="px-5 py-2.5 {{ $member->status == 'active' ? 'bg-red-500 hover:bg-red-600' : 'bg-green-500 hover:bg-green-600' }} text-white font-medium rounded-xl transition-all duration-300 flex items-center shadow-sm hover:shadow-md"
                                    onclick="return confirm('Yakin ingin {{ $member->status == 'active' ? 'nonaktifkan' : 'aktifkan' }} member {{ $member->nama }}?')">
                                <i class="fas fa-{{ $member->status == 'active' ? 'ban' : 'check-circle' }} mr-2"></i>
                                {{ $member->status == 'active' ? 'Nonaktifkan' : 'Aktifkan' }}
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
                sisaHariDisplay.textContent = diffDays + ' hari lagi (akan expired)';
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
                statusSelect.value = 'expired';
            } else {
                // Jika tanggal expired masih berlaku, biarkan user memilih
                // Tapi kasih informasi
            }
        }
    }
    
    tglExpiredInput.addEventListener('change', function() {
        updateSisaHari();
        updateStatusBasedOnExpired();
    });
    
    updateSisaHari(); // Panggil saat halaman dimuat
    
    // Update sisa hari saat paket dipilih
    const paketSelect = document.getElementById('id_paket');
    if (paketSelect) {
        paketSelect.addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            const durasi = selectedOption.getAttribute('data-durasi');
            
            if (durasi && confirm('Apakah Anda ingin mengupdate tanggal expired berdasarkan paket yang dipilih?')) {
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
            }
        });
    }
});
</script>
@endpush