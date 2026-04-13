@extends('layouts.app')

@section('title', 'Edit Paket Membership')
@section('page-title', 'Edit Paket Membership')

@section('sidebar')
@include('admin.partials.sidebar')
@endsection

@section('content')
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden mb-6">
    <div class="px-6 py-5 bg-gradient-to-r from-[#27124A] to-[#3a1d6b]">
        <div class="flex items-center justify-between">
            <div class="flex items-center">
                <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center mr-4">
                    <i class="fas fa-edit text-white text-xl"></i>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-white">Edit Paket Membership</h3>
                    <p class="text-sm text-white/80">Perbarui informasi paket membership</p>
                </div>
            </div>
            <div class="bg-white/20 px-4 py-2 rounded-xl">
                <div class="text-xs text-white/70">ID Paket</div>
                <div class="font-mono font-bold text-white">{{ $package->id }}</div>
            </div>
        </div>
    </div>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden mb-8">
    <div class="p-6">
        <form action="{{ route('admin.packages.update', $package->id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <div class="space-y-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2" for="nama_paket">
                            Nama Paket <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <input type="text" name="nama_paket" id="nama_paket" required
                                   value="{{ old('nama_paket', $package->nama_paket) }}"
                                   class="w-full px-4 py-3 pl-11 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#27124A]/20 focus:border-[#27124A] transition-all duration-300">
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
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2" for="durasi_hari">
                            Durasi (hari) <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <input type="number" name="durasi_hari" id="durasi_hari" required min="1"
                                   value="{{ old('durasi_hari', $package->durasi_hari) }}"
                                   class="w-full px-4 py-3 pl-11 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#27124A]/20 focus:border-[#27124A] transition-all duration-300">
                            <div class="absolute left-3 top-1/2 transform -translate-y-1/2">
                                <i class="fas fa-calendar text-gray-400"></i>
                            </div>
                        </div>
                        @error('durasi_hari')
                            <div class="mt-2 text-sm text-red-600 bg-red-50 p-3 rounded-lg">
                                <i class="fas fa-exclamation-circle mr-2"></i>{{ $message }}
                            </div>
                        @enderror
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2" for="harga">
                            Harga (Rp) <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <input type="number" name="harga" id="harga" required min="0"
                                   value="{{ old('harga', $package->harga) }}"
                                   class="w-full px-4 py-3 pl-11 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#27124A]/20 focus:border-[#27124A] transition-all duration-300">
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
                    
                    <div class="flex items-center p-4 bg-gray-50 rounded-xl border border-gray-200">
                        <input type="checkbox" name="status" id="status" value="1" 
                               {{ old('status', $package->status) ? 'checked' : '' }}
                               class="h-5 w-5 text-[#27124A] focus:ring-[#27124A]/20 border-gray-300 rounded transition-all duration-300">
                        <label for="status" class="ml-3 block text-sm font-medium text-gray-700">
                            <i class="fas fa-toggle-on text-[#27124A] mr-2"></i>Paket Aktif
                        </label>
                    </div>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-3">
                        <i class="fas fa-eye text-[#27124A] mr-2"></i>Preview Paket
                    </label>
                    <div id="preview" class="border-2 border-dashed border-gray-200 rounded-2xl p-6 bg-gradient-to-br from-gray-50 to-white hover:border-[#27124A]/30 transition-all duration-300">
                        <div class="text-center">
                            <div class="inline-flex items-center justify-center w-20 h-20 bg-[#27124A]/10 rounded-2xl mb-4">
                                <i class="fas fa-gift text-[#27124A] text-3xl"></i>
                            </div>
                            
                            <h5 class="text-xl font-bold text-gray-800 mb-4" id="preview_nama">{{ $package->nama_paket }}</h5>
                            
                            <div class="grid grid-cols-2 gap-4 mb-4">
                                <div class="bg-white p-4 rounded-xl border border-gray-100">
                                    <div class="text-xs text-gray-500 mb-1">Durasi</div>
                                    <div class="text-lg font-bold text-[#27124A]" id="preview_durasi">
                                        {{ $package->durasi_hari }} hari ({{ $package->durasi_formatted }})
                                    </div>
                                </div>
                                <div class="bg-white p-4 rounded-xl border border-gray-100">
                                    <div class="text-xs text-gray-500 mb-1">Harga Total</div>
                                    <div class="text-lg font-bold text-green-600" id="preview_harga">
                                        {{ $package->harga_formatted }}
                                    </div>
                                </div>
                            </div>
                            
                            <div class="bg-[#27124A]/5 p-4 rounded-xl border border-[#27124A]/10">
                                <div class="text-sm text-gray-600 mb-1">Harga per Hari:</div>
                                <div class="text-xl font-bold text-[#27124A]" id="preview_harian">
                                    Rp {{ number_format($package->harga_per_hari, 0, ',', '.') }}/hari
                                </div>
                                <div class="text-xs text-gray-500 mt-2">*Harga per hari dihitung dari total harga / durasi</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="mt-10 pt-6 border-t border-gray-100">
                <div class="flex flex-col sm:flex-row justify-between items-center gap-4">
                    <div class="text-sm text-gray-500">
                        <i class="fas fa-info-circle text-[#27124A] mr-2"></i>
                        Perubahan hanya berlaku untuk member baru dan perpanjangan
                    </div>
                    <div class="flex space-x-3">
                        <a href="{{ route('admin.packages.index') }}" 
                           class="px-6 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium rounded-xl transition-all duration-300 flex items-center border border-gray-200">
                            <i class="fas fa-times mr-2"></i> Batal
                        </a>
                        <button type="submit"
                                class="px-6 py-2.5 bg-[#27124A] hover:bg-[#3a1d6b] text-white font-medium rounded-xl transition-all duration-300 flex items-center shadow-sm hover:shadow-md">
                            <i class="fas fa-save mr-2"></i> Update Paket
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

