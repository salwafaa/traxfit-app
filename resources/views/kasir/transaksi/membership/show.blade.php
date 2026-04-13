@extends('layouts.app')

@section('title', 'Detail Transaksi Membership')
@section('page-title', 'Detail Transaksi Membership')

@section('sidebar')
@include('kasir.partials.sidebar')
@endsection

@section('content')
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="p-6 border-b border-gray-100">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div class="flex items-center space-x-4">
                <a href="{{ route('kasir.transaksi.index') }}" 
                   class="flex items-center px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-xl transition-all duration-300">
                    <i class="fas fa-arrow-left mr-2"></i>
                    <span>Kembali</span>
                </a>
                <div>
                    <h3 class="text-lg font-semibold text-gray-800">Transaksi #{{ $transaction->nomor_unik }}</h3>
                    <p class="text-sm text-gray-500 mt-1">{{ $transaction->created_at->format('d F Y H:i:s') }}</p>
                </div>
            </div>
            <div class="flex space-x-3">
                <a href="{{ route('kasir.transaksi.membership.struk', $transaction->id) }}" 
                   class="bg-green-600 hover:bg-green-700 text-white font-medium py-2.5 px-5 rounded-xl transition-all duration-300 flex items-center shadow-sm hover:shadow-md"
                   target="_blank">
                    <i class="fas fa-print mr-2"></i> Struk
                </a>
                <a href="{{ route('kasir.transaksi.membership.kartu', $transaction->id) }}" 
                   class="bg-[#27124A] hover:bg-[#3a1d6b] text-white font-medium py-2.5 px-5 rounded-xl transition-all duration-300 flex items-center shadow-sm hover:shadow-md"
                   target="_blank">
                    <i class="fas fa-id-card mr-2"></i> Kartu Member
                </a>
            </div>
        </div>
    </div>
    
    <div class="p-6">
        @php
            $dataTambahan = $transaction->data_tambahan;
            if (is_string($dataTambahan)) {
                $dataTambahan = json_decode($dataTambahan, true) ?? [];
            } elseif (is_object($dataTambahan)) {
                $dataTambahan = json_decode(json_encode($dataTambahan), true) ?? [];
            }
            $paket = $dataTambahan['paket_membership'] ?? [];
        @endphp

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="lg:col-span-2">
                <div class="mb-6">
                    <h4 class="font-semibold text-gray-800 mb-3">👤 Data Member</h4>
                    <div class="bg-purple-50 rounded-xl p-5 border border-purple-200">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs text-gray-600 mb-1">Kode Member</label>
                                <p class="font-mono font-semibold text-[#27124A]">{{ $transaction->member->kode_member }}</p>
                            </div>
                            <div>
                                <label class="block text-xs text-gray-600 mb-1">Nama Lengkap</label>
                                <p class="font-medium text-gray-800">{{ $transaction->member->nama }}</p>
                            </div>
                            <div>
                                <label class="block text-xs text-gray-600 mb-1">Telepon</label>
                                <p class="text-gray-700">{{ $transaction->member->telepon }}</p>
                            </div>
                            <div>
                                <label class="block text-xs text-gray-600 mb-1">Tanggal Lahir</label>
                                <p class="text-gray-700">{{ \Carbon\Carbon::parse($transaction->member->tgl_lahir)->format('d/m/Y') }}</p>
                            </div>
                            <div>
                                <label class="block text-xs text-gray-600 mb-1">Jenis Identitas</label>
                                <p class="text-gray-700">{{ $transaction->member->jenis_identitas }}</p>
                            </div>
                            <div>
                                <label class="block text-xs text-gray-600 mb-1">No. Identitas</label>
                                <p class="text-gray-700">{{ $transaction->member->no_identitas }}</p>
                            </div>
                            <div class="md:col-span-2">
                                <label class="block text-xs text-gray-600 mb-1">Alamat</label>
                                <p class="text-gray-700">{{ $transaction->member->alamat }}</p>
                            </div>
                        </div>
                        
                        @if($transaction->member->foto_identitas)
                        <div class="mt-4">
                            <label class="block text-xs text-gray-600 mb-2">Foto Identitas</label>
                            <img src="{{ asset('storage/' . $transaction->member->foto_identitas) }}" 
                                 alt="Foto Identitas" 
                                 class="w-32 h-32 object-cover rounded-lg border-2 border-white shadow-sm">
                        </div>
                        @endif
                    </div>
                </div>

                <div class="mb-6">
                    <h4 class="font-semibold text-gray-800 mb-3">🎫 Detail Membership</h4>
                    <div class="bg-green-50 rounded-xl p-5 border border-green-200">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs text-gray-600 mb-1">Paket Membership</label>
                                <p class="font-medium text-gray-800">{{ $paket['nama'] ?? '-' }}</p>
                            </div>
                            <div>
                                <label class="block text-xs text-gray-600 mb-1">Durasi</label>
                                <p class="text-gray-700">{{ $paket['durasi_hari'] ?? 0 }} Hari</p>
                            </div>
                            <div>
                                <label class="block text-xs text-gray-600 mb-1">Harga Paket</label>
                                <p class="font-bold text-[#27124A]">Rp {{ number_format($paket['harga'] ?? 0, 0, ',', '.') }}</p>
                            </div>
                            <div>
                                <label class="block text-xs text-gray-600 mb-1">Status</label>
                                <span class="px-3 py-1.5 bg-green-100 text-green-700 rounded-lg text-xs font-medium">
                                    {{ $transaction->member->status == 'active' ? 'Aktif' : 'Expired' }}
                                </span>
                            </div>
                            <div>
                                <label class="block text-xs text-gray-600 mb-1">Tanggal Mulai</label>
                                <p class="text-gray-700">{{ isset($dataTambahan['tgl_mulai']) ? \Carbon\Carbon::parse($dataTambahan['tgl_mulai'])->format('d/m/Y H:i') : '-' }}</p>
                            </div>
                            <div>
                                <label class="block text-xs text-gray-600 mb-1">Tanggal Selesai</label>
                                <p class="text-gray-700">{{ isset($dataTambahan['tgl_selesai']) ? \Carbon\Carbon::parse($dataTambahan['tgl_selesai'])->format('d/m/Y H:i') : '-' }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                @if($transaction->details->count() > 0)
                <div class="mb-6">
                    <h4 class="font-semibold text-gray-800 mb-3">📦 Produk Tambahan</h4>
                    <div class="overflow-x-auto border border-gray-100 rounded-xl">
                        <table class="min-w-full divide-y divide-gray-100">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">No</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Produk</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Harga</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Qty</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-100">
                                @foreach($transaction->details as $detail)
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="px-4 py-3 whitespace-nowrap">
                                        <div class="flex items-center justify-center w-7 h-7 bg-gray-100 rounded-lg text-gray-600 font-medium text-xs">
                                            {{ $loop->iteration }}
                                        </div>
                                    </td>
                                    <td class="px-4 py-3">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 w-8 h-8 bg-purple-50 rounded-lg flex items-center justify-center mr-2">
                                                <i class="fas fa-box text-[#27124A] text-xs"></i>
                                            </div>
                                            <div>
                                                <div class="font-medium text-gray-800">{{ $detail->product->nama_produk }}</div>
                                                <div class="text-xs text-gray-400">{{ $detail->product->category->nama_kategori ?? '-' }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap text-gray-700">
                                        Rp {{ number_format($detail->harga_satuan, 0, ',', '.') }}
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap">
                                        <span class="px-2 py-1 bg-gray-100 rounded-lg text-sm font-medium">
                                            {{ $detail->qty }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap font-medium text-[#27124A]">
                                        Rp {{ number_format($detail->subtotal, 0, ',', '.') }}
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                @endif
            </div>
            
            <div>
                <div class="bg-gray-50 border border-gray-100 rounded-xl p-6 sticky top-6">
                    <h4 class="font-semibold text-gray-800 mb-4">Ringkasan Pembayaran</h4>
                    
                    <div class="space-y-3 mb-6">
                        @php
                            $subtotalProduk = $transaction->details->sum('subtotal');
                        @endphp

                        <div class="flex justify-between">
                            <span class="text-gray-600">Harga Paket</span>
                            <span class="font-medium text-gray-800">Rp {{ number_format($paket['harga'] ?? 0, 0, ',', '.') }}</span>
                        </div>

                        @if($subtotalProduk > 0)
                        <div class="flex justify-between">
                            <span class="text-gray-600">Subtotal Produk</span>
                            <span class="font-medium text-gray-800">Rp {{ number_format($subtotalProduk, 0, ',', '.') }}</span>
                        </div>
                        @endif

                        <div class="flex justify-between pt-3 border-t border-gray-200">
                            <span class="text-gray-800 font-semibold">Total</span>
                            <span class="font-bold text-xl text-[#27124A]">Rp {{ number_format($transaction->total_harga, 0, ',', '.') }}</span>
                        </div>
                    </div>
                    
                    <div class="space-y-4">
                        <div class="flex justify-between items-center p-3 bg-white rounded-lg border border-gray-200">
                            <span class="text-gray-600">Uang Bayar</span>
                            <span class="font-medium text-green-600">Rp {{ number_format($transaction->uang_bayar, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between items-center p-3 bg-white rounded-lg border border-gray-200">
                            <span class="text-gray-600">Uang Kembali</span>
                            <span class="font-medium text-blue-600">Rp {{ number_format($transaction->uang_kembali, 0, ',', '.') }}</span>
                        </div>
                        
                        @if($transaction->catatan)
                        <div class="mt-4 p-3 bg-yellow-50 rounded-lg border border-yellow-200">
                            <p class="text-xs text-gray-600 mb-1">📝 Catatan</p>
                            <p class="text-sm text-gray-800">{{ $transaction->catatan }}</p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection