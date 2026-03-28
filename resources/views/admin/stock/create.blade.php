@extends('layouts.app')

@section('title', 'Kelola Stok Produk')
@section('page-title', 'Kelola Stok: ' . $product->nama_produk)

@section('sidebar')
@include('admin.partials.sidebar')
@endsection

@section('content')
<!-- Header Card -->
<div class="bg-[#27124A] text-white rounded-2xl shadow-sm overflow-hidden mb-6">
    <div class="px-6 py-5">
        <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-4">
            <div>
                <h3 class="text-lg font-bold">Kelola Stok Produk</h3>
                <p class="text-sm text-purple-200">Tambah atau kurangi stok produk dengan pencatatan log</p>
            </div>
            <div class="bg-purple-900 bg-opacity-40 px-4 py-2 rounded-xl border border-purple-400 border-opacity-20">
                <div class="text-xs text-purple-200">ID Produk</div>
                <div class="font-mono font-bold">{{ $product->id }}</div>
            </div>
        </div>
    </div>
</div>

<!-- Product Info -->
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden mb-6">
    <div class="p-6">
        <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-6">
            <div class="flex items-center">
                <div class="w-16 h-16 bg-purple-50 rounded-xl flex items-center justify-center mr-5">
                    <i class="fas fa-box text-[#27124A] text-2xl"></i>
                </div>
                <div>
                    <h3 class="text-xl font-bold text-gray-900">{{ $product->nama_produk }}</h3>
                    <div class="flex items-center mt-2 space-x-4">
                        <div class="flex items-center">
                            <i class="fas fa-tag text-gray-400 mr-2"></i>
                            <span class="text-gray-700">{{ $product->category->nama_kategori ?? '-' }}</span>
                        </div>
                        <div class="flex items-center">
                            <i class="fas fa-money-bill-wave text-gray-400 mr-2"></i>
                            <span class="text-gray-700">Rp {{ number_format($product->harga, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="text-center">
                <div class="text-sm text-gray-600 mb-2">Stok Saat Ini</div>
                <div class="text-4xl font-bold {{ $product->stok <= 0 ? 'text-red-600' : ($product->stok <= 10 ? 'text-yellow-600' : 'text-[#27124A]') }}">
                    {{ number_format($product->stok, 0, ',', '.') }}
                    <span class="text-lg text-gray-600">pcs</span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Main Form -->
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden mb-8">
    <div class="p-6">
        <form action="{{ route('admin.stock.store') }}" method="POST">
            @csrf
            
            <input type="hidden" name="id_product" value="{{ $product->id }}">
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Tipe -->
                <div>
                    <label class="block text-gray-800 font-semibold mb-3" for="tipe">
                        <i class="fas fa-exchange-alt text-[#27124A] mr-2"></i>Tipe <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <select name="tipe" id="tipe" required
                                class="w-full px-4 py-3 pl-11 border-2 border-gray-200 rounded-xl focus:outline-none focus:border-[#27124A] focus:ring-2 focus:ring-purple-200 transition-all duration-300 appearance-none bg-gray-50">
                            <option value="">Pilih Tipe</option>
                            <option value="masuk">Stok Masuk (Tambah)</option>
                            <option value="keluar">Stok Keluar (Kurangi)</option>
                        </select>
                        <div class="absolute left-3 top-1/2 transform -translate-y-1/2">
                            <i class="fas fa-exchange-alt text-gray-400"></i>
                        </div>
                        <div class="absolute right-3 top-1/2 transform -translate-y-1/2">
                            <i class="fas fa-chevron-down text-gray-400"></i>
                        </div>
                    </div>
                    @error('tipe')
                        <div class="mt-2 text-sm text-red-600 bg-red-50 p-3 rounded-xl border border-red-100">
                            <i class="fas fa-exclamation-circle mr-2"></i>{{ $message }}
                        </div>
                    @enderror
                </div>
                
                <!-- Quantity -->
                <div>
                    <label class="block text-gray-800 font-semibold mb-3" for="qty">
                        <i class="fas fa-hashtag text-[#27124A] mr-2"></i>Jumlah (pcs) <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <input type="number" name="qty" id="qty" required min="1"
                               class="w-full px-4 py-3 pl-11 border-2 border-gray-200 rounded-xl focus:outline-none focus:border-[#27124A] focus:ring-2 focus:ring-purple-200 transition-all duration-300 bg-gray-50"
                               placeholder="Masukkan jumlah">
                        <div class="absolute left-3 top-1/2 transform -translate-y-1/2">
                            <i class="fas fa-hashtag text-gray-400"></i>
                        </div>
                    </div>
                    @error('qty')
                        <div class="mt-2 text-sm text-red-600 bg-red-50 p-3 rounded-xl border border-red-100">
                            <i class="fas fa-exclamation-circle mr-2"></i>{{ $message }}
                        </div>
                    @enderror
                </div>
                
                <!-- Keterangan -->
                <div class="md:col-span-2">
                    <label class="block text-gray-800 font-semibold mb-3" for="keterangan">
                        <i class="fas fa-sticky-note text-[#27124A] mr-2"></i>Keterangan <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <textarea name="keterangan" id="keterangan" rows="3" required
                                  class="w-full px-4 py-3 pl-11 border-2 border-gray-200 rounded-xl focus:outline-none focus:border-[#27124A] focus:ring-2 focus:ring-purple-200 transition-all duration-300 resize-none bg-gray-50"
                                  placeholder="Contoh: Restock dari supplier, Penjualan, Rusak, Sample, dll."></textarea>
                        <div class="absolute left-3 top-4">
                            <i class="fas fa-sticky-note text-gray-400"></i>
                        </div>
                    </div>
                    @error('keterangan')
                        <div class="mt-2 text-sm text-red-600 bg-red-50 p-3 rounded-xl border border-red-100">
                            <i class="fas fa-exclamation-circle mr-2"></i>{{ $message }}
                        </div>
                    @enderror
                </div>
                
                <!-- Preview -->
                <div class="md:col-span-2">
                    <div id="preview" class="border-2 border-dashed border-gray-200 rounded-2xl p-6 bg-purple-50 hover:border-[#27124A] transition-all duration-300 hidden">
                        <h4 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
                            <i class="fas fa-eye text-[#27124A] mr-2"></i>Preview Perubahan Stok
                        </h4>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div class="bg-white p-4 rounded-xl border border-gray-200">
                                <div class="text-sm text-gray-600 mb-2">Stok Saat Ini</div>
                                <div class="text-2xl font-bold text-gray-900">{{ $product->stok }} pcs</div>
                            </div>
                            <div class="bg-white p-4 rounded-xl border border-gray-200">
                                <div class="text-sm text-gray-600 mb-2">Perubahan</div>
                                <div class="text-2xl font-bold" id="preview_perubahan">0 pcs</div>
                            </div>
                            <div class="bg-white p-4 rounded-xl border border-gray-200">
                                <div class="text-sm text-gray-600 mb-2">Stok Akhir</div>
                                <div class="text-2xl font-bold text-[#27124A]" id="preview_akhir">0 pcs</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Action Buttons -->
            <div class="mt-10 pt-8 border-t border-gray-100">
                <div class="flex flex-col md:flex-row justify-between items-center space-y-4 md:space-y-0">
                    <div class="text-sm text-gray-600">
                        <i class="fas fa-info-circle text-[#27124A] mr-2"></i>
                        Semua perubahan stok akan tercatat dalam log untuk pelacakan
                    </div>
                    <div class="flex space-x-4">
                        <a href="{{ route('admin.stock.index') }}" 
                           class="px-6 py-3 bg-gray-100 hover:bg-gray-200 text-gray-800 font-semibold rounded-xl transition-all duration-300 transform hover:-translate-y-1 shadow-sm hover:shadow-md flex items-center border border-gray-200">
                            <i class="fas fa-times mr-2"></i> Batal
                        </a>
                        <button type="submit"
                                class="px-6 py-3 bg-[#27124A] hover:bg-[#3a1d6e] text-white font-semibold rounded-xl transition-all duration-300 transform hover:-translate-y-1 shadow-sm hover:shadow-md flex items-center group">
                            <i class="fas fa-save mr-2 group-hover:rotate-12 transition-transform"></i> Simpan Perubahan Stok
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Recent Stock History -->
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="p-6 border-b border-gray-100">
        <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-4">
            <div>
                <h3 class="text-lg font-bold text-gray-800">Riwayat Stok Terbaru</h3>
                <p class="text-gray-600 mt-1">5 transaksi stok terakhir untuk produk ini</p>
            </div>
            <a href="{{ route('admin.stock.log') }}?product={{ $product->id }}" 
               class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-800 font-semibold rounded-xl transition-all duration-300 transform hover:-translate-y-1 shadow-sm hover:shadow-md flex items-center text-sm border border-gray-200">
                <i class="fas fa-eye mr-2"></i> Lihat Semua
            </a>
        </div>
    </div>
    
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-100">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Tanggal</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Tipe</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Jumlah</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Keterangan</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">User</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-100">
                @forelse($product->stockLogs()->with('user')->latest()->take(5)->get() as $log)
                <tr class="hover:bg-gray-50 transition-colors duration-150">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900">{{ $log->created_at->format('d/m/Y') }}</div>
                        <div class="text-xs text-gray-500">{{ $log->created_at->format('H:i') }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-3 py-1.5 rounded-xl text-sm font-semibold 
                            {{ $log->tipe == 'masuk' ? 'bg-green-50 text-green-700 border border-green-200' : 'bg-red-50 text-red-700 border border-red-200' }}">
                            {{ ucfirst($log->tipe) }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="font-bold {{ $log->tipe == 'masuk' ? 'text-green-600' : 'text-red-600' }}">
                            {{ $log->tipe == 'masuk' ? '+' : '-' }}{{ $log->qty }} pcs
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="text-sm text-gray-900">{{ $log->keterangan }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900">{{ $log->user->nama ?? '-' }}</div>
                        <div class="text-xs text-gray-500">{{ $log->user->role ?? '-' }}</div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-8 text-center">
                        <div class="inline-flex items-center justify-center w-16 h-16 bg-purple-50 rounded-full mb-4">
                            <i class="fas fa-history text-2xl text-[#27124A]"></i>
                        </div>
                        <h4 class="text-lg font-bold text-gray-700 mb-2">Belum Ada Riwayat Stok</h4>
                        <p class="text-gray-500">Stok masuk/keluar akan tercatat di sini</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const tipeSelect = document.getElementById('tipe');
    const qtyInput = document.getElementById('qty');
    const previewDiv = document.getElementById('preview');
    const previewPerubahan = document.getElementById('preview_perubahan');
    const previewAkhir = document.getElementById('preview_akhir');
    
    const stokAwal = {{ $product->stok }};
    
    function updatePreview() {
        const tipe = tipeSelect.value;
        const qty = qtyInput.value ? parseInt(qtyInput.value) : 0;
        
        if (tipe && qty > 0) {
            previewDiv.classList.remove('hidden');
            
            let perubahan = qty;
            let akhir = stokAwal;
            
            if (tipe == 'masuk') {
                perubahan = '+' + qty + ' pcs';
                akhir = stokAwal + qty;
                previewPerubahan.className = 'text-2xl font-bold text-green-600';
                previewAkhir.className = 'text-2xl font-bold text-green-600';
            } else {
                perubahan = '-' + qty + ' pcs';
                akhir = stokAwal - qty;
                previewPerubahan.className = 'text-2xl font-bold text-red-600';
                previewAkhir.className = akhir < 0 ? 'text-2xl font-bold text-red-600' : 'text-2xl font-bold text-[#27124A]';
            }
            
            previewPerubahan.textContent = perubahan;
            previewAkhir.textContent = akhir + ' pcs';
        } else {
            previewDiv.classList.add('hidden');
        }
    }
    
    tipeSelect.addEventListener('change', updatePreview);
    qtyInput.addEventListener('input', updatePreview);
});
</script>
@endpush