@if($package->members()->count() > 0)
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="px-6 py-5 bg-gradient-to-r from-[#27124A] to-[#3a1d6b]">
        <div class="flex items-center justify-between">
            <div class="flex items-center">
                <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center mr-4">
                    <i class="fas fa-users text-white"></i>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-white">Member dengan Paket "{{ $package->nama_paket }}"</h3>
                    <p class="text-sm text-white/80">{{ $package->members()->count() }} member terdaftar</p>
                </div>
            </div>
            <span class="px-4 py-2 bg-white/20 text-white rounded-xl font-semibold text-sm">
                {{ $package->members()->count() }} Member
            </span>
        </div>
    </div>
    
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-100">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-16">No</th>
                    <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kode Member</th>
                    <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama</th>
                    <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Daftar</th>
                    <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Expired</th>
                    <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-100">
                @foreach($package->members as $member)
                <tr class="hover:bg-gray-50 transition-colors duration-150">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center justify-center w-8 h-8 bg-gray-100 rounded-lg text-gray-600 font-medium text-sm">
                            {{ $loop->iteration }}
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="font-mono font-medium text-[#27124A]">{{ $member->kode_member }}</span>
                    </td>
                    <td class="px-6 py-4">
                        <div class="font-medium text-gray-800">{{ $member->nama }}</div>
                        @if($member->telepon)
                        <div class="text-xs text-gray-500">{{ $member->telepon }}</div>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-700">{{ $member->tgl_daftar->format('d/m/Y') }}</div>
                        <div class="text-xs text-gray-400">{{ $member->tgl_daftar->format('H:i') }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="{{ $member->tgl_expired < now() ? 'text-red-600' : 'text-green-600' }} text-sm font-medium">
                            {{ $member->tgl_expired->format('d/m/Y') }}
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        @if($member->status == 'active' && $member->tgl_expired >= now())
                            <span class="px-3 py-1.5 bg-green-50 text-green-700 rounded-lg text-sm font-medium border border-green-200">
                                <i class="fas fa-check-circle mr-1 text-xs"></i> Aktif
                            </span>
                        @else
                            <span class="px-3 py-1.5 bg-red-50 text-red-700 rounded-lg text-sm font-medium border border-red-200">
                                <i class="fas fa-times-circle mr-1 text-xs"></i> Expired
                            </span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endif
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const namaInput = document.getElementById('nama_paket');
    const durasiInput = document.getElementById('durasi_hari');
    const hargaInput = document.getElementById('harga');
    
    function updatePreview() {
        const nama = namaInput.value || '{{ $package->nama_paket }}';
        const durasi = durasiInput.value ? parseInt(durasiInput.value) : {{ $package->durasi_hari }};
        const harga = hargaInput.value ? parseInt(hargaInput.value) : {{ $package->harga }};
        
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
        }
        
        if (harga > 0) {
            document.getElementById('preview_harga').textContent = formatRupiah(harga);
            
            if (durasi > 0) {
                const hargaPerHari = Math.round(harga / durasi);
                document.getElementById('preview_harian').textContent = formatRupiah(hargaPerHari) + '/hari';
            }
        }
    }
    
    function formatRupiah(angka) {
        return 'Rp ' + angka.toLocaleString('id-ID');
    }
    
    namaInput.addEventListener('input', updatePreview);
    durasiInput.addEventListener('input', updatePreview);
    hargaInput.addEventListener('input', updatePreview);
});
</script>
@endpush