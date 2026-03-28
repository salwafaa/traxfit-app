@extends('layouts.app')

@section('title', 'Check-in Member')
@section('page-title', 'Check-in Member')

@section('sidebar')
@include('kasir.partials.sidebar')
@endsection

@section('content')
<!-- Header Stats -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
    <!-- Total Check-in Hari Ini -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500 mb-1">Check-in Hari Ini</p>
                <p class="text-2xl font-bold text-gray-800">{{ $todayCheckins->count() }}</p>
            </div>
            <div class="w-12 h-12 bg-blue-50 rounded-xl flex items-center justify-center">
                <i class="fas fa-user-check text-[#27124A] text-xl"></i>
            </div>
        </div>
        <div class="mt-4 flex items-center text-xs text-gray-500">
            <span class="text-blue-500 mr-1">✅</span> Member yang sudah check-in hari ini
        </div>
    </div>

    <!-- Member Aktif -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500 mb-1">Member Aktif</p>
                <p class="text-2xl font-bold text-gray-800">{{ $activeMembersCount ?? 0 }}</p>
            </div>
            <div class="w-12 h-12 bg-green-50 rounded-xl flex items-center justify-center">
                <i class="fas fa-users text-[#27124A] text-xl"></i>
            </div>
        </div>
        <div class="mt-4 flex items-center text-xs text-gray-500">
            <span class="text-green-500 mr-1">👥</span> Total member dengan status aktif
        </div>
    </div>

    <!-- Akan Expired -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500 mb-1">Akan Expired</p>
                <p class="text-2xl font-bold text-yellow-600">{{ $almostExpiredCount ?? 0 }}</p>
            </div>
            <div class="w-12 h-12 bg-yellow-50 rounded-xl flex items-center justify-center">
                <i class="fas fa-hourglass-half text-[#27124A] text-xl"></i>
            </div>
        </div>
        <div class="mt-4 flex items-center text-xs text-gray-500">
            <span class="text-yellow-500 mr-1">⏳</span> Member akan expired (≤7 hari)
        </div>
    </div>

    <!-- Expired -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500 mb-1">Expired</p>
                <p class="text-2xl font-bold text-red-600">{{ $expiredCount ?? 0 }}</p>
            </div>
            <div class="w-12 h-12 bg-red-50 rounded-xl flex items-center justify-center">
                <i class="fas fa-clock text-[#27124A] text-xl"></i>
            </div>
        </div>
        <div class="mt-4 flex items-center text-xs text-gray-500">
            <span class="text-red-500 mr-1">⚠️</span> Member dengan status expired
        </div>
    </div>
</div>

<!-- Main Content -->
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden mb-8">
    <div class="p-6 border-b border-gray-100">
        <div>
            <h3 class="text-lg font-semibold text-gray-800">Check-in Member</h3>
            <p class="text-sm text-gray-500 mt-1">Check-in member yang datang berlatih hari ini</p>
        </div>
    </div>
    
    <!-- Search Form -->
    <div class="p-6 border-b border-gray-100 bg-gray-50/50">
        <div class="max-w-2xl mx-auto">
            <div class="flex flex-col md:flex-row gap-3 items-end">
                <div class="flex-1">
                    <label class="block text-sm font-medium text-gray-700 mb-2" for="searchMember">
                        <i class="fas fa-search mr-2 text-[#27124A]"></i>Cari Member Aktif
                    </label>
                    <div class="relative">
                        <input type="text" id="searchMember" 
                               class="w-full px-5 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#27124A]/20 focus:border-[#27124A] transition-all pl-12"
                               placeholder="Masukkan nama, kode member, atau nomor telepon...">
                        <i class="fas fa-user absolute left-4 top-3.5 text-gray-400"></i>
                    </div>
                </div>
                <button type="button" id="btnSearch"
                        class="bg-[#27124A] hover:bg-[#3a1d6b] text-white px-8 py-3 rounded-xl transition-all duration-300 shadow-sm hover:shadow-md flex items-center justify-center min-w-[120px]">
                    <i class="fas fa-search mr-2"></i>
                    <span>Cari</span>
                </button>
            </div>
            <div class="mt-3 flex items-center text-xs text-gray-500">
                <i class="fas fa-info-circle mr-1 text-[#27124A]"></i>
                Hanya menampilkan member yang aktif (belum expired) dan dapat melakukan check-in 1x sehari
            </div>
        </div>
    </div>
    
    <!-- Loading Indicator -->
    <div id="loading" class="hidden text-center py-12">
        <div class="inline-block">
            <div class="w-16 h-16 border-4 border-[#27124A]/20 border-t-[#27124A] rounded-full animate-spin"></div>
        </div>
        <p class="mt-4 text-gray-600 font-medium">Mencari member...</p>
        <p class="text-sm text-gray-400">Mohon tunggu sebentar</p>
    </div>
    
    <!-- Search Results -->
    <div id="searchResults" class="hidden p-6 border-t border-gray-100">
        <div class="flex items-center justify-between mb-4">
            <h4 class="text-lg font-semibold text-gray-800">
                <i class="fas fa-users mr-2 text-[#27124A]"></i>
                Hasil Pencarian
            </h4>
            <span class="text-sm text-gray-500" id="resultCount">0 member ditemukan</span>
        </div>
        <div id="resultsList" class="grid grid-cols-1 md:grid-cols-2 gap-4 max-h-[500px] overflow-y-auto pr-2">
            <!-- Results will be populated by JavaScript -->
        </div>
    </div>
</div>

<!-- Today's Check-ins -->
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="p-6 border-b border-gray-100">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div>
                <h4 class="text-lg font-semibold text-gray-800">
                    <i class="fas fa-clock mr-2 text-[#27124A]"></i>
                    Check-in Hari Ini
                </h4>
                <p class="text-sm text-gray-500 mt-1">{{ now()->format('d F Y') }}</p>
            </div>
            <div class="flex items-center gap-3">
                <span class="px-4 py-2 bg-blue-50 text-[#27124A] rounded-xl text-sm font-medium">
                    Total: {{ $todayCheckins->count() }} check-in
                </span>
                <button onclick="location.reload()" 
                        class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-xl transition-all duration-300 flex items-center">
                    <i class="fas fa-sync-alt mr-2"></i>
                    Refresh
                </button>
            </div>
        </div>
    </div>
    
    <div class="p-6">
        @if($todayCheckins->isEmpty())
        <div class="text-center py-12">
            <div class="inline-flex items-center justify-center w-24 h-24 bg-blue-50 rounded-full mb-4">
                <i class="fas fa-user-clock text-4xl text-[#27124A]"></i>
            </div>
            <h4 class="text-lg font-semibold text-gray-800 mb-2">Belum Ada Check-in</h4>
            <p class="text-gray-400 text-sm max-w-md mx-auto">
                Belum ada member yang melakukan check-in hari ini. 
                Silahkan cari member di atas untuk melakukan check-in.
            </p>
        </div>
        @else
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-100">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Waktu</th>
                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Member</th>
                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Paket</th>
                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Expired</th>
                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-100">
                    @foreach($todayCheckins as $checkin)
                    <tr class="hover:bg-gray-50 transition-colors duration-150">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="w-10 h-10 bg-green-50 rounded-lg flex items-center justify-center mr-3">
                                    <i class="fas fa-clock text-[#27124A]"></i>
                                </div>
                                <div>
                                    <div class="font-medium text-gray-800">{{ $checkin->jam_masuk->format('H:i') }}</div>
                                    <div class="text-xs text-gray-400">{{ $checkin->created_at->diffForHumans() }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 w-10 h-10 bg-purple-50 rounded-full flex items-center justify-center mr-3">
                                    <i class="fas fa-user text-[#27124A]"></i>
                                </div>
                                <div>
                                    <div class="font-medium text-gray-800">{{ $checkin->member->nama }}</div>
                                    <div class="text-xs text-gray-400">{{ $checkin->member->kode_member }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-3 py-1.5 bg-blue-50 text-[#27124A] rounded-lg text-sm font-medium">
                                {{ $checkin->member->package->nama_paket ?? '-' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="w-8 h-8 bg-gray-50 rounded-lg flex items-center justify-center mr-2">
                                    <i class="fas fa-calendar-alt text-gray-400 text-xs"></i>
                                </div>
                                <div>
                                    <div class="text-sm text-gray-700">{{ $checkin->member->tgl_expired->format('d/m/Y') }}</div>
                                    <div class="text-xs {{ $checkin->member->is_active ? 'text-green-600' : 'text-red-600' }}">
                                        {{ $checkin->member->is_active ? 'Aktif' : 'Expired' }}
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-3 py-1.5 bg-green-50 text-green-700 rounded-lg text-xs font-medium flex items-center w-fit">
                                <i class="fas fa-check-circle mr-1"></i>
                                Check-in
                            </span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        <!-- Summary -->
        <div class="mt-6 pt-6 border-t border-gray-100">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="bg-blue-50/50 rounded-xl p-4 border border-blue-100">
                    <div class="flex items-center">
                        <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center mr-3">
                            <i class="fas fa-clock text-[#27124A]"></i>
                        </div>
                        <div>
                            <p class="text-xs text-blue-700">Check-in Pertama</p>
                            <p class="font-bold text-blue-800">{{ $todayCheckins->first()?->jam_masuk->format('H:i') ?? '-' }}</p>
                        </div>
                    </div>
                </div>
                <div class="bg-green-50/50 rounded-xl p-4 border border-green-100">
                    <div class="flex items-center">
                        <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center mr-3">
                            <i class="fas fa-clock text-[#27124A]"></i>
                        </div>
                        <div>
                            <p class="text-xs text-green-700">Check-in Terakhir</p>
                            <p class="font-bold text-green-800">{{ $todayCheckins->last()?->jam_masuk->format('H:i') ?? '-' }}</p>
                        </div>
                    </div>
                </div>
                <div class="bg-purple-50/50 rounded-xl p-4 border border-purple-100">
                    <div class="flex items-center">
                        <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center mr-3">
                            <i class="fas fa-users text-[#27124A]"></i>
                        </div>
                        <div>
                            <p class="text-xs text-purple-700">Total Member</p>
                            <p class="font-bold text-purple-800">{{ $todayCheckins->count() }} orang</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>

<!-- Instructions -->
<div class="mt-8 bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="p-6 border-b border-gray-100">
        <h4 class="text-lg font-semibold text-gray-800">📋 Petunjuk Check-in</h4>
        <p class="text-sm text-gray-500 mt-1">Panduan lengkap melakukan check-in member</p>
    </div>
    <div class="p-6">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="flex items-start p-4 bg-blue-50/50 rounded-xl border border-blue-100">
                <div class="flex-shrink-0 w-10 h-10 bg-blue-100 rounded-xl flex items-center justify-center mr-3">
                    <i class="fas fa-search text-[#27124A]"></i>
                </div>
                <div>
                    <h5 class="font-medium text-gray-800">Cari Member</h5>
                    <p class="text-xs text-gray-600 mt-1">Cari member aktif berdasarkan nama, kode member, atau nomor telepon</p>
                </div>
            </div>
            
            <div class="flex items-start p-4 bg-green-50/50 rounded-xl border border-green-100">
                <div class="flex-shrink-0 w-10 h-10 bg-green-100 rounded-xl flex items-center justify-center mr-3">
                    <i class="fas fa-check-circle text-[#27124A]"></i>
                </div>
                <div>
                    <h5 class="font-medium text-gray-800">Konfirmasi Check-in</h5>
                    <p class="text-xs text-gray-600 mt-1">Klik tombol "Check-in" pada member yang datang untuk mencatat kehadiran</p>
                </div>
            </div>
            
            <div class="flex items-start p-4 bg-yellow-50/50 rounded-xl border border-yellow-100">
                <div class="flex-shrink-0 w-10 h-10 bg-yellow-100 rounded-xl flex items-center justify-center mr-3">
                    <i class="fas fa-exclamation-triangle text-[#27124A]"></i>
                </div>
                <div>
                    <h5 class="font-medium text-gray-800">Catatan Penting</h5>
                    <p class="text-xs text-gray-600 mt-1">Member hanya dapat melakukan check-in 1x dalam sehari</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Success Modal -->
<div id="successModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
    <div class="bg-white rounded-2xl shadow-xl w-full max-w-md p-6 transform transition-all">
        <div class="text-center">
            <div class="mx-auto flex items-center justify-center h-20 w-20 rounded-full bg-green-100 mb-4">
                <i class="fas fa-check-circle text-green-600 text-4xl"></i>
            </div>
            <h3 class="text-xl font-bold text-gray-900 mb-2" id="successTitle">Check-in Berhasil!</h3>
            <div class="mb-4 p-4 bg-green-50 border border-green-200 rounded-xl" id="successContent">
                <!-- Content will be populated by JavaScript -->
            </div>
            <button type="button" id="closeSuccessModal"
                    class="w-full px-4 py-3 bg-[#27124A] hover:bg-[#3a1d6b] text-white font-medium rounded-xl transition-all duration-300">
                Tutup
            </button>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    /* Custom styles for better appearance */
    .animate-spin {
        animation: spin 1s linear infinite;
    }
    
    @keyframes spin {
        from { transform: rotate(0deg); }
        to { transform: rotate(360deg); }
    }
    
    /* Member card hover effect */
    .member-card {
        transition: all 0.3s ease;
    }
    
    .member-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 25px -5px rgba(39, 18, 74, 0.1);
    }
    
    /* Custom scrollbar */
    #resultsList::-webkit-scrollbar {
        width: 6px;
    }
    
    #resultsList::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }
    
    #resultsList::-webkit-scrollbar-thumb {
        background: #27124A;
        border-radius: 10px;
    }
    
    #resultsList::-webkit-scrollbar-thumb:hover {
        background: #3a1d6b;
    }
    
    /* Modal animation */
    #successModal {
        transition: opacity 0.3s ease;
    }
    
    #successModal > div {
        animation: modalSlideIn 0.3s ease;
    }
    
    @keyframes modalSlideIn {
        from {
            opacity: 0;
            transform: translateY(-20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // ============ DOM ELEMENTS ============
    const searchInput = document.getElementById('searchMember');
    const btnSearch = document.getElementById('btnSearch');
    const loadingDiv = document.getElementById('loading');
    const searchResultsDiv = document.getElementById('searchResults');
    const resultsList = document.getElementById('resultsList');
    const resultCount = document.getElementById('resultCount');
    const successModal = document.getElementById('successModal');
    const successTitle = document.getElementById('successTitle');
    const successContent = document.getElementById('successContent');
    const closeSuccessModalBtn = document.getElementById('closeSuccessModal');
    
    // ============ STATE MANAGEMENT ============
    let debounceTimer;
    
    // ============ HELPER FUNCTIONS ============
    function formatCurrency(amount) {
        return 'Rp ' + new Intl.NumberFormat('id-ID').format(amount || 0);
    }

    function showAlert(type, message) {
        const alertDiv = document.createElement('div');
        alertDiv.className = `fixed top-4 right-4 p-4 rounded-xl shadow-lg z-50 flex items-center border animate-slideIn ${
            type === 'success' ? 'bg-green-50 border-green-200 text-green-800' :
            type === 'error' ? 'bg-red-50 border-red-200 text-red-800' :
            'bg-yellow-50 border-yellow-200 text-yellow-800'
        }`;
        
        const icon = type === 'success' ? 'fa-check-circle' : 
                     type === 'error' ? 'fa-exclamation-circle' : 
                     'fa-exclamation-triangle';
        
        alertDiv.innerHTML = `
            <i class="fas ${icon} mr-3 text-lg"></i>
            <span class="font-medium">${message}</span>
            <button onclick="this.parentElement.remove()" class="ml-4 text-gray-400 hover:text-gray-600">
                <i class="fas fa-times"></i>
            </button>
        `;
        
        document.body.appendChild(alertDiv);
        
        setTimeout(() => {
            if (alertDiv.parentElement) {
                alertDiv.remove();
            }
        }, 5000);
    }

    // ============ SEARCH MEMBER ============
    function searchMember() {
        const search = searchInput.value.trim();
        if (search.length < 2) {
            showAlert('warning', 'Masukkan minimal 2 karakter untuk pencarian');
            return;
        }
        
        // Show loading
        loadingDiv.classList.remove('hidden');
        searchResultsDiv.classList.add('hidden');
        resultsList.innerHTML = '';
        
        // Gunakan endpoint yang benar untuk pencarian member check-in
        const url = `/kasir/checkin/cari-member?search=${encodeURIComponent(search)}`;
        console.log('Fetching URL:', url);
        
        fetch(url)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                console.log('Response data:', data);
                loadingDiv.classList.add('hidden');
                
                if (data.length === 0) {
                    resultsList.innerHTML = `
                        <div class="col-span-2 text-center py-12">
                            <div class="inline-flex items-center justify-center w-20 h-20 bg-gray-100 rounded-full mb-4">
                                <i class="fas fa-user-times text-3xl text-gray-400"></i>
                            </div>
                            <h5 class="text-lg font-medium text-gray-700 mb-2">Tidak Ada Member</h5>
                            <p class="text-sm text-gray-400">Tidak ditemukan member aktif dengan kata kunci "${search}"</p>
                        </div>
                    `;
                    resultCount.textContent = '0 member ditemukan';
                    searchResultsDiv.classList.remove('hidden');
                    return;
                }
                
                displayResults(data);
                resultCount.textContent = `${data.length} member ditemukan`;
            })
            .catch(error => {
                console.error('Error:', error);
                loadingDiv.classList.add('hidden');
                showAlert('error', 'Terjadi kesalahan saat mencari member');
            });
    }
    
    function displayResults(members) {
        let html = '';
        
        members.forEach(member => {
            const statusColor = member.checked_in ? 'bg-yellow-100 text-yellow-800 border-yellow-200' : 'bg-green-100 text-green-800 border-green-200';
            const statusText = member.checked_in ? 'Sudah Check-in' : 'Siap Check-in';
            const statusIcon = member.checked_in ? 'fa-check-circle' : 'fa-clock';
            
            html += `
                <div class="member-card bg-white border border-gray-200 rounded-xl p-5 hover:shadow-lg transition-all duration-300">
                    <div class="flex justify-between items-start mb-3">
                        <div class="flex items-center">
                            <div class="w-12 h-12 bg-purple-50 rounded-xl flex items-center justify-center mr-3">
                                <i class="fas fa-user-circle text-2xl text-[#27124A]"></i>
                            </div>
                            <div>
                                <h5 class="font-semibold text-gray-900">${member.nama}</h5>
                                <p class="text-sm text-gray-500 mt-0.5">${member.kode}</p>
                            </div>
                        </div>
                        <span class="px-3 py-1.5 text-xs font-medium rounded-lg ${statusColor} border flex items-center">
                            <i class="fas ${statusIcon} mr-1"></i>
                            ${statusText}
                        </span>
                    </div>
                    
                    <div class="space-y-2 mt-3">
                        <div class="flex items-center text-sm">
                            <i class="fas fa-box w-5 text-gray-400"></i>
                            <span class="text-gray-600">Paket: ${member.paket}</span>
                        </div>
                        <div class="flex items-center text-sm">
                            <i class="fas fa-calendar-alt w-5 text-gray-400"></i>
                            <span class="text-gray-600">Expired: ${member.expired}</span>
                        </div>
                        <div class="flex items-center text-sm">
                            <i class="fas fa-hourglass-half w-5 text-gray-400"></i>
                            <span class="text-gray-600">Sisa: ${member.sisa_hari} hari</span>
                        </div>
                    </div>
                    
                    <div class="mt-4 pt-3 border-t border-gray-100">
                        <button type="button" onclick="processCheckin(${member.id})" 
                                ${member.checked_in ? 'disabled' : ''}
                                class="w-full py-2.5 ${member.checked_in ? 'bg-gray-100 text-gray-400 cursor-not-allowed' : 'bg-[#27124A] hover:bg-[#3a1d6b] text-white'} rounded-xl transition-all duration-300 flex items-center justify-center font-medium">
                            ${member.checked_in ? 
                                '<i class="fas fa-check-circle mr-2"></i> Sudah Check-in Hari Ini' : 
                                '<i class="fas fa-sign-in-alt mr-2"></i> Check-in Sekarang'}
                        </button>
                    </div>
                </div>
            `;
        });
        
        resultsList.innerHTML = html;
        searchResultsDiv.classList.remove('hidden');
    }

    // ============ PROCESS CHECK-IN ============
window.processCheckin = function(memberId) {
    if (!confirm('Yakin ingin melakukan check-in untuk member ini?')) {
        return;
    }
    
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
    
    fetch('/kasir/checkin', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken,
            'Accept': 'application/json'
        },
        body: JSON.stringify({
            member_id: memberId
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showSuccessModal(data.checkin);
            // Refresh search results
            searchMember();
            // Refresh page after 2 seconds to update check-in list
            setTimeout(() => {
                location.reload();
            }, 2000);
        } else {
            showAlert('error', data.message || 'Gagal melakukan check-in');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showAlert('error', 'Terjadi kesalahan saat proses check-in');
    });
};
    
    function showSuccessModal(checkinData) {
        successTitle.textContent = 'Check-in Berhasil!';
        successContent.innerHTML = `
            <div class="text-left">
                <div class="flex items-center mb-3">
                    <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center mr-3">
                        <i class="fas fa-user text-green-600 text-xl"></i>
                    </div>
                    <div>
                        <p class="font-bold text-gray-800">${checkinData.nama}</p>
                        <p class="text-sm text-gray-600">${checkinData.kode}</p>
                    </div>
                </div>
                <div class="space-y-2 text-sm bg-white p-3 rounded-lg border border-green-200">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Waktu Check-in:</span>
                        <span class="font-medium text-green-700">${checkinData.waktu}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Paket:</span>
                        <span class="font-medium">${checkinData.paket}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Expired:</span>
                        <span class="font-medium">${checkinData.expired}</span>
                    </div>
                </div>
                <p class="text-xs text-green-600 mt-3 text-center">
                    <i class="fas fa-info-circle mr-1"></i>
                    Selamat berlatih!
                </p>
            </div>
        `;
        successModal.classList.remove('hidden');
        successModal.style.display = 'flex';
    }
    
    function closeSuccessModal() {
        successModal.classList.add('hidden');
        successModal.style.display = 'none';
    }
    
    // ============ EVENT LISTENERS ============
    searchInput.addEventListener('input', function() {
        clearTimeout(debounceTimer);
        if (this.value.trim().length >= 2) {
            debounceTimer = setTimeout(searchMember, 500);
        } else {
            searchResultsDiv.classList.add('hidden');
        }
    });
    
    searchInput.addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            clearTimeout(debounceTimer);
            searchMember();
        }
    });
    
    btnSearch.addEventListener('click', function(e) {
        e.preventDefault();
        clearTimeout(debounceTimer);
        searchMember();
    });
    
    closeSuccessModalBtn.addEventListener('click', closeSuccessModal);
    
    // Close modal when clicking outside
    window.addEventListener('click', function(e) {
        if (e.target === successModal) {
            closeSuccessModal();
        }
    });
});
</script>
@endpush