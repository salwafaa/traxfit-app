@extends('layouts.app')

@section('title', 'Laporan Stok & Paket')
@section('page-title', 'Laporan Stok & Paket')

@section('sidebar')
@include('owner.partials.sidebar')
@endsection

@section('content')
<div class="space-y-4 md:space-y-6 w-full max-w-full">
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3 md:gap-4 w-full">
        <div class="bg-white rounded-xl md:rounded-2xl shadow-sm border border-gray-100 p-3 md:p-4">
            <div class="flex items-center justify-between">
                <div class="flex-1 pr-2">
                    <p class="text-xs md:text-sm text-gray-500 mb-1">Total Produk</p>
                    <p class="text-xl md:text-2xl font-bold text-gray-800">{{ number_format($totalProduk, 0, ',', '.') }}</p>
                </div>
                <div class="w-10 h-10 md:w-12 md:h-12 bg-blue-50 rounded-xl flex items-center justify-center flex-shrink-0">
                    <i class="fas fa-box text-[#27124A] text-base md:text-xl"></i>
                </div>
            </div>
            <div class="mt-2 md:mt-3 flex items-center text-xs text-gray-500">
                <span class="text-blue-500 mr-1">📦</span>
                <span>Produk aktif tersedia</span>
            </div>
        </div>

        <div class="bg-white rounded-xl md:rounded-2xl shadow-sm border border-gray-100 p-3 md:p-4">
            <div class="flex items-center justify-between">
                <div class="flex-1 pr-2">
                    <p class="text-xs md:text-sm text-gray-500 mb-1">Total Stok</p>
                    <p class="text-xl md:text-2xl font-bold text-gray-800">{{ number_format($totalStok, 0, ',', '.') }}</p>
                </div>
                <div class="w-10 h-10 md:w-12 md:h-12 bg-green-50 rounded-xl flex items-center justify-center flex-shrink-0">
                    <i class="fas fa-cubes text-[#27124A] text-base md:text-xl"></i>
                </div>
            </div>
            <div class="mt-2 md:mt-3 flex items-center text-xs text-gray-500">
                <span class="text-green-500 mr-1">📊</span>
                <span>Total seluruh stok</span>
            </div>
        </div>

        <div class="bg-white rounded-xl md:rounded-2xl shadow-sm border border-gray-100 p-3 md:p-4">
            <div class="flex items-center justify-between">
                <div class="flex-1 pr-2">
                    <p class="text-xs md:text-sm text-gray-500 mb-1">Nilai Stok</p>
                    <p class="text-lg md:text-2xl font-bold text-gray-800">Rp {{ number_format($totalNilaiStok, 0, ',', '.') }}</p>
                </div>
                <div class="w-10 h-10 md:w-12 md:h-12 bg-yellow-50 rounded-xl flex items-center justify-center flex-shrink-0">
                    <i class="fas fa-coins text-[#27124A] text-base md:text-xl"></i>
                </div>
            </div>
            <div class="mt-2 md:mt-3 flex items-center text-xs text-gray-500">
                <span class="text-yellow-500 mr-1">💰</span>
                <span>Total nilai aset</span>
            </div>
        </div>

        <div class="bg-white rounded-xl md:rounded-2xl shadow-sm border border-gray-100 p-3 md:p-4">
            <div class="flex items-center justify-between">
                <div class="flex-1 pr-2">
                    <p class="text-xs md:text-sm text-gray-500 mb-1">Produk Kritis</p>
                    <p class="text-xl md:text-2xl font-bold text-red-600">{{ number_format($produkHampirHabis + $produkHabis, 0, ',', '.') }}</p>
                </div>
                <div class="w-10 h-10 md:w-12 md:h-12 bg-red-50 rounded-xl flex items-center justify-center flex-shrink-0">
                    <i class="fas fa-exclamation-triangle text-red-600 text-base md:text-xl"></i>
                </div>
            </div>
            <div class="mt-2 md:mt-3 flex items-center text-xs text-gray-500">
                <span class="text-red-500 mr-1">⚠️</span>
                <span>Stok menipis / habis</span>
            </div>
        </div>
    </div>

    <div class="bg-blue-50 border border-blue-200 rounded-xl md:rounded-2xl p-3 md:p-4 flex items-center">
        <div class="w-6 h-6 md:w-8 md:h-8 bg-blue-100 rounded-full flex items-center justify-center mr-2 md:mr-3 flex-shrink-0">
            <i class="fas fa-info-circle text-blue-600 text-xs md:text-sm"></i>
        </div>
        <p class="text-xs md:text-sm text-blue-800">
            <span class="font-semibold">Informasi:</span> Menampilkan produk aktif dan paket membership. 
            Gunakan filter untuk melihat data spesifik.
        </p>
    </div>

    <div class="bg-white rounded-xl md:rounded-2xl shadow-sm border border-gray-100 overflow-hidden w-full">
        <div class="p-3 md:p-4 border-b border-gray-100">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3">
                <div class="min-w-0 flex-1">
                    <h3 class="text-sm md:text-base font-semibold text-gray-800">Laporan Stok & Paket</h3>
                    <p class="text-xs md:text-sm text-gray-500 mt-0.5">Informasi stok produk dan paket membership</p>
                </div>
            </div>
        </div>

        <div class="p-3 md:p-4 border-b border-gray-100 bg-gray-50/50">
            <form method="GET" action="{{ route('owner.laporan.stok') }}" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-2 md:gap-3">
                <div>
                    <label class="block text-xs md:text-sm font-medium text-gray-700 mb-1">Kategori</label>
                    <select name="category" class="w-full px-2 md:px-3 py-1.5 md:py-2 text-xs md:text-sm border border-gray-200 rounded-lg md:rounded-xl focus:outline-none focus:ring-2 focus:ring-[#27124A]/20 focus:border-[#27124A] transition-all">
                        <option value="">Semua Kategori</option>
                        @foreach($categories ?? [] as $category)
                            <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                {{ $category->nama_kategori }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-xs md:text-sm font-medium text-gray-700 mb-1">Status Stok</label>
                    <select name="stock_status" class="w-full px-2 md:px-3 py-1.5 md:py-2 text-xs md:text-sm border border-gray-200 rounded-lg md:rounded-xl focus:outline-none focus:ring-2 focus:ring-[#27124A]/20 focus:border-[#27124A] transition-all">
                        <option value="">Semua Stok</option>
                        <option value="available" {{ request('stock_status') == 'available' ? 'selected' : '' }}>Tersedia (>5)</option>
                        <option value="low" {{ request('stock_status') == 'low' ? 'selected' : '' }}>Menipis (1-5)</option>
                        <option value="out" {{ request('stock_status') == 'out' ? 'selected' : '' }}>Habis (0)</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs md:text-sm font-medium text-gray-700 mb-1">Status Produk</label>
                    <select name="product_status" class="w-full px-2 md:px-3 py-1.5 md:py-2 text-xs md:text-sm border border-gray-200 rounded-lg md:rounded-xl focus:outline-none focus:ring-2 focus:ring-[#27124A]/20 focus:border-[#27124A] transition-all">
                        <option value="">Semua Produk</option>
                        <option value="active" {{ request('product_status') == 'active' ? 'selected' : '' }}>Aktif</option>
                        <option value="inactive" {{ request('product_status') == 'inactive' ? 'selected' : '' }}>Non-Aktif</option>
                    </select>
                </div>
                <div class="flex items-end gap-2">
                    <button type="submit"
                        class="flex-1 bg-[#27124A] hover:bg-[#3a1d6b] text-white text-xs md:text-sm font-medium py-1.5 md:py-2 px-2 rounded-lg md:rounded-xl transition-all duration-300 flex items-center justify-center">
                        <i class="fas fa-filter mr-1 text-xs"></i>
                        <span class="hidden sm:inline">Filter</span>
                    </button>
                    <a href="{{ route('owner.laporan.stok') }}"
                        class="flex-1 bg-gray-200 hover:bg-gray-300 text-gray-800 text-xs md:text-sm font-medium py-1.5 md:py-2 px-2 rounded-lg md:rounded-xl transition-all duration-300 flex items-center justify-center">
                        <i class="fas fa-redo mr-1 text-xs"></i>
                        <span class="hidden sm:inline">Reset</span>
                    </a>
                </div>
            </form>
        </div>

        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3 p-3 md:p-4 border-b border-gray-100">
            <div class="text-xs md:text-sm text-gray-500 bg-gray-50 px-3 md:px-4 py-1.5 md:py-2 rounded-lg md:rounded-xl">
                <i class="fas fa-info-circle mr-1 md:mr-2 text-[#27124A]"></i>
                <span>Menampilkan {{ $products->firstItem() ?? 0 }} - {{ $products->lastItem() ?? 0 }} dari {{ $products->total() }} produk</span>
            </div>
            
           <div class="flex gap-2">
    <a href="{{ route('owner.laporan.stok', array_merge(request()->query(), ['export' => 'pdf'])) }}" 
       class="bg-red-600 hover:bg-red-700 text-white px-3 md:px-4 py-1.5 md:py-2 rounded-lg md:rounded-xl text-xs md:text-sm transition-all duration-300 flex items-center">
        <i class="fas fa-file-pdf mr-1 md:mr-2"></i> PDF
    </a>
    <a href="{{ route('owner.laporan.stok', array_merge(request()->query(), ['export' => 'excel'])) }}" 
       class="bg-green-600 hover:bg-green-700 text-white px-3 md:px-4 py-1.5 md:py-2 rounded-lg md:rounded-xl text-xs md:text-sm transition-all duration-300 flex items-center">
        <i class="fas fa-file-excel mr-1 md:mr-2"></i> Excel
    </a>
</div>
        </div>

        <div class="overflow-x-auto w-full">
            <table class="min-w-full divide-y divide-gray-100">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-3 md:px-4 py-2 md:py-3 text-left text-xs font-medium text-gray-500 uppercase">Produk</th>
                        <th class="px-3 md:px-4 py-2 md:py-3 text-left text-xs font-medium text-gray-500 uppercase">Kategori</th>
                        <th class="px-3 md:px-4 py-2 md:py-3 text-left text-xs font-medium text-gray-500 uppercase">Harga</th>
                        <th class="px-3 md:px-4 py-2 md:py-3 text-left text-xs font-medium text-gray-500 uppercase">Stok</th>
                        <th class="px-3 md:px-4 py-2 md:py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                        <th class="px-3 md:px-4 py-2 md:py-3 text-left text-xs font-medium text-gray-500 uppercase hidden md:table-cell">Tgl Ditambahkan</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-100">
                    @forelse($products as $product)
                    <tr class="hover:bg-gray-50">
                        <td class="px-3 md:px-4 py-2 md:py-3 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="w-6 h-6 md:w-7 md:h-7 bg-purple-50 rounded-lg flex items-center justify-center mr-2 flex-shrink-0">
                                    <i class="fas fa-box text-xs text-[#27124A]"></i>
                                </div>
                                <div>
                                    <span class="text-xs md:text-sm font-medium text-gray-800">{{ $product->nama_produk }}</span>
                                    @if(!$product->status)
                                        <span class="ml-2 px-1.5 py-0.5 bg-gray-100 text-gray-600 rounded text-xs">Non-Aktif</span>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td class="px-3 md:px-4 py-2 md:py-3 whitespace-nowrap">
                            <span class="px-2 py-1 bg-gray-100 text-gray-600 rounded-lg text-xs">
                                {{ $product->category->nama_kategori ?? '-' }}
                            </span>
                        </td>
                        <td class="px-3 md:px-4 py-2 md:py-3 whitespace-nowrap">
                            <span class="text-xs md:text-sm font-medium text-gray-800">Rp {{ number_format($product->harga, 0, ',', '.') }}</span>
                        </td>
                        <td class="px-3 md:px-4 py-2 md:py-3 whitespace-nowrap">
                            <span class="px-2 py-1 bg-blue-50 text-[#27124A] rounded-lg text-xs font-bold">
                                {{ $product->stok }}
                            </span>
                        </td>
                        <td class="px-3 md:px-4 py-2 md:py-3 whitespace-nowrap">
                            @if($product->stok == 0)
                                <span class="px-2 py-1 bg-red-100 text-red-700 rounded-lg text-xs flex items-center w-fit">
                                    <i class="fas fa-times-circle mr-1"></i> Habis
                                </span>
                            @elseif($product->stok <= 5)
                                <span class="px-2 py-1 bg-yellow-100 text-yellow-700 rounded-lg text-xs flex items-center w-fit">
                                    <i class="fas fa-exclamation-triangle mr-1"></i> Menipis
                                </span>
                            @else
                                <span class="px-2 py-1 bg-green-100 text-green-700 rounded-lg text-xs flex items-center w-fit">
                                    <i class="fas fa-check-circle mr-1"></i> Tersedia
                                </span>
                            @endif
                        </td>
                        <td class="px-3 md:px-4 py-2 md:py-3 whitespace-nowrap hidden md:table-cell">
                            <div class="flex items-center">
                                <div class="w-6 h-6 bg-gray-50 rounded-lg flex items-center justify-center mr-1 flex-shrink-0">
                                    <i class="fas fa-calendar text-gray-400 text-xs"></i>
                                </div>
                                <span class="text-xs text-gray-600">{{ $product->created_at->format('d/m/Y') }}</span>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-4 py-8 text-center">
                            <div class="inline-flex items-center justify-center w-14 h-14 md:w-16 md:h-16 bg-purple-50 rounded-full mb-3">
                                <i class="fas fa-box-open text-xl md:text-2xl text-[#27124A]"></i>
                            </div>
                            <h4 class="text-sm md:text-base font-semibold text-gray-800 mb-1">Tidak Ada Data</h4>
                            <p class="text-xs md:text-sm text-gray-400">Belum ada produk yang terdaftar</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($products->hasPages())
        <div class="p-3 md:p-4 border-t border-gray-100">
            <div class="overflow-x-auto">
                {{ $products->withQueryString()->links() }}
            </div>
        </div>
        @endif
    </div>
</div>
@endsection