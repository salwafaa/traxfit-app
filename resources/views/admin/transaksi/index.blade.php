@extends('layouts.app')

@section('title', 'Kelola Transaksi')
@section('page-title', 'Kelola Transaksi')

@section('sidebar')
@include('admin.partials.sidebar')
@endsection

@section('content')
<div class="space-y-4 md:space-y-6 w-full max-w-full overflow-hidden">
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3 md:gap-4 w-full">
        <div class="bg-white rounded-xl md:rounded-2xl shadow-sm border border-gray-100 p-3 md:p-4 lg:p-5 min-w-0">
            <div class="flex items-center justify-between">
                <div class="min-w-0 flex-1 pr-2">
                    <p class="text-xs md:text-sm text-gray-500 mb-0.5 md:mb-1 truncate">Total Transaksi</p>
                    <p class="text-lg md:text-xl lg:text-2xl font-bold text-gray-800 truncate">{{ $totalTransaksi }}</p>
                </div>
                <div class="w-8 h-8 md:w-10 lg:w-12 md:h-10 lg:h-12 bg-blue-50 rounded-lg md:rounded-xl flex items-center justify-center flex-shrink-0">
                    <i class="fas fa-cash-register text-[#27124A] text-sm md:text-base lg:text-lg"></i>
                </div>
            </div>
            <div class="mt-1 md:mt-2 lg:mt-3 flex items-center text-xs text-gray-500">
                <span class="text-blue-500 mr-1">📊</span>
                <span class="truncate">Semua transaksi</span>
            </div>
        </div>

        <div class="bg-white rounded-xl md:rounded-2xl shadow-sm border border-gray-100 p-3 md:p-4 lg:p-5 min-w-0">
            <div class="flex items-center justify-between">
                <div class="min-w-0 flex-1 pr-2">
                    <p class="text-xs md:text-sm text-gray-500 mb-0.5 md:mb-1 truncate">Pendapatan Hari Ini</p>
                    <p class="text-lg md:text-xl lg:text-2xl font-bold text-green-600 truncate">Rp {{ number_format($totalHariIni, 0, ',', '.') }}</p>
                </div>
                <div class="w-8 h-8 md:w-10 lg:w-12 md:h-10 lg:h-12 bg-green-50 rounded-lg md:rounded-xl flex items-center justify-center flex-shrink-0">
                    <i class="fas fa-money-bill-wave text-[#27124A] text-sm md:text-base lg:text-lg"></i>
                </div>
            </div>
            <div class="mt-1 md:mt-2 lg:mt-3 flex items-center text-xs text-gray-500">
                <span class="text-green-500 mr-1">💰</span>
                <span class="truncate">{{ now()->format('d/m/Y') }}</span>
            </div>
        </div>

        <div class="bg-white rounded-xl md:rounded-2xl shadow-sm border border-gray-100 p-3 md:p-4 lg:p-5 min-w-0">
            <div class="flex items-center justify-between">
                <div class="min-w-0 flex-1 pr-2">
                    <p class="text-xs md:text-sm text-gray-500 mb-0.5 md:mb-1 truncate">Pendapatan Bulan Ini</p>
                    <p class="text-lg md:text-xl lg:text-2xl font-bold text-purple-600 truncate">Rp {{ number_format($totalBulanIni, 0, ',', '.') }}</p>
                </div>
                <div class="w-8 h-8 md:w-10 lg:w-12 md:h-10 lg:h-12 bg-purple-50 rounded-lg md:rounded-xl flex items-center justify-center flex-shrink-0">
                    <i class="fas fa-calendar-alt text-[#27124A] text-sm md:text-base lg:text-lg"></i>
                </div>
            </div>
            <div class="mt-1 md:mt-2 lg:mt-3 flex items-center text-xs text-gray-500">
                <span class="text-purple-500 mr-1">📅</span>
                <span class="truncate">{{ now()->format('F Y') }}</span>
            </div>
        </div>

        <div class="bg-white rounded-xl md:rounded-2xl shadow-sm border border-gray-100 p-3 md:p-4 lg:p-5 min-w-0">
            <div class="flex items-center justify-between">
                <div class="min-w-0 flex-1 pr-2">
                    <p class="text-xs md:text-sm text-gray-500 mb-0.5 md:mb-1 truncate">Pendapatan Tahun Ini</p>
                    <p class="text-lg md:text-xl lg:text-2xl font-bold text-yellow-600 truncate">Rp {{ number_format($totalTahunIni, 0, ',', '.') }}</p>
                </div>
                <div class="w-8 h-8 md:w-10 lg:w-12 md:h-10 lg:h-12 bg-yellow-50 rounded-lg md:rounded-xl flex items-center justify-center flex-shrink-0">
                    <i class="fas fa-chart-line text-[#27124A] text-sm md:text-base lg:text-lg"></i>
                </div>
            </div>
            <div class="mt-1 md:mt-2 lg:mt-3 flex items-center text-xs text-gray-500">
                <span class="text-yellow-500 mr-1">📈</span>
                <span class="truncate">{{ now()->format('Y') }}</span>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="bg-white rounded-xl md:rounded-2xl shadow-sm border border-gray-100 overflow-hidden w-full">
        <!-- Header -->
        <div class="p-3 md:p-4 lg:p-5 border-b border-gray-100">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3">
                <div class="min-w-0 flex-1">
                    <h3 class="text-sm md:text-base lg:text-lg font-semibold text-gray-800 truncate">Daftar Transaksi</h3>
                    <p class="text-xs md:text-sm text-gray-500 mt-0.5 md:mt-1 truncate">Kelola dan lihat semua data transaksi dari semua kasir</p>
                </div>
            </div>
        </div>

        <div class="p-3 md:p-4 lg:p-5 border-b border-gray-100 bg-gray-50/50">
            <form method="GET" action="{{ route('admin.transaksi.index') }}" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-6 gap-2 md:gap-3">
                <div class="min-w-0">
                    <label class="block text-xs md:text-sm font-medium text-gray-700 mb-1">Tgl Mulai</label>
                    <input type="date" name="start_date" value="{{ request('start_date') }}"
                        class="w-full px-2 md:px-3 py-1.5 md:py-2 text-xs md:text-sm border border-gray-200 rounded-lg md:rounded-xl focus:outline-none focus:ring-2 focus:ring-[#27124A]/20 focus:border-[#27124A] transition-all">
                </div>

                <div class="min-w-0">
                    <label class="block text-xs md:text-sm font-medium text-gray-700 mb-1">Tgl Akhir</label>
                    <input type="date" name="end_date" value="{{ request('end_date') }}"
                        class="w-full px-2 md:px-3 py-1.5 md:py-2 text-xs md:text-sm border border-gray-200 rounded-lg md:rounded-xl focus:outline-none focus:ring-2 focus:ring-[#27124A]/20 focus:border-[#27124A] transition-all">
                </div>

                <div class="min-w-0">
                    <label class="block text-xs md:text-sm font-medium text-gray-700 mb-1">Kasir</label>
                    <select name="id_user"
                        class="w-full px-2 md:px-3 py-1.5 md:py-2 text-xs md:text-sm border border-gray-200 rounded-lg md:rounded-xl focus:outline-none focus:ring-2 focus:ring-[#27124A]/20 focus:border-[#27124A] transition-all">
                        <option value="">Semua</option>
                        @foreach($kasirs as $kasir)
                        <option value="{{ $kasir->id }}" {{ request('id_user') == $kasir->id ? 'selected' : '' }}>
                            {{ Str::limit($kasir->nama, 20) }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <div class="min-w-0">
                    <label class="block text-xs md:text-sm font-medium text-gray-700 mb-1">Member</label>
                    <select name="member_status"
                        class="w-full px-2 md:px-3 py-1.5 md:py-2 text-xs md:text-sm border border-gray-200 rounded-lg md:rounded-xl focus:outline-none focus:ring-2 focus:ring-[#27124A]/20 focus:border-[#27124A] transition-all">
                        <option value="">Semua</option>
                        <option value="member" {{ request('member_status') == 'member' ? 'selected' : '' }}>Member</option>
                        <option value="nonmember" {{ request('member_status') == 'nonmember' ? 'selected' : '' }}>Non-Member</option>
                    </select>
                </div>

                <div class="min-w-0">
                    <label class="block text-xs md:text-sm font-medium text-gray-700 mb-1">Jenis</label>
                    <select name="jenis_transaksi"
                        class="w-full px-2 md:px-3 py-1.5 md:py-2 text-xs md:text-sm border border-gray-200 rounded-lg md:rounded-xl focus:outline-none focus:ring-2 focus:ring-[#27124A]/20 focus:border-[#27124A] transition-all">
                        <option value="">Semua</option>
                        <option value="produk" {{ request('jenis_transaksi') == 'produk' ? 'selected' : '' }}>Produk</option>
                        <option value="visit" {{ request('jenis_transaksi') == 'visit' ? 'selected' : '' }}>Visit</option>
                        <option value="membership" {{ request('jenis_transaksi') == 'membership' ? 'selected' : '' }}>Membership</option>
                        <option value="produk_visit" {{ request('jenis_transaksi') == 'produk_visit' ? 'selected' : '' }}>Produk+Visit</option>
                        <option value="produk_membership" {{ request('jenis_transaksi') == 'produk_membership' ? 'selected' : '' }}>Produk+Membership</option>
                    </select>
                </div>

                <div class="flex items-end gap-2">
                    <button type="submit"
                        class="flex-1 bg-[#27124A] hover:bg-[#3a1d6b] text-white text-xs md:text-sm font-medium py-1.5 md:py-2 px-2 rounded-lg md:rounded-xl transition-all duration-300 flex items-center justify-center whitespace-nowrap">
                        <i class="fas fa-filter mr-1 text-xs"></i>
                        <span class="hidden sm:inline">Filter</span>
                    </button>
                    <a href="{{ route('admin.transaksi.index') }}"
                        class="flex-1 bg-gray-200 hover:bg-gray-300 text-gray-800 text-xs md:text-sm font-medium py-1.5 md:py-2 px-2 rounded-lg md:rounded-xl transition-all duration-300 flex items-center justify-center whitespace-nowrap">
                        <i class="fas fa-redo mr-1 text-xs"></i>
                        <span class="hidden sm:inline">Reset</span>
                    </a>
                </div>
            </form>
        </div>

        <div class="overflow-x-auto w-full">
            <div class="inline-block min-w-full align-middle">
                <table class="min-w-full divide-y divide-gray-100 table-auto">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-2 md:px-3 py-2 md:py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-12">No</th>
                            <th class="px-2 md:px-3 py-2 md:py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No. Transaksi</th>
                            <th class="px-2 md:px-3 py-2 md:py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden md:table-cell">Kasir</th>
                            <th class="px-2 md:px-3 py-2 md:py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jenis</th>
                            <th class="px-2 md:px-3 py-2 md:py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden lg:table-cell">Member</th>
                            <th class="px-2 md:px-3 py-2 md:py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                            <th class="px-2 md:px-3 py-2 md:py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden sm:table-cell">Waktu</th>
                            <th class="px-2 md:px-3 py-2 md:py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-100">
                        @forelse($transactions as $transaction)
                            @php
                                $jenisLabels = [
                                    'produk' => ['Produk', 'blue'],
                                    'visit' => ['Visit', 'green'],
                                    'membership' => ['Membership', 'purple'],
                                    'produk_visit' => ['P+Visit', 'orange'],
                                    'produk_membership' => ['P+Member', 'red']
                                ];
                                $label = $jenisLabels[$transaction->jenis_transaksi] ?? ['Unknown', 'gray'];
                            @endphp
                            <tr class="hover:bg-gray-50 transition-colors duration-150">
                                <td class="px-2 md:px-3 py-2 md:py-3 whitespace-nowrap">
                                    <div class="flex items-center justify-center w-6 h-6 md:w-7 md:h-7 bg-gray-100 rounded-lg text-gray-600 font-medium text-xs">
                                        {{ $loop->iteration + ($transactions->currentPage() - 1) * $transactions->perPage() }}
                                    </div>
                                </td>
                                <td class="px-2 md:px-3 py-2 md:py-3 whitespace-nowrap">
                                    <a href="{{ route('admin.transaksi.show', $transaction->id) }}"
                                        class="flex items-center font-mono font-semibold text-[#27124A] hover:text-[#3a1d6b] text-xs">
                                        <div class="w-6 h-6 md:w-7 md:h-7 bg-purple-50 rounded-lg flex items-center justify-center mr-1 flex-shrink-0">
                                            <i class="fas fa-receipt text-xs text-[#27124A]"></i>
                                        </div>
                                        <span class="truncate max-w-[70px] md:max-w-[100px]">{{ $transaction->nomor_unik }}</span>
                                    </a>
                                </td>
                                <td class="px-2 md:px-3 py-2 md:py-3 whitespace-nowrap hidden md:table-cell">
                                    <div class="flex items-center">
                                        <div class="w-6 h-6 md:w-7 md:h-7 bg-gray-100 rounded-full flex items-center justify-center mr-1 flex-shrink-0">
                                            <i class="fas fa-user text-gray-600 text-xs"></i>
                                        </div>
                                        <span class="text-xs text-gray-700 truncate max-w-[80px]">{{ $transaction->user->nama ?? '-' }}</span>
                                    </div>
                                 </td>
                                <td class="px-2 md:px-3 py-2 md:py-3 whitespace-nowrap">
                                    <span class="px-2 py-1 text-xs rounded-lg font-medium bg-{{ $label[1] }}-50 text-{{ $label[1] }}-700 whitespace-nowrap">
                                        {{ $label[0] }}
                                    </span>
                                 </td>
                                <td class="px-2 md:px-3 py-2 md:py-3 whitespace-nowrap hidden lg:table-cell">
                                    @if($transaction->member)
                                        <div class="flex items-center">
                                            <div class="w-6 h-6 md:w-7 md:h-7 bg-green-50 rounded-full flex items-center justify-center mr-1 flex-shrink-0">
                                                <i class="fas fa-user text-[#27124A] text-xs"></i>
                                            </div>
                                            <div class="truncate max-w-[80px]">
                                                <div class="font-medium text-gray-800 text-xs truncate">{{ $transaction->member->nama }}</div>
                                                <div class="text-xs text-gray-400 truncate">{{ $transaction->member->kode_member }}</div>
                                            </div>
                                        </div>
                                    @else
                                        <span class="px-2 py-1 bg-gray-100 text-gray-600 rounded-lg text-xs whitespace-nowrap">Non-Member</span>
                                    @endif
                                 </td>
                                <td class="px-2 md:px-3 py-2 md:py-3 whitespace-nowrap">
                                    <span class="px-2 py-1 bg-blue-50 text-[#27124A] rounded-lg text-xs font-bold whitespace-nowrap">
                                        Rp {{ number_format($transaction->total_harga, 0, ',', '.') }}
                                    </span>
                                 </td>
                                <td class="px-2 md:px-3 py-2 md:py-3 whitespace-nowrap hidden sm:table-cell">
                                    <div class="flex items-center">
                                        <div class="w-6 h-6 md:w-7 md:h-7 bg-gray-50 rounded-lg flex items-center justify-center mr-1 flex-shrink-0">
                                            <i class="fas fa-clock text-gray-400 text-xs"></i>
                                        </div>
                                        <div>
                                            <div class="text-xs text-gray-700">{{ $transaction->created_at->format('H:i') }}</div>
                                            <div class="text-xs text-gray-400">{{ $transaction->created_at->format('d/m/Y') }}</div>
                                        </div>
                                    </div>
                                 </td>
                                <td class="px-2 md:px-3 py-2 md:py-3 whitespace-nowrap">
                                    <div class="flex items-center gap-1 md:gap-2">
                                        <a href="{{ route('admin.transaksi.show', $transaction->id) }}"
                                            class="p-1 md:p-1.5 bg-blue-50 hover:bg-blue-100 text-blue-600 rounded-lg transition-all duration-300 border border-blue-100"
                                            title="Detail Transaksi">
                                            <i class="fas fa-eye text-xs"></i>
                                        </a>
                                    </div>
                                 </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="px-4 py-8 text-center">
                                    <div class="inline-flex items-center justify-center w-14 h-14 md:w-16 md:h-16 bg-purple-50 rounded-full mb-3">
                                        <i class="fas fa-shopping-cart text-xl md:text-2xl text-[#27124A]"></i>
                                    </div>
                                    <h4 class="text-sm md:text-base font-semibold text-gray-800 mb-1">Belum Ada Transaksi</h4>
                                    <p class="text-xs md:text-sm text-gray-400">Belum ada data transaksi dari kasir</p>
                                 </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        @if($transactions->hasPages())
            <div class="p-3 md:p-4 border-t border-gray-100">
                <div class="overflow-x-auto">
                    {{ $transactions->withQueryString()->links() }}
                </div>
            </div>
        @endif
        </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        @if(session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: '{{ session('success') }}',
                background: '#fff',
                color: '#27124A',
                confirmButtonColor: '#27124A',
                timer: 3000,
                timerProgressBar: true,
                showConfirmButton: true,
                customClass: {
                    popup: 'rounded-2xl shadow-xl',
                    confirmButton: 'bg-[#27124A] hover:bg-[#3a1d6b] text-white px-6 py-2 rounded-xl text-sm font-medium transition-all duration-300'
                }
            });
        @endif

        @if(session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Oops!',
                text: '{{ session('error') }}',
                background: '#fff',
                color: '#27124A',
                confirmButtonColor: '#27124A',
                timer: 3000,
                timerProgressBar: true,
                showConfirmButton: true,
                customClass: {
                    popup: 'rounded-2xl shadow-xl',
                    confirmButton: 'bg-[#27124A] hover:bg-[#3a1d6b] text-white px-6 py-2 rounded-xl text-sm font-medium transition-all duration-300'
                }
            });
        @endif

        @if(session('warning'))
            Swal.fire({
                icon: 'warning',
                title: 'Perhatian!',
                text: '{{ session('warning') }}',
                background: '#fff',
                color: '#27124A',
                confirmButtonColor: '#27124A',
                timer: 3000,
                timerProgressBar: true,
                showConfirmButton: true,
                customClass: {
                    popup: 'rounded-2xl shadow-xl',
                    confirmButton: 'bg-[#27124A] hover:bg-[#3a1d6b] text-white px-6 py-2 rounded-xl text-sm font-medium transition-all duration-300'
                }
            });
        @endif

        @if(session('info'))
            Swal.fire({
                icon: 'info',
                title: 'Informasi',
                text: '{{ session('info') }}',
                background: '#fff',
                color: '#27124A',
                confirmButtonColor: '#27124A',
                timer: 3000,
                timerProgressBar: true,
                showConfirmButton: true,
                customClass: {
                    popup: 'rounded-2xl shadow-xl',
                    confirmButton: 'bg-[#27124A] hover:bg-[#3a1d6b] text-white px-6 py-2 rounded-xl text-sm font-medium transition-all duration-300'
                }
            });
        @endif
    });
</script>
@endpush
@endsection