@extends('layouts.app')

@section('title', 'Dashboard Kasir')
@section('page-title', 'Dashboard Kasir')

@section('sidebar')
@include('kasir.partials.sidebar')
@endsection

@section('content')
<div class="space-y-6">
    <div class="bg-gradient-to-r from-[#27124A] to-[#3a1d6b] rounded-2xl shadow-lg overflow-hidden">
        <div class="p-6 md:p-8">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-xl md:text-2xl font-bold text-white mb-2">
                        Selamat Bekerja, {{ Auth::user()->nama }}! 👋
                    </h2>
                    <p class="text-purple-200 text-sm md:text-base">
                        Anda login sebagai <span class="font-semibold text-white">Kasir</span>
                    </p>
                    <div class="flex items-center mt-3 text-purple-200 text-xs md:text-sm">
                        <i class="fas fa-calendar-alt mr-2"></i>
                        <span>{{ now()->translatedFormat('l, d F Y - H:i') }}</span>
                    </div>
                </div>
                <div class="hidden md:block">
                    <div class="w-20 h-20 bg-white/10 rounded-2xl flex items-center justify-center">
                        <i class="fas fa-smile-wink text-white text-3xl"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs text-gray-500 uppercase tracking-wider">Transaksi Hari Ini</p>
                    <p class="text-2xl font-bold text-gray-800 mt-1">{{ $stats['today_transactions'] }}</p>
                </div>
                <div class="w-10 h-10 bg-blue-50 rounded-lg flex items-center justify-center">
                    <i class="fas fa-cash-register text-[#27124A] text-lg"></i>
                </div>
            </div>
            <div class="mt-3 text-xs text-gray-500">
                <i class="fas fa-circle text-blue-500 text-[8px] mr-1"></i> Rp {{ number_format($stats['today_revenue'], 0, ',', '.') }}
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs text-gray-500 uppercase tracking-wider">Check-in Hari Ini</p>
                    <p class="text-2xl font-bold text-gray-800 mt-1">{{ $stats['today_checkins'] }}</p>
                </div>
                <div class="w-10 h-10 bg-green-50 rounded-lg flex items-center justify-center">
                    <i class="fas fa-user-check text-[#27124A] text-lg"></i>
                </div>
            </div>
            <div class="mt-3 text-xs text-gray-500">
                <i class="fas fa-circle text-green-500 text-[8px] mr-1"></i> Member masuk
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs text-gray-500 uppercase tracking-wider">Member Aktif</p>
                    <p class="text-2xl font-bold text-gray-800 mt-1">{{ $stats['total_members'] ?? '0' }}</p>
                </div>
                <div class="w-10 h-10 bg-purple-50 rounded-lg flex items-center justify-center">
                    <i class="fas fa-users text-[#27124A] text-lg"></i>
                </div>
            </div>
            <div class="mt-3 text-xs text-gray-500">
                <i class="fas fa-circle text-purple-500 text-[8px] mr-1"></i> Total member aktif
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="p-4 border-b border-gray-100 flex justify-between items-center">
                <div>
                    <h3 class="text-sm font-semibold text-gray-800">Transaksi Hari Ini</h3>
                    <p class="text-xs text-gray-500 mt-0.5">Daftar transaksi terkini</p>
                </div>
                <a href="{{ route('kasir.transaksi.index') }}" class="text-xs text-[#27124A] hover:underline">
                    Lihat Semua <i class="fas fa-arrow-right ml-1"></i>
                </a>
            </div>
            
            <div class="divide-y divide-gray-100">
                @forelse($todayTransactions->take(5) as $transaction)
                <div class="p-3 hover:bg-gray-50 transition-colors">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="w-7 h-7 bg-purple-50 rounded-lg flex items-center justify-center mr-2">
                                <i class="fas fa-receipt text-[#27124A] text-xs"></i>
                            </div>
                            <div>
                                <p class="text-xs font-medium text-gray-800">{{ $transaction->nomor_unik }}</p>
                                <p class="text-xs text-gray-400">{{ $transaction->member->nama ?? 'Non-member' }}</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="text-xs font-medium text-[#27124A]">Rp {{ number_format($transaction->total_harga, 0, ',', '.') }}</p>
                            <p class="text-xs text-gray-400">{{ $transaction->created_at->format('H:i') }}</p>
                        </div>
                    </div>
                </div>
                @empty
                <div class="p-6 text-center">
                    <i class="fas fa-shopping-cart text-2xl text-gray-300 mb-2"></i>
                    <p class="text-xs text-gray-400 mb-3">Belum ada transaksi hari ini</p>
                    <a href="{{ route('kasir.transaksi.create') }}" 
                       class="inline-flex items-center px-3 py-1.5 bg-[#27124A] text-white text-xs rounded-lg hover:bg-[#3a1d6b] transition-colors">
                        <i class="fas fa-plus mr-1"></i> Transaksi Baru
                    </a>
                </div>
                @endforelse
            </div>
        </div>
        
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="p-4 border-b border-gray-100 flex justify-between items-center">
                <div>
                    <h3 class="text-sm font-semibold text-gray-800">Check-in Hari Ini</h3>
                    <p class="text-xs text-gray-500 mt-0.5">Member yang check-in</p>
                </div>
                <a href="{{ route('kasir.checkin.riwayat') }}" class="text-xs text-[#27124A] hover:underline">
                    Lihat Semua <i class="fas fa-arrow-right ml-1"></i>
                </a>
            </div>
            
            <div class="divide-y divide-gray-100">
                @forelse($todayCheckins->take(5) as $checkin)
                <div class="p-3 hover:bg-gray-50 transition-colors">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="w-7 h-7 bg-green-50 rounded-lg flex items-center justify-center mr-2">
                                <i class="fas fa-user-circle text-[#27124A] text-xs"></i>
                            </div>
                            <div>
                                <p class="text-xs font-medium text-gray-800">{{ $checkin->member->nama }}</p>
                                <p class="text-xs text-gray-400">{{ $checkin->member->kode_member }}</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="text-xs font-medium text-green-600">{{ $checkin->jam_masuk }}</p>
                            <p class="text-xs text-gray-400">Check-in</p>
                        </div>
                    </div>
                </div>
                @empty
                <div class="p-6 text-center">
                    <i class="fas fa-user-check text-2xl text-gray-300 mb-2"></i>
                    <p class="text-xs text-gray-400 mb-3">Belum ada check-in hari ini</p>
                    <a href="{{ route('kasir.checkin.index') }}" 
                       class="inline-flex items-center px-3 py-1.5 bg-[#27124A] text-white text-xs rounded-lg hover:bg-[#3a1d6b] transition-colors">
                        <i class="fas fa-check-circle mr-1"></i> Check-in Member
                    </a>
                </div>
                @endforelse
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-4 border-b border-gray-100">
            <h3 class="text-sm font-semibold text-gray-800">Aksi Cepat</h3>
        </div>
        
        <div class="p-4 grid grid-cols-1 sm:grid-cols-3 gap-3">
            <a href="{{ route('kasir.transaksi.create') }}" 
               class="flex items-center p-3 bg-blue-50 hover:bg-blue-100 rounded-lg transition-colors">
                <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center mr-3">
                    <i class="fas fa-cash-register text-[#27124A] text-sm"></i>
                </div>
                <div>
                    <p class="text-xs font-medium text-gray-800">Transaksi Baru</p>
                    <p class="text-xs text-gray-500">Buat transaksi</p>
                </div>
            </a>
            
            <a href="{{ route('kasir.member.cek') }}" 
               class="flex items-center p-3 bg-green-50 hover:bg-green-100 rounded-lg transition-colors">
                <div class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center mr-3">
                    <i class="fas fa-search text-[#27124A] text-sm"></i>
                </div>
                <div>
                    <p class="text-xs font-medium text-gray-800">Cek Member</p>
                    <p class="text-xs text-gray-500">Status keanggotaan</p>
                </div>
            </a>
            
            <a href="{{ route('kasir.checkin.index') }}" 
               class="flex items-center p-3 bg-purple-50 hover:bg-purple-100 rounded-lg transition-colors">
                <div class="w-8 h-8 bg-purple-100 rounded-lg flex items-center justify-center mr-3">
                    <i class="fas fa-check-circle text-[#27124A] text-sm"></i>
                </div>
                <div>
                    <p class="text-xs font-medium text-gray-800">Check-in</p>
                    <p class="text-xs text-gray-500">Catat kedatangan</p>
                </div>
            </a>
        </div>
    </div>
</div>
@endsection