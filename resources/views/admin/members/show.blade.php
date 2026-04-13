@extends('layouts.app')

@section('title', 'Detail Member - ' . ($member->nama ?? 'Member'))
@section('page-title', 'Detail Member')

@section('sidebar')
@include('admin.partials.sidebar')
@endsection

@section('content')
<div class="bg-white rounded-xl md:rounded-2xl shadow-sm border border-gray-100 overflow-hidden w-full max-w-full">
    <div class="p-3 md:p-4 lg:p-5 border-b border-gray-100">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3">
            <div class="flex items-center gap-2 md:gap-3 min-w-0 flex-1">
                <a href="{{ route('admin.members.index') }}" 
                   class="flex items-center px-2 md:px-3 py-1.5 md:py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg md:rounded-xl transition-all duration-300 flex-shrink-0">
                    <i class="fas fa-arrow-left mr-1 text-xs"></i>
                    <span class="text-xs md:text-sm">Kembali</span>
                </a>
                <div class="min-w-0 flex-1">
                    <div class="flex items-center gap-2 flex-wrap">
                        <h3 class="text-sm md:text-base lg:text-lg font-semibold text-gray-800 truncate">{{ $member->nama }}</h3>
                        <span class="px-2 py-0.5 bg-gray-100 text-gray-600 rounded-lg text-xs font-mono">{{ $member->kode_member }}</span>
                    </div>
                    <p class="text-xs md:text-sm text-gray-500 mt-0.5">Bergabung: {{ $member->tgl_daftar_formatted }}</p>
                </div>
            </div>
            <div class="flex gap-2 flex-shrink-0">
                <a href="{{ route('admin.members.edit', $member->id) }}" 
                   class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-1.5 md:py-2 px-3 md:px-4 rounded-lg md:rounded-xl transition-all duration-300 flex items-center shadow-sm hover:shadow-md text-xs md:text-sm whitespace-nowrap">
                    <i class="fas fa-edit mr-1 text-xs"></i>
                    <span>Edit Member</span>
                </a>
            </div>
        </div>
    </div>
    
    <div class="p-3 md:p-4 lg:p-5">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-3 md:gap-4 lg:gap-5">
            <div class="lg:col-span-2 space-y-3 md:space-y-4 min-w-0">
                <div class="min-w-0">
                    <h4 class="text-sm md:text-base font-semibold text-gray-800 mb-2">Profil Member</h4>
                    <div class="bg-gray-50 rounded-lg md:rounded-xl p-3 md:p-4 border border-gray-100">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 md:gap-3">
                            <div class="min-w-0">
                                <label class="block text-xs text-gray-500 mb-1">Nama Lengkap</label>
                                <div class="flex items-center">
                                    <div class="w-6 h-6 md:w-7 md:h-7 bg-purple-50 rounded-lg flex items-center justify-center mr-1.5 flex-shrink-0">
                                        <i class="fas fa-user text-[#27124A] text-xs"></i>
                                    </div>
                                    <p class="font-medium text-gray-800 text-xs md:text-sm truncate">{{ $member->nama }}</p>
                                </div>
                            </div>
                            <div class="min-w-0">
                                <label class="block text-xs text-gray-500 mb-1">Kode Member</label>
                                <div class="flex items-center">
                                    <div class="w-6 h-6 md:w-7 md:h-7 bg-purple-50 rounded-lg flex items-center justify-center mr-1.5 flex-shrink-0">
                                        <i class="fas fa-qrcode text-[#27124A] text-xs"></i>
                                    </div>
                                    <p class="font-mono text-xs md:text-sm text-gray-800">{{ $member->kode_member }}</p>
                                </div>
                            </div>
                            <div class="min-w-0">
                                <label class="block text-xs text-gray-500 mb-1">Nomor Telepon</label>
                                <div class="flex items-center">
                                    <div class="w-6 h-6 md:w-7 md:h-7 bg-purple-50 rounded-lg flex items-center justify-center mr-1.5 flex-shrink-0">
                                        <i class="fas fa-phone text-[#27124A] text-xs"></i>
                                    </div>
                                    <p class="font-medium text-gray-800 text-xs md:text-sm">{{ $member->telepon ?? '-' }}</p>
                                </div>
                            </div>
                            <div class="sm:col-span-2">
                                <label class="block text-xs text-gray-500 mb-1">Alamat</label>
                                <div class="bg-white p-2 md:p-3 rounded-lg border border-gray-200">
                                    <p class="text-xs md:text-sm text-gray-700 break-words">{{ $member->alamat ?? '-' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="min-w-0">
                    <h4 class="text-sm md:text-base font-semibold text-gray-800 mb-2">🎫 Detail Membership</h4>
                    <div class="bg-purple-50 rounded-lg md:rounded-xl p-3 md:p-4 border border-purple-200">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 md:gap-3">
                            <div class="sm:col-span-2">
                                <label class="block text-xs text-gray-600 mb-1">Paket Membership</label>
                                <p class="font-medium text-gray-800 text-xs md:text-sm break-words">
                                    {{ $member->package->nama_paket ?? '-' }}
                                </p>
                            </div>
                            <div class="min-w-0">
                                <label class="block text-xs text-gray-600 mb-1">Harga Paket</label>
                                <p class="font-medium text-gray-800 text-xs md:text-sm">
                                    Rp {{ number_format($member->package->harga ?? 0, 0, ',', '.') }}
                                </p>
                            </div>
                            <div class="min-w-0">
                                <label class="block text-xs text-gray-600 mb-1">Durasi</label>
                                <p class="font-medium text-gray-800 text-xs md:text-sm">
                                    {{ $member->package->durasi_hari ?? '-' }} Hari
                                </p>
                            </div>
                            <div class="min-w-0">
                                <label class="block text-xs text-gray-600 mb-1">Tanggal Daftar</label>
                                <p class="font-medium text-gray-800 text-xs md:text-sm break-words">
                                    {{ $member->tgl_daftar_formatted }}
                                </p>
                            </div>
                            <div class="min-w-0">
                                <label class="block text-xs text-gray-600 mb-1">Tanggal Expired</label>
                                <p class="font-medium {{ $member->is_active ? 'text-green-600' : 'text-red-600' }} text-xs md:text-sm break-words">
                                    {{ $member->tgl_expired_formatted }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="min-w-0">
                    <h4 class="text-sm md:text-base font-semibold text-gray-800 mb-2">📋 Riwayat Transaksi</h4>
                    <div class="overflow-x-auto border border-gray-100 rounded-lg md:rounded-xl w-full">
                        <div class="inline-block min-w-full align-middle">
                            <table class="min-w-full divide-y divide-gray-100 table-auto">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-2 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
                                        <th class="px-2 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                                        <th class="px-2 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                                        <th class="px-2 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                        <th class="px-2 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-100">
                                    @forelse($member->transactions as $transaction)
                                    <tr class="hover:bg-gray-50 transition-colors">
                                        <td class="px-2 py-2 whitespace-nowrap">
                                            <div class="flex items-center justify-center w-5 h-5 md:w-6 md:h-6 bg-gray-100 rounded-lg text-gray-600 font-medium text-xs">
                                                {{ $loop->iteration }}
                                            </div>
                                        </td>
                                        <td class="px-2 py-2 whitespace-nowrap">
                                            <div class="text-xs text-gray-700">{{ $transaction->created_at->format('d/m/Y H:i') }}</div>
                                            <div class="text-xs text-gray-400">{{ $transaction->nomor_unik }}</div>
                                        </td>
                                        <td class="px-2 py-2 whitespace-nowrap font-medium text-[#27124A] text-xs">
                                            Rp {{ number_format($transaction->total_harga, 0, ',', '.') }}
                                        </td>
                                        <td class="px-2 py-2 whitespace-nowrap">
                                            <span class="px-2 py-1 bg-green-50 text-green-700 rounded-lg text-xs font-medium inline-flex items-center">
                                                <i class="fas fa-check-circle mr-1 text-xs"></i>
                                                Selesai
                                            </span>
                                        </td>
                                        <td class="px-2 py-2 whitespace-nowrap">
                                            <a href="{{ route('admin.transaksi.show', $transaction->id) }}" 
                                               class="text-blue-600 hover:text-blue-800 text-xs flex items-center">
                                                <i class="fas fa-eye mr-1"></i>
                                                Detail
                                            </a>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="5" class="px-2 py-8 text-center">
                                            <div class="inline-flex items-center justify-center w-12 h-12 bg-gray-100 rounded-full mb-2">
                                                <i class="fas fa-receipt text-gray-400 text-lg"></i>
                                            </div>
                                            <p class="text-xs text-gray-500">Belum ada riwayat transaksi</p>
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="lg:col-span-1 min-w-0">
                <div class="bg-gray-50 border border-gray-100 rounded-lg md:rounded-xl p-3 md:p-4 lg:p-5 sticky top-4">
                    <h4 class="text-sm md:text-base font-semibold text-gray-800 mb-3">Status Member</h4>
                    
                    <div class="space-y-3 mb-4">
                        <div class="p-3 bg-white rounded-lg border border-gray-200">
                            <div class="flex justify-between items-center mb-2">
                                <span class="text-xs text-gray-500">Status Saat Ini</span>
                                @if($member->is_active)
                                <span class="px-2 py-1 bg-green-100 text-green-700 rounded-lg text-xs font-medium">
                                    <i class="fas fa-check-circle mr-1"></i> Aktif
                                </span>
                                @else
                                <span class="px-2 py-1 bg-red-100 text-red-700 rounded-lg text-xs font-medium">
                                    <i class="fas fa-times-circle mr-1"></i> {{ $member->status == 'expired' ? 'Expired' : 'Tidak Aktif' }}
                                </span>
                                @endif
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-xs text-gray-500">Sisa Hari</span>
                                <span class="font-medium {{ $member->sisa_hari_class }} text-sm">
                                    {{ $member->sisa_hari_text }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="space-y-2">
                        <div class="flex justify-between items-center p-2 bg-white rounded-lg border border-gray-200 text-xs">
                            <span class="text-gray-600">Total Transaksi</span>
                            <span class="font-medium text-gray-800">{{ $member->transactions->count() }} kali</span>
                        </div>
                        <div class="flex justify-between items-center p-2 bg-white rounded-lg border border-gray-200 text-xs">
                            <span class="text-gray-600">Total Pembelian</span>
                            <span class="font-medium text-[#27124A]">Rp {{ number_format($member->transactions->sum('total_harga'), 0, ',', '.') }}</span>
                        </div>
                    </div>

                    <div class="mt-4 pt-3 border-t border-gray-200">
                        <div class="flex gap-2">
                            <form action="{{ route('admin.members.toggleStatus', $member->id) }}" method="POST" class="flex-1">
                                @csrf
                                @method('PUT')
                                <button type="submit" 
                                        class="w-full px-3 py-2 {{ $member->is_active ? 'bg-red-500 hover:bg-red-600' : 'bg-green-500 hover:bg-green-600' }} text-white rounded-lg text-xs font-medium transition-all duration-300"
                                        onclick="return confirm('Yakin ingin {{ $member->is_active ? 'nonaktifkan' : 'aktifkan' }} member {{ $member->nama }}?')">
                                    <i class="fas fa-{{ $member->is_active ? 'ban' : 'check-circle' }} mr-1"></i>
                                    {{ $member->is_active ? 'Nonaktifkan Member' : 'Aktifkan Member' }}
                                </button>
                            </form>
                            
                            <form action="{{ route('admin.members.destroy', $member->id) }}" method="POST" class="flex-1">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        class="w-full px-3 py-2 bg-gray-500 hover:bg-gray-600 text-white rounded-lg text-xs font-medium transition-all duration-300"
                                        onclick="return confirm('Yakin ingin menghapus member {{ $member->nama }}? Data yang dihapus tidak dapat dikembalikan.')">
                                    <i class="fas fa-trash mr-1"></i>
                                    Hapus Member
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection