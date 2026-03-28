@extends('layouts.app')

@section('title', 'Detail Transaksi')
@section('page-title', 'Detail Transaksi')

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
                <a href="{{ route('kasir.transaksi.struk', $transaction->id) }}" 
                   class="bg-green-600 hover:bg-green-700 text-white font-medium py-2.5 px-5 rounded-xl transition-all duration-300 flex items-center shadow-sm hover:shadow-md"
                   target="_blank">
                    <i class="fas fa-print mr-2"></i> Cetak Ulang
                </a>
                
                @if(in_array($transaction->jenis_transaksi, ['membership', 'produk_membership']))
                <a href="{{ route('kasir.transaksi.membership.kartu', $transaction->id) }}" 
                   class="bg-purple-600 hover:bg-purple-700 text-white font-medium py-2.5 px-5 rounded-xl transition-all duration-300 flex items-center shadow-sm hover:shadow-md"
                   target="_blank">
                    <i class="fas fa-id-card mr-2"></i> Kartu Member
                </a>
                @endif
            </div>
        </div>
    </div>
    
    <div class="p-6">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Informasi Transaksi -->
            <div class="lg:col-span-2">
                <!-- Info Transaksi -->
                <div class="mb-6">
                    <h4 class="font-semibold text-gray-800 mb-3">Informasi Transaksi</h4>
                    <div class="bg-gray-50 rounded-xl p-5 border border-gray-100">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs text-gray-500 mb-1">Kasir</label>
                                <div class="flex items-center">
                                    <div class="w-8 h-8 bg-purple-50 rounded-lg flex items-center justify-center mr-2">
                                        <i class="fas fa-user text-[#27124A] text-sm"></i>
                                    </div>
                                    <p class="font-medium text-gray-800">{{ $transaction->user->nama }}</p>
                                </div>
                            </div>
                            <div>
                                <label class="block text-xs text-gray-500 mb-1">Status Transaksi</label>
                                <span class="px-3 py-1.5 bg-green-50 text-green-700 rounded-lg text-xs font-medium inline-flex items-center">
                                    <i class="fas fa-check-circle mr-1"></i>
                                    {{ ucfirst($transaction->status_transaksi) }}
                                </span>
                            </div>
                            <div>
                                <label class="block text-xs text-gray-500 mb-1">Jenis Transaksi</label>
                                @php
                                    $jenisLabels = [
                                        'produk' => ['Produk Only', 'blue'],
                                        'visit' => ['Visit Only', 'green'],
                                        'membership' => ['Membership Only', 'purple'],
                                        'produk_visit' => ['Produk + Visit', 'orange'],
                                        'produk_membership' => ['Produk + Membership', 'red']
                                    ];
                                    $label = $jenisLabels[$transaction->jenis_transaksi] ?? ['Unknown', 'gray'];
                                @endphp
                                <span class="px-3 py-1.5 bg-{{ $label[1] }}-50 text-{{ $label[1] }}-700 rounded-lg text-xs font-medium inline-flex items-center">
                                    {{ $label[0] }}
                                </span>
                            </div>
                            <div>
                                <label class="block text-xs text-gray-500 mb-1">Metode Pembayaran</label>
                                <span class="px-3 py-1.5 rounded-lg text-xs font-medium inline-flex items-center bg-green-50 text-green-700">
                                    <i class="fas fa-money-bill-wave mr-1"></i>
                                    Cash
                                </span>
                            </div>
                            @if($transaction->catatan)
                            <div class="md:col-span-2">
                                <label class="block text-xs text-gray-500 mb-1">Catatan</label>
                                <div class="bg-white p-3 rounded-lg border border-gray-200">
                                    <p class="text-sm text-gray-700">{{ $transaction->catatan }}</p>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Detail Visit (dari data_tambahan) -->
                @if($transaction->isVisitOnly() || $transaction->isProdukDanVisit())
                <div class="mb-6">
                    <h4 class="font-semibold text-gray-800 mb-3">🏃‍♂️ Detail Visit</h4>
                    <div class="bg-green-50 rounded-xl p-5 border border-green-200">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs text-gray-600 mb-1">Harga Visit</label>
                                <p class="font-medium text-gray-800">Rp {{ number_format($transaction->data_tambahan['harga_visit'] ?? 0, 0, ',', '.') }}</p>
                            </div>
                            <div>
                                <label class="block text-xs text-gray-600 mb-1">Tanggal Visit</label>
                                <p class="font-medium text-gray-800">{{ isset($transaction->data_tambahan['tgl_visit']) ? Carbon\Carbon::parse($transaction->data_tambahan['tgl_visit'])->format('d F Y H:i') : '-' }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                @endif

                <!-- Detail Membership (dari data_tambahan) -->
                @if($transaction->isMembershipOnly() || $transaction->isProdukDanMembership())
                <div class="mb-6">
                    <h4 class="font-semibold text-gray-800 mb-3">🎫 Detail Membership</h4>
                    <div class="bg-purple-50 rounded-xl p-5 border border-purple-200">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs text-gray-600 mb-1">Paket Membership</label>
                                <p class="font-medium text-gray-800">{{ $transaction->data_tambahan['nama_paket'] ?? '-' }}</p>
                            </div>
                            <div>
                                <label class="block text-xs text-gray-600 mb-1">Harga Paket</label>
                                <p class="font-medium text-gray-800">Rp {{ number_format($transaction->data_tambahan['harga_paket'] ?? 0, 0, ',', '.') }}</p>
                            </div>
                            <div>
                                <label class="block text-xs text-gray-600 mb-1">Durasi</label>
                                <p class="font-medium text-gray-800">{{ $transaction->data_tambahan['durasi_hari'] ?? 0 }} Hari</p>
                            </div>
                            <div>
                                <label class="block text-xs text-gray-600 mb-1">Tanggal Mulai</label>
                                <p class="font-medium text-gray-800">{{ isset($transaction->data_tambahan['tgl_mulai']) ? Carbon\Carbon::parse($transaction->data_tambahan['tgl_mulai'])->format('d F Y H:i') : '-' }}</p>
                            </div>
                            <div>
                                <label class="block text-xs text-gray-600 mb-1">Tanggal Selesai</label>
                                <p class="font-medium text-gray-800">{{ isset($transaction->data_tambahan['tgl_selesai']) ? Carbon\Carbon::parse($transaction->data_tambahan['tgl_selesai'])->format('d F Y H:i') : '-' }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                @endif

                <!-- Detail Produk (dari transaction_details) -->
                @if($transaction->details->count() > 0)
                <div class="mb-6">
                    <h4 class="font-semibold text-gray-800 mb-3">📦 Detail Produk</h4>
                    <div class="overflow-x-auto border border-gray-100 rounded-xl">
                        <table class="min-w-full divide-y divide-gray-100">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-16">No</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Produk</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Harga</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Qty</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Subtotal</th>
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
            
            <!-- Ringkasan Pembayaran -->
            <div>
                <div class="bg-gray-50 border border-gray-100 rounded-xl p-6 sticky top-6">
                    <h4 class="font-semibold text-gray-800 mb-4">Ringkasan Pembayaran</h4>
                    
                    @if($transaction->member)
                    <div class="mb-6 p-5 bg-purple-50 border border-purple-200 rounded-xl">
                        <h5 class="font-semibold text-[#27124A] mb-3 flex items-center">
                            <i class="fas fa-user-circle mr-2"></i>
                            Informasi Member
                        </h5>
                        <div class="space-y-2">
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-gray-600">Nama</span>
                                <span class="font-medium text-gray-800">{{ $transaction->member->nama }}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-gray-600">Kode</span>
                                <span class="font-mono text-sm bg-white px-2 py-1 rounded-lg">{{ $transaction->member->kode_member }}</span>
                            </div>
                        </div>
                    </div>
                    @endif
                    
                    <div class="space-y-3 mb-6">
                        @php
                            $subtotalProduk = $transaction->details->sum('subtotal');
                            $biayaVisit = $transaction->data_tambahan['harga_visit'] ?? 0;
                            $biayaMembership = $transaction->data_tambahan['harga_paket'] ?? 0;
                        @endphp

                        @if($subtotalProduk > 0)
                        <div class="flex justify-between">
                            <span class="text-gray-600">Subtotal Produk</span>
                            <span class="font-medium text-gray-800">Rp {{ number_format($subtotalProduk, 0, ',', '.') }}</span>
                        </div>
                        @endif

                        @if($biayaVisit > 0)
                        <div class="flex justify-between">
                            <span class="text-gray-600">Biaya Visit</span>
                            <span class="font-medium text-green-600">Rp {{ number_format($biayaVisit, 0, ',', '.') }}</span>
                        </div>
                        @endif

                        @if($biayaMembership > 0)
                        <div class="flex justify-between">
                            <span class="text-gray-600">Biaya Membership</span>
                            <span class="font-medium text-purple-600">Rp {{ number_format($biayaMembership, 0, ',', '.') }}</span>
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
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection