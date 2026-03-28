@extends('layouts.app')

@section('title', 'Cek Status Member')
@section('page-title', 'Cek Status Member')

@section('sidebar')
@include('kasir.partials.sidebar')
@endsection

@section('content')
<!-- Header Stats -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <!-- Total Member Aktif -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500 mb-1">Total Member Aktif</p>
                <p class="text-2xl font-bold text-gray-800" id="totalActive">{{ $totalActive ?? 0 }}</p>
            </div>
            <div class="w-12 h-12 bg-blue-50 rounded-xl flex items-center justify-center">
                <i class="fas fa-users text-[#27124A] text-xl"></i>
            </div>
        </div>
        <div class="mt-4 flex items-center text-xs text-gray-500">
            <span class="text-blue-500 mr-1">👥</span> Member dengan status aktif
        </div>
    </div>

    <!-- Expired Hari Ini -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500 mb-1">Expired Hari Ini</p>
                <p class="text-2xl font-bold text-red-600" id="expiredToday">{{ $expiredToday ?? 0 }}</p>
            </div>
            <div class="w-12 h-12 bg-red-50 rounded-xl flex items-center justify-center">
                <i class="fas fa-clock text-[#27124A] text-xl"></i>
            </div>
        </div>
        <div class="mt-4 flex items-center text-xs text-gray-500">
            <span class="text-red-500 mr-1">⚠️</span> Member yang expired hari ini
        </div>
    </div>

    <!-- Akan Expired -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500 mb-1">Akan Expired</p>
                <p class="text-2xl font-bold text-yellow-600" id="almostExpired">{{ $almostExpired ?? 0 }}</p>
            </div>
            <div class="w-12 h-12 bg-yellow-50 rounded-xl flex items-center justify-center">
                <i class="fas fa-hourglass-half text-[#27124A] text-xl"></i>
            </div>
        </div>
        <div class="mt-4 flex items-center text-xs text-gray-500">
            <span class="text-yellow-500 mr-1">⏳</span> Member akan expired (≤7 hari)
        </div>
    </div>
</div>

<!-- Main Content -->
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="p-6 border-b border-gray-100">
        <div>
            <h3 class="text-lg font-semibold text-gray-800">Cek Status Member</h3>
            <p class="text-sm text-gray-500 mt-1">Cari member berdasarkan nama, kode member, atau nomor telepon</p>
        </div>
    </div>
    
    <!-- Search Form -->
    <div class="p-6 border-b border-gray-100 bg-gray-50/50">
        <div class="max-w-2xl mx-auto">
            <div class="flex flex-col md:flex-row gap-3 items-end">
                <div class="flex-1">
                    <label class="block text-sm font-medium text-gray-700 mb-2" for="searchMember">
                        <i class="fas fa-search mr-2 text-[#27124A]"></i>Kata Kunci Pencarian
                    </label>
                    <div class="relative">
                        <input type="text" id="searchMember" 
                               class="w-full px-5 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#27124A]/20 focus:border-[#27124A] transition-all pl-12"
                               placeholder="Masukkan nama, kode member, atau nomor telepon..."
                               autocomplete="off">
                        <i class="fas fa-search absolute left-4 top-3.5 text-gray-400"></i>
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
                Tekan Enter atau klik tombol Cari untuk memulai pencarian
            </div>
        </div>
    </div>
    
    <!-- Loading State -->
    <div id="loading" class="hidden text-center py-12">
        <div class="inline-block">
            <div class="w-16 h-16 border-4 border-[#27124A]/20 border-t-[#27124A] rounded-full animate-spin"></div>
        </div>
        <p class="mt-4 text-gray-600 font-medium">Mencari member...</p>
        <p class="text-sm text-gray-400">Mohon tunggu sebentar</p>
    </div>
    
    <!-- Initial State -->
    <div id="initialState" class="text-center py-12">
        <div class="inline-flex items-center justify-center w-24 h-24 bg-purple-50 rounded-full mb-4">
            <i class="fas fa-user-friends text-4xl text-[#27124A]"></i>
        </div>
        <h4 class="text-lg font-semibold text-gray-800 mb-2">Cari Member</h4>
        <p class="text-gray-400 text-sm max-w-md mx-auto">
            Gunakan form pencarian di atas untuk mencari member. 
            Anda dapat mencari berdasarkan nama, kode member, atau nomor telepon.
        </p>
        <div class="mt-6 flex justify-center gap-3">
            <div class="flex items-center text-xs bg-green-50 text-green-700 px-3 py-1.5 rounded-lg">
                <span class="w-2 h-2 bg-green-500 rounded-full mr-2"></span>
                Aktif
            </div>
            <div class="flex items-center text-xs bg-yellow-50 text-yellow-700 px-3 py-1.5 rounded-lg">
                <span class="w-2 h-2 bg-yellow-500 rounded-full mr-2"></span>
                Akan Expired
            </div>
            <div class="flex items-center text-xs bg-red-50 text-red-700 px-3 py-1.5 rounded-lg">
                <span class="w-2 h-2 bg-red-500 rounded-full mr-2"></span>
                Expired
            </div>
        </div>
    </div>
    
    <!-- No Results State -->
    <div id="noResults" class="hidden text-center py-12">
        <div class="inline-flex items-center justify-center w-24 h-24 bg-red-50 rounded-full mb-4">
            <i class="fas fa-user-times text-4xl text-red-500"></i>
        </div>
        <h4 class="text-lg font-semibold text-gray-800 mb-2">Member Tidak Ditemukan</h4>
        <p class="text-gray-400 text-sm max-w-md mx-auto" id="noResultsMessage">
            Tidak ada member yang cocok dengan kata kunci pencarian
        </p>
        <div class="mt-4 flex justify-center">
            <button type="button" onclick="showRegisterForm()"
                    class="px-6 py-2.5 bg-green-600 hover:bg-green-700 text-white font-medium rounded-xl transition-all duration-300 flex items-center shadow-sm">
                <i class="fas fa-user-plus mr-2"></i>
                Daftar Member Baru
            </button>
        </div>
    </div>
    
    <!-- Search Results -->
    <div id="searchResults" class="hidden p-6">
        <div class="flex items-center justify-between mb-4">
            <h4 class="text-lg font-semibold text-gray-800">
                <i class="fas fa-users mr-2 text-[#27124A]"></i>
                Hasil Pencarian
            </h4>
            <span class="text-sm text-gray-500" id="resultCount">0 member ditemukan</span>
        </div>
        <div id="resultsList" class="grid grid-cols-1 md:grid-cols-2 gap-4 max-h-[600px] overflow-y-auto pr-2">
            <!-- Results will be populated by JavaScript -->
        </div>
        <div class="mt-6 text-center">
            <button type="button" onclick="showRegisterForm()"
                    class="px-6 py-2.5 bg-green-600 hover:bg-green-700 text-white font-medium rounded-xl transition-all duration-300 inline-flex items-center shadow-sm">
                <i class="fas fa-user-plus mr-2"></i>
                Daftar Member Baru
            </button>
        </div>
    </div>
</div>

<!-- Modal Detail Member -->
<div id="memberModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
    <div class="bg-white rounded-2xl shadow-xl w-full max-w-2xl p-6 transform transition-all max-h-[90vh] overflow-y-auto">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-xl font-bold text-gray-800">
                <i class="fas fa-user-circle mr-2 text-[#27124A]"></i>
                Detail Member
            </h3>
            <button type="button" onclick="closeMemberModal()" class="text-gray-400 hover:text-gray-600">
                <i class="fas fa-times text-xl"></i>
            </button>
        </div>
        
        <div id="memberDetailContent" class="space-y-4">
            <!-- Content will be populated by JavaScript -->
        </div>
        
        <div class="mt-6 flex gap-3">
            <button type="button" onclick="closeMemberModal()"
                    class="flex-1 px-4 py-2.5 bg-gray-200 hover:bg-gray-300 text-gray-800 font-medium rounded-xl transition-all duration-300">
                Tutup
            </button>
            <button type="button" id="renewFromDetailBtn"
                    class="flex-1 px-4 py-2.5 bg-green-600 hover:bg-green-700 text-white font-medium rounded-xl transition-all duration-300 hidden">
                <i class="fas fa-redo mr-2"></i>
                Perpanjang Member
            </button>
        </div>
    </div>
</div>

<!-- Modal Perpanjangan -->
<div id="renewModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
    <div class="bg-white rounded-2xl shadow-xl w-full max-w-md p-6 transform transition-all">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-xl font-bold text-gray-800">
                <i class="fas fa-redo mr-2 text-green-600"></i>
                Perpanjang Membership
            </h3>
            <button type="button" onclick="closeRenewModal()" class="text-gray-400 hover:text-gray-600">
                <i class="fas fa-times text-xl"></i>
            </button>
        </div>
        
        <div id="renewMemberInfo" class="mb-6 p-4 bg-purple-50 border border-purple-200 rounded-xl">
            <!-- Member info will be populated -->
        </div>
        
        <div class="mb-5">
            <label class="block text-sm font-medium text-gray-700 mb-2" for="renewPackage">
                <i class="fas fa-box mr-2 text-[#27124A]"></i>Pilih Paket
            </label>
            <select id="renewPackage" 
                    class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#27124A]/20 focus:border-[#27124A] transition-all">
                <option value="">-- Pilih Paket Membership --</option>
            </select>
            <div id="packageError" class="mt-2 text-red-600 text-sm hidden flex items-center">
                <i class="fas fa-exclamation-circle mr-1"></i>
                Pilih paket terlebih dahulu
            </div>
        </div>
        
        <div class="flex gap-3">
            <button type="button" onclick="closeRenewModal()"
                    class="flex-1 px-4 py-2.5 bg-gray-200 hover:bg-gray-300 text-gray-800 font-medium rounded-xl transition-all duration-300">
                Batal
            </button>
            <button type="button" id="btnRenew"
                    class="flex-1 px-4 py-2.5 bg-green-600 hover:bg-green-700 text-white font-medium rounded-xl transition-all duration-300">
                <i class="fas fa-redo mr-2"></i>
                Perpanjang
            </button>
        </div>
    </div>
</div>

