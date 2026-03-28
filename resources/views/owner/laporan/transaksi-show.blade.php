@extends('layouts.app')

@section('title', 'Detail Transaksi')
@section('page-title', 'Detail Transaksi')

@section('sidebar')
@include('owner.partials.sidebar')
@endsection

@section('content')
<div class="bg-white rounded-xl md:rounded-2xl shadow-sm border border-gray-100 overflow-hidden w-full max-w-full">
    <!-- Header -->
    <div class="p-3 md:p-4 lg:p-5 border-b border-gray-100">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3">
            <div class="flex items-center gap-2 md:gap-3 min-w-0 flex-1">
                <a href="{{ route('owner.laporan.transaksi') }}?{{ http_build_query(request()->except('page')) }}" 
                   class="flex items-center px-2 md:px-3 py-1.5 md:py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg md:rounded-xl transition-all duration-300 flex-shrink-0">
                    <i class="fas fa-arrow-left mr-1 text-xs"></i>
                    <span class="text-xs md:text-sm">Kembali ke Laporan</span>
                </a>
                <div class="min-w-0 flex-1">
                    <h3 class="text-sm md:text-base lg:text-lg font-semibold text-gray-800 truncate">Transaksi #{{ $transaction->nomor_unik }}</h3>
                    <p class="text-xs md:text-sm text-gray-500 mt-0.5 truncate">{{ \Carbon\Carbon::parse($transaction->created_at)->format('d F Y H:i:s') }}</p>
                </div>
            </div>
        </div>
    </div>
      
    <div class="p-3 md:p-4 lg:p-5">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-3 md:gap-4 lg:gap-5">
            <!-- Informasi Transaksi (Kiri) -->
            <div class="lg:col-span-2 space-y-3 md:space-y-4 min-w-0">
                <!-- Info Transaksi -->
                <div class="min-w-0">
                    <h4 class="text-sm md:text-base font-semibold text-gray-800 mb-2">Informasi Transaksi</h4>
                    <div class="bg-gray-50 rounded-lg md:rounded-xl p-3 md:p-4 border border-gray-100">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 md:gap-3">
                            <div class="min-w-0">
                                <label class="block text-xs text-gray-500 mb-1">Kasir</label>
                                <div class="flex items-center">
                                    <div class="w-6 h-6 md:w-7 md:h-7 bg-purple-50 rounded-lg flex items-center justify-center mr-1.5 flex-shrink-0">
                                        <i class="fas fa-user text-[#27124A] text-xs"></i>
                                    </div>
                                    <p class="font-medium text-gray-800 text-xs md:text-sm truncate">{{ $transaction->user->nama ?? 'Kasir tidak ditemukan' }}</p>
                                </div>
                            </div>
                            <div class="min-w-0">
                                <label class="block text-xs text-gray-500 mb-1">Status</label>
                                <span class="px-2 py-1 bg-green-50 text-green-700 rounded-lg text-xs font-medium inline-flex items-center whitespace-nowrap">
                                    <i class="fas fa-check-circle mr-1 text-xs"></i>
                                    {{ ucfirst($transaction->status_transaksi ?? 'completed') }}
                                </span>
                            </div>
                            <div class="min-w-0">
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
                                <span class="px-2 py-1 bg-{{ $label[1] }}-50 text-{{ $label[1] }}-700 rounded-lg text-xs font-medium inline-flex items-center whitespace-nowrap">
                                    {{ $label[0] }}
                                </span>
                            </div>
                            <div class="min-w-0">
                                <label class="block text-xs text-gray-500 mb-1">Metode</label>
                                <span class="px-2 py-1 rounded-lg text-xs font-medium inline-flex items-center bg-green-50 text-green-700 whitespace-nowrap">
                                    <i class="fas fa-money-bill-wave mr-1 text-xs"></i>
                                    {{ ucfirst($transaction->metode_bayar ?? 'cash') }}
                                </span>
                            </div>
                            @if($transaction->catatan)
                            <div class="sm:col-span-2">
                                <label class="block text-xs text-gray-500 mb-1">Catatan</label>
                                <div class="bg-white p-2 md:p-3 rounded-lg border border-gray-200">
                                    <p class="text-xs md:text-sm text-gray-700 break-words">{{ $transaction->catatan }}</p>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Detail Visit -->
                @if($transaction->isVisitOnly() || $transaction->isProdukDanVisit())
                @php
                    $dataVisit = $transaction->data_visit;
                @endphp
                <div class="min-w-0">
                    <h4 class="text-sm md:text-base font-semibold text-gray-800 mb-2">🏃‍♂️ Detail Visit</h4>
                    <div class="bg-green-50 rounded-lg md:rounded-xl p-3 md:p-4 border border-green-200">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 md:gap-3">
                            <div class="min-w-0">
                                <label class="block text-xs text-gray-600 mb-1">Harga Visit</label>
                                <p class="font-medium text-gray-800 text-xs md:text-sm">Rp {{ number_format($dataVisit['harga_visit'] ?? 0, 0, ',', '.') }}</p>
                            </div>
                            <div class="min-w-0">
                                <label class="block text-xs text-gray-600 mb-1">Tanggal Visit</label>
                                <p class="font-medium text-gray-800 text-xs md:text-sm break-words">
                                    {{ isset($dataVisit['tgl_visit']) ? \Carbon\Carbon::parse($dataVisit['tgl_visit'])->format('d F Y H:i') : '-' }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                @endif

                <!-- Detail Membership -->
                @if($transaction->isMembershipOnly() || $transaction->isProdukDanMembership())
                @php
                    $dataMembership = $transaction->data_membership;
                    
                    // Fallback jika data masih kosong (untuk transaksi lama)
                    if (empty($dataMembership['harga_paket']) || $dataMembership['harga_paket'] == 0) {
                        // Cari paket berdasarkan ID yang tersimpan di member
                        $paket = null;
                        if ($transaction->member && $transaction->member->id_paket) {
                            $paket = \App\Models\MembershipPackage::find($transaction->member->id_paket);
                        }
                        
                        // Jika tidak ketemu, coba cari berdasarkan total harga
                        if (!$paket) {
                            $paket = \App\Models\MembershipPackage::where('harga', $transaction->total_harga)->first();
                        }
                        
                        $dataMembership = [
                            'id_paket' => $transaction->member->id_paket ?? null,
                            'nama_paket' => $paket ? $paket->nama_paket : ($transaction->member->nama_paket ?? 'Paket Membership'),
                            'durasi_hari' => $paket ? $paket->durasi_hari : 30,
                            'harga_paket' => $paket ? $paket->harga : ($transaction->total_harga ?? 0),
                            'tgl_mulai' => $transaction->created_at,
                            'tgl_selesai' => $transaction->member->tgl_expired ?? $transaction->created_at->addDays(30),
                        ];
                    }
                @endphp
                <div class="min-w-0">
                    <h4 class="text-sm md:text-base font-semibold text-gray-800 mb-2">🎫 Detail Membership</h4>
                    <div class="bg-purple-50 rounded-lg md:rounded-xl p-3 md:p-4 border border-purple-200">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 md:gap-3">
                            <div class="sm:col-span-2">
                                <label class="block text-xs text-gray-600 mb-1">Paket</label>
                                <p class="font-medium text-gray-800 text-xs md:text-sm break-words">
                                    {{ $dataMembership['nama_paket'] }}
                                </p>
                            </div>
                            <div class="min-w-0">
                                <label class="block text-xs text-gray-600 mb-1">Harga Paket</label>
                                <p class="font-medium text-gray-800 text-xs md:text-sm">
                                    Rp {{ number_format($dataMembership['harga_paket'], 0, ',', '.') }}
                                </p>
                            </div>
                            <div class="min-w-0">
                                <label class="block text-xs text-gray-600 mb-1">Durasi</label>
                                <p class="font-medium text-gray-800 text-xs md:text-sm">
                                    {{ $dataMembership['durasi_hari'] }} Hari
                                </p>
                            </div>
                            <div class="min-w-0">
                                <label class="block text-xs text-gray-600 mb-1">Tanggal Mulai</label>
                                <p class="font-medium text-gray-800 text-xs md:text-sm break-words">
                                    {{ isset($dataMembership['tgl_mulai']) ? \Carbon\Carbon::parse($dataMembership['tgl_mulai'])->format('d F Y H:i') : ($transaction->created_at ? $transaction->created_at->format('d F Y H:i') : '-') }}
                                </p>
                            </div>
                            <div class="min-w-0">
                                <label class="block text-xs text-gray-600 mb-1">Tanggal Selesai</label>
                                <p class="font-medium text-gray-800 text-xs md:text-sm break-words">
                                    {{ isset($dataMembership['tgl_selesai']) ? \Carbon\Carbon::parse($dataMembership['tgl_selesai'])->format('d F Y H:i') : ($transaction->member && $transaction->member->tgl_expired ? \Carbon\Carbon::parse($transaction->member->tgl_expired)->format('d F Y H:i') : '-') }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                @endif

                <!-- Detail Produk -->
                @if($transaction->details && $transaction->details->count() > 0)
                <div class="min-w-0">
                    <h4 class="text-sm md:text-base font-semibold text-gray-800 mb-2">📦 Detail Produk</h4>
                    <div class="overflow-x-auto border border-gray-100 rounded-lg md:rounded-xl w-full">
                        <div class="inline-block min-w-full align-middle">
                            <table class="min-w-full divide-y divide-gray-100 table-auto">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-2 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-10">No</th>
                                        <th class="px-2 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Produk</th>
                                        <th class="px-2 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden sm:table-cell">Harga</th>
                                        <th class="px-2 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Qty</th>
                                        <th class="px-2 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-100">
                                    @foreach($transaction->details as $detail)
                                    <tr class="hover:bg-gray-50 transition-colors">
                                        <td class="px-2 py-2 whitespace-nowrap">
                                            <div class="flex items-center justify-center w-5 h-5 md:w-6 md:h-6 bg-gray-100 rounded-lg text-gray-600 font-medium text-xs">
                                                {{ $loop->iteration }}
                                            </div>
                                        </td>
                                        <td class="px-2 py-2">
                                            <div class="flex items-center">
                                                <div class="w-5 h-5 md:w-6 md:h-6 bg-purple-50 rounded-lg flex items-center justify-center mr-1.5 flex-shrink-0">
                                                    <i class="fas fa-box text-[#27124A] text-xs"></i>
                                                </div>
                                                <div class="min-w-0">
                                                    <div class="font-medium text-gray-800 text-xs truncate max-w-[80px] md:max-w-[120px]">{{ $detail->product->nama_produk ?? 'Produk tidak ditemukan' }}</div>
                                                    <div class="text-xs text-gray-400 truncate">{{ $detail->product->category->nama_kategori ?? '-' }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-2 py-2 whitespace-nowrap hidden sm:table-cell">
                                            <span class="text-xs text-gray-700">Rp {{ number_format($detail->harga_satuan, 0, ',', '.') }}</span>
                                        </td>
                                        <td class="px-2 py-2 whitespace-nowrap">
                                            <span class="px-1.5 py-0.5 bg-gray-100 rounded-lg text-xs font-medium">
                                                {{ $detail->qty }}
                                            </span>
                                        </td>
                                        <td class="px-2 py-2 whitespace-nowrap font-medium text-[#27124A] text-xs">
                                            Rp {{ number_format($detail->subtotal, 0, ',', '.') }}
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                @endif
            </div>
            
            <!-- Ringkasan Pembayaran (Kanan) -->
            <div class="lg:col-span-1 min-w-0">
                <div class="bg-gray-50 border border-gray-100 rounded-lg md:rounded-xl p-3 md:p-4 lg:p-5 sticky top-4">
                    <h4 class="text-sm md:text-base font-semibold text-gray-800 mb-3">Ringkasan Pembayaran</h4>
                    
                    @if($transaction->member)
                    <div class="mb-3 md:mb-4 p-3 bg-purple-50 border border-purple-200 rounded-lg">
                        <h5 class="font-semibold text-[#27124A] mb-2 flex items-center text-xs md:text-sm">
                            <i class="fas fa-user-circle mr-1.5 text-xs"></i>
                            Informasi Member
                        </h5>
                        <div class="space-y-1.5">
                            <div class="flex justify-between items-center text-xs">
                                <span class="text-gray-600">Nama</span>
                                <span class="font-medium text-gray-800 truncate ml-2 max-w-[120px]">{{ $transaction->member->nama ?? '-' }}</span>
                            </div>
                            <div class="flex justify-between items-center text-xs">
                                <span class="text-gray-600">Kode</span>
                                <span class="font-mono text-xs bg-white px-2 py-0.5 rounded-lg">{{ $transaction->member->kode_member ?? '-' }}</span>
                            </div>
                            <div class="flex justify-between items-center text-xs">
                                <span class="text-gray-600">Telepon</span>
                                <span class="font-medium text-gray-800 truncate ml-2 max-w-[120px]">{{ $transaction->member->telepon ?? '-' }}</span>
                            </div>
                        </div>
                    </div>
                    @endif
                    
                    <div class="space-y-2 mb-4">
                        @php
                            $subtotalProduk = $transaction->details ? $transaction->details->sum('subtotal') : 0;
                            $dataTambahan = $transaction->data_tambahan ?? [];
                            $biayaVisit = $dataTambahan['harga_visit'] ?? 0;
                            $biayaMembership = $dataTambahan['harga_paket'] ?? 0;
                        @endphp

                        @if($subtotalProduk > 0)
                        <div class="flex justify-between text-xs">
                            <span class="text-gray-600">Subtotal Produk</span>
                            <span class="font-medium text-gray-800">Rp {{ number_format($subtotalProduk, 0, ',', '.') }}</span>
                        </div>
                        @endif

                        @if($biayaVisit > 0)
                        <div class="flex justify-between text-xs">
                            <span class="text-gray-600">Biaya Visit</span>
                            <span class="font-medium text-green-600">Rp {{ number_format($biayaVisit, 0, ',', '.') }}</span>
                        </div>
                        @endif

                        @if($biayaMembership > 0)
                        <div class="flex justify-between text-xs">
                            <span class="text-gray-600">Biaya Membership</span>
                            <span class="font-medium text-purple-600">Rp {{ number_format($biayaMembership, 0, ',', '.') }}</span>
                        </div>
                        @endif

                        <div class="flex justify-between pt-2 border-t border-gray-200">
                            <span class="text-sm md:text-base text-gray-800 font-semibold">Total</span>
                            <span class="font-bold text-base md:text-lg text-[#27124A]">Rp {{ number_format($transaction->total_harga ?? 0, 0, ',', '.') }}</span>
                        </div>
                    </div>
                    
                    <div class="space-y-2">
                        <div class="flex justify-between items-center p-2 bg-white rounded-lg border border-gray-200 text-xs">
                            <span class="text-gray-600">Uang Bayar</span>
                            <span class="font-medium text-green-600">Rp {{ number_format($transaction->uang_bayar ?? 0, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between items-center p-2 bg-white rounded-lg border border-gray-200 text-xs">
                            <span class="text-gray-600">Uang Kembali</span>
                            <span class="font-medium text-blue-600">Rp {{ number_format($transaction->uang_kembali ?? 0, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    /* Custom styles for better appearance */
    .sticky {
        position: sticky;
        top: 1rem;
    }
    
    /* Improve table responsiveness */
    @media (max-width: 640px) {
        .table-auto {
            font-size: 0.75rem;
        }
    }
</style>
@endpush