<!-- Modal Daftar Baru -->
<div id="registerModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
    <div class="bg-white rounded-2xl shadow-xl w-full max-w-md p-6 transform transition-all">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-xl font-bold text-gray-800">
                <i class="fas fa-user-plus mr-2 text-green-600"></i>
                Daftar Member Baru
            </h3>
            <button type="button" onclick="closeRegisterModal()" class="text-gray-400 hover:text-gray-600">
                <i class="fas fa-times text-xl"></i>
            </button>
        </div>
        
        <form id="registerForm" onsubmit="event.preventDefault(); processRegister();">
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2" for="registerNama">
                    <i class="fas fa-user mr-2 text-[#27124A]"></i>Nama Lengkap <span class="text-red-500">*</span>
                </label>
                <input type="text" id="registerNama" required
                       class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#27124A]/20 focus:border-[#27124A] transition-all"
                       placeholder="Masukkan nama lengkap">
            </div>
            
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2" for="registerTelepon">
                    <i class="fas fa-phone mr-2 text-[#27124A]"></i>Nomor Telepon
                </label>
                <input type="text" id="registerTelepon"
                       class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#27124A]/20 focus:border-[#27124A] transition-all"
                       placeholder="0812xxxxxxxx">
            </div>
            
            <div class="mb-5">
                <label class="block text-sm font-medium text-gray-700 mb-2" for="registerPackage">
                    <i class="fas fa-box mr-2 text-[#27124A]"></i>Pilih Paket <span class="text-red-500">*</span>
                </label>
                <select id="registerPackage" required
                        class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#27124A]/20 focus:border-[#27124A] transition-all">
                    <option value="">-- Pilih Paket Membership --</option>
                </select>
            </div>
            
            <div class="flex gap-3">
                <button type="button" onclick="closeRegisterModal()"
                        class="flex-1 px-4 py-2.5 bg-gray-200 hover:bg-gray-300 text-gray-800 font-medium rounded-xl transition-all duration-300">
                    Batal
                </button>
                <button type="submit"
                        class="flex-1 px-4 py-2.5 bg-green-600 hover:bg-green-700 text-white font-medium rounded-xl transition-all duration-300">
                    <i class="fas fa-save mr-2"></i>
                    Daftarkan
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Instructions -->
<div class="mt-8 bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="p-6 border-b border-gray-100">
        <h4 class="text-lg font-semibold text-gray-800">📋 Alur Penggunaan</h4>
        <p class="text-sm text-gray-500 mt-1">Panduan lengkap menggunakan fitur cek member</p>
    </div>
    <div class="p-6">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="flex items-start p-4 bg-blue-50/50 rounded-xl border border-blue-100">
                <div class="flex-shrink-0 w-10 h-10 bg-blue-100 rounded-xl flex items-center justify-center mr-3">
                    <i class="fas fa-search text-[#27124A]"></i>
                </div>
                <div>
                    <h5 class="font-medium text-gray-800">Cari Member</h5>
                    <p class="text-xs text-gray-600 mt-1">Cari berdasarkan Nama, Kode Member, atau Nomor Telepon</p>
                </div>
            </div>
            
            <div class="flex items-start p-4 bg-green-50/50 rounded-xl border border-green-100">
                <div class="flex-shrink-0 w-10 h-10 bg-green-100 rounded-xl flex items-center justify-center mr-3">
                    <i class="fas fa-redo text-[#27124A]"></i>
                </div>
                <div>
                    <h5 class="font-medium text-gray-800">Member Ditemukan</h5>
                    <p class="text-xs text-gray-600 mt-1">Jika member ada, lihat status (Aktif/Akan Expired/Expired)</p>
                </div>
            </div>
            
            <div class="flex items-start p-4 bg-yellow-50/50 rounded-xl border border-yellow-100">
                <div class="flex-shrink-0 w-10 h-10 bg-yellow-100 rounded-xl flex items-center justify-center mr-3">
                    <i class="fas fa-user-plus text-[#27124A]"></i>
                </div>
                <div>
                    <h5 class="font-medium text-gray-800">Member Tidak Ditemukan</h5>
                    <p class="text-xs text-gray-600 mt-1">Klik "Daftar Member Baru" untuk mendaftarkan member baru</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .animate-spin {
        animation: spin 1s linear infinite;
    }
    
    @keyframes spin {
        from { transform: rotate(0deg); }
        to { transform: rotate(360deg); }
    }
    
    .member-card {
        transition: all 0.3s ease;
    }
    
    .member-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 25px -5px rgba(39, 18, 74, 0.1);
    }
    
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
    
    #memberModal > div,
    #renewModal > div,
    #registerModal > div {
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
    // DOM Elements
    const searchInput = document.getElementById('searchMember');
    const btnSearch = document.getElementById('btnSearch');
    const loadingDiv = document.getElementById('loading');
    const initialStateDiv = document.getElementById('initialState');
    const noResultsDiv = document.getElementById('noResults');
    const searchResultsDiv = document.getElementById('searchResults');
    const resultsList = document.getElementById('resultsList');
    const resultCount = document.getElementById('resultCount');
    const noResultsMessage = document.getElementById('noResultsMessage');
    
    // Modal elements
    const memberModal = document.getElementById('memberModal');
    const renewModal = document.getElementById('renewModal');
    const registerModal = document.getElementById('registerModal');
    const memberDetailContent = document.getElementById('memberDetailContent');
    const renewMemberInfo = document.getElementById('renewMemberInfo');
    const renewPackageSelect = document.getElementById('renewPackage');
    const registerPackageSelect = document.getElementById('registerPackage');
    const btnRenew = document.getElementById('btnRenew');
    const renewFromDetailBtn = document.getElementById('renewFromDetailBtn');
    
    // State
    let currentMember = null;
    let packages = [];
    let debounceTimer;

    // ============ FETCH PACKAGES ============
    function fetchPackages() {
        fetch('/kasir/member/packages')
            .then(response => {
                if (!response.ok) throw new Error('Network response was not ok');
                return response.json();
            })
            .then(data => {
                console.log('Packages loaded:', data);
                packages = data;
                populatePackageSelects();
            })
            .catch(error => {
                console.error('Error fetching packages:', error);
                loadFallbackPackages();
            });
    }
    
    function loadFallbackPackages() {
        packages = [
            { id: 1, nama_paket: 'Paket 1 Bulan', durasi_hari: 30, harga: 300000 },
            { id: 2, nama_paket: 'Paket 3 Bulan', durasi_hari: 90, harga: 800000 },
            { id: 3, nama_paket: 'Paket 6 Bulan', durasi_hari: 180, harga: 1500000 },
            { id: 4, nama_paket: 'Paket 1 Tahun', durasi_hari: 365, harga: 2800000 }
        ];
        populatePackageSelects();
    }
    
    function populatePackageSelects() {
        // Populate renew package select
        renewPackageSelect.innerHTML = '<option value="">-- Pilih Paket Membership --</option>';
        
        // Populate register package select
        registerPackageSelect.innerHTML = '<option value="">-- Pilih Paket Membership --</option>';
        
        packages.forEach(pkg => {
            const option1 = document.createElement('option');
            option1.value = pkg.id;
            option1.textContent = `${pkg.nama_paket} (${pkg.durasi_hari} hari) - Rp ${pkg.harga?.toLocaleString('id-ID') || '0'}`;
            renewPackageSelect.appendChild(option1);
            
            const option2 = document.createElement('option');
            option2.value = pkg.id;
            option2.textContent = `${pkg.nama_paket} (${pkg.durasi_hari} hari) - Rp ${pkg.harga?.toLocaleString('id-ID') || '0'}`;
            registerPackageSelect.appendChild(option2);
        });
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
        initialStateDiv.classList.add('hidden');
        noResultsDiv.classList.add('hidden');
        searchResultsDiv.classList.add('hidden');
        
        fetch(`/kasir/member/cari?search=${encodeURIComponent(search)}`)
            .then(response => response.json())
            .then(data => {
                loadingDiv.classList.add('hidden');
                
                if (data.length === 0) {
                    noResultsMessage.textContent = `Tidak ada member yang cocok dengan kata kunci "${search}"`;
                    noResultsDiv.classList.remove('hidden');
                    return;
                }
                
                displayResults(data);
                resultCount.textContent = `${data.length} member ditemukan`;
                searchResultsDiv.classList.remove('hidden');
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
            html += `
                <div class="member-card bg-white border border-gray-200 rounded-xl p-5 hover:shadow-lg cursor-pointer transition-all duration-300"
                     onclick="showMemberDetail(${JSON.stringify(member).replace(/"/g, '&quot;')})">
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
                        <span class="px-3 py-1.5 text-xs font-medium rounded-lg ${member.status_class} border flex items-center">
                            <i class="fas ${member.status_icon} mr-1"></i>
                            ${member.status}
                        </span>
                    </div>
                    
                    <div class="space-y-2 mt-3">
                        <div class="flex items-center text-sm">
                            <i class="fas fa-phone-alt w-5 text-gray-400"></i>
                            <span class="text-gray-600">${member.telepon}</span>
                        </div>
                        <div class="flex items-center text-sm">
                            <i class="fas fa-box w-5 text-gray-400"></i>
                            <span class="text-gray-600">${member.paket}</span>
                        </div>
                        <div class="flex items-center text-sm">
                            <i class="fas fa-calendar-alt w-5 text-gray-400"></i>
                            <span class="text-gray-600">Exp: ${member.tgl_expired}</span>
                        </div>
                    </div>
                    
                    <div class="mt-4 pt-3 border-t border-gray-100 flex gap-2">
                        <button type="button" onclick="event.stopPropagation(); showMemberDetail(${JSON.stringify(member).replace(/"/g, '&quot;')})"
                                class="flex-1 py-2 bg-blue-50 hover:bg-blue-100 text-blue-700 rounded-lg transition-all duration-300 text-sm font-medium">
                            <i class="fas fa-eye mr-1"></i> Detail
                        </button>
                        ${!member.is_active || member.status === 'Akan Expired' ? `
                        <button type="button" onclick="event.stopPropagation(); openRenewModal(${JSON.stringify(member).replace(/"/g, '&quot;')})"
                                class="flex-1 py-2 bg-green-50 hover:bg-green-100 text-green-700 rounded-lg transition-all duration-300 text-sm font-medium">
                            <i class="fas fa-redo mr-1"></i> Perpanjang
                        </button>
                        ` : ''}
                    </div>
                </div>
            `;
        });
        
        resultsList.innerHTML = html;
    }

    // ============ SHOW MEMBER DETAIL ============
    window.showMemberDetail = function(member) {
        currentMember = member;
        
        const statusIcon = member.status === 'Aktif' ? 'fa-check-circle text-green-600' : 
                          (member.status === 'Akan Expired' ? 'fa-exclamation-triangle text-yellow-600' : 'fa-times-circle text-red-600');
        
        const statusBg = member.status === 'Aktif' ? 'bg-green-50 border-green-200' : 
                        (member.status === 'Akan Expired' ? 'bg-yellow-50 border-yellow-200' : 'bg-red-50 border-red-200');
        
        const statusText = member.status === 'Aktif' ? 'text-green-700' : 
                          (member.status === 'Akan Expired' ? 'text-yellow-700' : 'text-red-700');
        
        memberDetailContent.innerHTML = `
            <div class="bg-gradient-to-r from-[#27124A] to-[#3a1d6b] rounded-xl p-6 text-white">
                <div class="flex items-center">
                    <div class="w-16 h-16 bg-white/10 rounded-full flex items-center justify-center mr-4">
                        <i class="fas fa-user text-3xl text-white"></i>
                    </div>
                    <div>
                        <h4 class="text-xl font-bold">${member.nama}</h4>
                        <p class="text-purple-200 text-sm">${member.kode}</p>
                    </div>
                </div>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="bg-gray-50 rounded-xl p-4 border border-gray-200">
                    <h5 class="font-medium text-gray-700 mb-3 flex items-center">
                        <i class="fas fa-user-circle mr-2 text-[#27124A]"></i>
                        Informasi Pribadi
                    </h5>
                    <div class="space-y-2">
                        <div class="flex justify-between">
                            <span class="text-gray-500">Nama</span>
                            <span class="font-medium text-gray-800">${member.nama}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-500">Telepon</span>
                            <span class="font-medium text-gray-800">${member.telepon}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-500">Jenis Member</span>
                            <span class="font-medium text-gray-800">${member.jenis_member}</span>
                        </div>
                    </div>
                </div>
                
                <div class="bg-gray-50 rounded-xl p-4 border border-gray-200">
                    <h5 class="font-medium text-gray-700 mb-3 flex items-center">
                        <i class="fas fa-id-card mr-2 text-[#27124A]"></i>
                        Informasi Membership
                    </h5>
                    <div class="space-y-2">
                        <div class="flex justify-between">
                            <span class="text-gray-500">Paket</span>
                            <span class="font-medium text-gray-800">${member.paket}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-500">Tanggal Daftar</span>
                            <span class="font-medium text-gray-800">${member.tgl_daftar}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-500">Tanggal Expired</span>
                            <span class="font-medium ${member.is_active ? 'text-green-600' : 'text-red-600'}">${member.tgl_expired}</span>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="bg-gray-50 rounded-xl p-4 border border-gray-200">
                <h5 class="font-medium text-gray-700 mb-3 flex items-center">
                    <i class="fas fa-info-circle mr-2 text-[#27124A]"></i>
                    Status Member
                </h5>
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="w-3 h-3 rounded-full ${member.status === 'Aktif' ? 'bg-green-500' : (member.status === 'Akan Expired' ? 'bg-yellow-500' : 'bg-red-500')} mr-2"></div>
                        <span class="font-medium ${statusText}">${member.status}</span>
                    </div>
                    <span class="text-sm text-gray-600">
                        Sisa hari: <span class="font-bold">${member.sisa_hari_abs} hari</span>
                    </span>
                </div>
            </div>
        `;
        
        // Show/hide renew button
        if (!member.is_active || member.status === 'Akan Expired') {
            renewFromDetailBtn.classList.remove('hidden');
        } else {
            renewFromDetailBtn.classList.add('hidden');
        }
        
        memberModal.classList.remove('hidden');
        memberModal.style.display = 'flex';
    };

    window.closeMemberModal = function() {
        memberModal.classList.add('hidden');
        memberModal.style.display = 'none';
    };

    // ============ RENEW MODAL ============
    window.openRenewModal = function(member) {
        currentMember = member;
        
        renewMemberInfo.innerHTML = `
            <div class="flex items-start">
                <div class="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center mr-3">
                    <i class="fas fa-user text-[#27124A] text-xl"></i>
                </div>
                <div class="flex-1">
                    <h6 class="font-bold text-gray-800">${member.nama}</h6>
                    <p class="text-sm text-gray-600 mb-2">${member.kode}</p>
                    <div class="bg-white rounded-lg p-2 text-sm">
                        <p><i class="fas fa-calendar-alt mr-2 text-gray-400"></i> Expired: ${member.tgl_expired}</p>
                        <p class="mt-1"><i class="fas fa-clock mr-2 text-gray-400"></i> Status: ${member.status}</p>
                    </div>
                </div>
            </div>
        `;
        
        renewModal.classList.remove('hidden');
        renewModal.style.display = 'flex';
    };

    window.closeRenewModal = function() {
        renewModal.classList.add('hidden');
        renewModal.style.display = 'none';
        document.getElementById('packageError').classList.add('hidden');
    };

    // Process renew
    btnRenew.addEventListener('click', function() {
        const packageId = renewPackageSelect.value;
        
        if (!packageId) {
            document.getElementById('packageError').classList.remove('hidden');
            return;
        }
        
        if (!currentMember) {
            showAlert('error', 'Tidak ada member yang dipilih');
            return;
        }
        
        const selectedPackage = packages.find(p => p.id == packageId);
        
        if (!confirm(`Yakin ingin memperpanjang member ${currentMember.nama} dengan paket ${selectedPackage?.nama_paket}?`)) {
            return;
        }
        
        btnRenew.disabled = true;
        btnRenew.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Memproses...';
        
        fetch(`/kasir/member/${currentMember.id}/perpanjang`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content'),
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                id_paket: packageId
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showAlert('success', data.message);
                closeRenewModal();
                closeMemberModal();
                // Refresh search
                if (searchInput.value.trim()) {
                    searchMember();
                }
            } else {
                showAlert('error', data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showAlert('error', 'Terjadi kesalahan saat memperpanjang member');
        })
        .finally(() => {
            btnRenew.disabled = false;
            btnRenew.innerHTML = '<i class="fas fa-redo mr-2"></i> Perpanjang';
        });
    });

    // ============ REGISTER MODAL ============
    window.showRegisterForm = function() {
        registerModal.classList.remove('hidden');
        registerModal.style.display = 'flex';
    };

    window.closeRegisterModal = function() {
        registerModal.classList.add('hidden');
        registerModal.style.display = 'none';
        document.getElementById('registerForm').reset();
    };

    function processRegister() {
        const nama = document.getElementById('registerNama').value.trim();
        const telepon = document.getElementById('registerTelepon').value.trim();
        const packageId = document.getElementById('registerPackage').value;
        
        if (!nama) {
            showAlert('warning', 'Nama lengkap harus diisi');
            return;
        }
        
        if (!packageId) {
            showAlert('warning', 'Pilih paket membership');
            return;
        }
        
        const selectedPackage = packages.find(p => p.id == packageId);
        
        if (!confirm(`Yakin ingin mendaftarkan member baru:\nNama: ${nama}\nPaket: ${selectedPackage?.nama_paket}`)) {
            return;
        }
        
        const submitBtn = document.querySelector('#registerForm button[type="submit"]');
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Mendaftarkan...';
        
        fetch('/kasir/member/daftar-baru', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content'),
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                nama: nama,
                telepon: telepon,
                id_paket: packageId
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showAlert('success', data.message);
                closeRegisterModal();
                // Set search input to new member's name and search
                searchInput.value = nama;
                searchMember();
            } else {
                showAlert('error', data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showAlert('error', 'Terjadi kesalahan saat mendaftarkan member');
        })
        .finally(() => {
            submitBtn.disabled = false;
            submitBtn.innerHTML = '<i class="fas fa-save mr-2"></i> Daftarkan';
        });
    }

    window.processRegister = processRegister;

    // ============ HELPER FUNCTIONS ============
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

    // ============ EVENT LISTENERS ============
    searchInput.addEventListener('input', function() {
        clearTimeout(debounceTimer);
        if (this.value.trim().length >= 2) {
            debounceTimer = setTimeout(searchMember, 500);
        } else {
            initialStateDiv.classList.remove('hidden');
            noResultsDiv.classList.add('hidden');
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
    
    renewFromDetailBtn.addEventListener('click', function() {
        closeMemberModal();
        openRenewModal(currentMember);
    });
    
    // Close modals when clicking outside
    window.addEventListener('click', function(e) {
        if (e.target === memberModal) closeMemberModal();
        if (e.target === renewModal) closeRenewModal();
        if (e.target === registerModal) closeRegisterModal();
    });

    // Initialize
    fetchPackages();
});
</script>
@endpush