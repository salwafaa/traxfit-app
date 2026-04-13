@extends('layouts.app')

@section('title', 'Edit User')
@section('page-title', 'Edit User')

@section('sidebar')
@include('owner.partials.sidebar')
@endsection

@section('content')
<div class="bg-white rounded-xl shadow-lg border border-gray-200 overflow-hidden mb-6">
    <div class="px-6 py-5 bg-[#27124A]">
        <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-4">
            <div class="flex items-center">
                <div class="bg-white bg-opacity-20 p-3 rounded-xl">
                    <i class="fas fa-user-edit text-white text-xl"></i>
                </div>
                <div class="ml-4">
                    <h3 class="text-lg font-bold text-white">Edit User</h3>
                    <p class="text-sm text-white text-opacity-90">Perbarui informasi user sistem</p>
                </div>
            </div>
            <div class="bg-white bg-opacity-10 px-4 py-2 rounded-lg border border-white border-opacity-20">
                <div class="text-xs text-white text-opacity-80">ID User</div>
                <div class="font-mono font-bold text-white">{{ $user->id }}</div>
            </div>
        </div>
    </div>
</div>

<div class="bg-white rounded-xl shadow-lg border border-gray-200 overflow-hidden mb-8">
    <div class="p-8">
        <form action="{{ route('owner.users.update', $user->id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="space-y-2">
                    <label class="block text-sm font-semibold text-gray-700" for="username">
                        Username <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <div class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400">
                            <i class="fas fa-user"></i>
                        </div>
                        <input type="text" name="username" id="username" required
                               value="{{ old('username', $user->username) }}"
                               class="w-full px-4 py-3 pl-10 border-2 border-gray-200 rounded-xl focus:outline-none focus:border-[#27124A] focus:ring-2 focus:ring-[#27124A]/20 transition-all duration-300">
                    </div>
                    @error('username')
                        <div class="text-sm text-red-600 bg-red-50 p-3 rounded-lg border border-red-200 mt-2">
                            <i class="fas fa-exclamation-circle mr-2"></i>{{ $message }}
                        </div>
                    @enderror
                </div>
                
                <div class="space-y-2">
                    <label class="block text-sm font-semibold text-gray-700" for="password">
                        Password
                    </label>
                    <div class="relative">
                        <div class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400">
                            <i class="fas fa-lock"></i>
                        </div>
                        <input type="password" name="password" id="password"
                               class="w-full px-4 py-3 pl-10 border-2 border-gray-200 rounded-xl focus:outline-none focus:border-[#27124A] focus:ring-2 focus:ring-[#27124A]/20 transition-all duration-300"
                               placeholder="Kosongkan jika tidak diubah">
                    </div>
                    <div class="text-xs text-gray-500">
                        <i class="fas fa-info-circle text-[#27124A] mr-1"></i>
                        Kosongkan jika tidak ingin mengubah password (minimal 6 karakter jika diisi)
                    </div>
                    @error('password')
                        <div class="text-sm text-red-600 bg-red-50 p-3 rounded-lg border border-red-200 mt-2">
                            <i class="fas fa-exclamation-circle mr-2"></i>{{ $message }}
                        </div>
                    @enderror
                </div>
                
                <div class="space-y-2">
                    <label class="block text-sm font-semibold text-gray-700" for="nama">
                        Nama Lengkap <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <div class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400">
                            <i class="fas fa-id-card"></i>
                        </div>
                        <input type="text" name="nama" id="nama" required
                               value="{{ old('nama', $user->nama) }}"
                               class="w-full px-4 py-3 pl-10 border-2 border-gray-200 rounded-xl focus:outline-none focus:border-[#27124A] focus:ring-2 focus:ring-[#27124A]/20 transition-all duration-300">
                    </div>
                    @error('nama')
                        <div class="text-sm text-red-600 bg-red-50 p-3 rounded-lg border border-red-200 mt-2">
                            <i class="fas fa-exclamation-circle mr-2"></i>{{ $message }}
                        </div>
                    @enderror
                </div>
                
                <div class="space-y-2">
                    <label class="block text-sm font-semibold text-gray-700" for="role">
                        Role <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <div class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400">
                            <i class="fas fa-user-tag"></i>
                        </div>
                        <select name="role" id="role" required
                                class="w-full px-4 py-3 pl-10 border-2 border-gray-200 rounded-xl focus:outline-none focus:border-[#27124A] focus:ring-2 focus:ring-[#27124A]/20 transition-all duration-300 appearance-none">
                            <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Admin</option>
                            <option value="kasir" {{ old('role', $user->role) == 'kasir' ? 'selected' : '' }}>Kasir</option>
                        </select>
                        <div class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 pointer-events-none">
                            <i class="fas fa-chevron-down"></i>
                        </div>
                    </div>
                    <div class="text-xs text-gray-500">
                        <i class="fas fa-info-circle text-[#27124A] mr-1"></i>
                        Admin memiliki akses penuh, Kasir hanya untuk transaksi
                    </div>
                    @error('role')
                        <div class="text-sm text-red-600 bg-red-50 p-3 rounded-lg border border-red-200 mt-2">
                            <i class="fas fa-exclamation-circle mr-2"></i>{{ $message }}
                        </div>
                    @enderror
                </div>
                
                <div class="md:col-span-2">
                    <div class="flex items-center p-5 bg-gray-50 rounded-xl border-2 border-gray-200 hover:border-[#27124A] transition-all duration-300">
                        <div class="relative">
                            <input type="checkbox" name="status" id="status" value="1" 
                                   {{ old('status', $user->status) ? 'checked' : '' }}
                                   class="sr-only peer">
                            <div class="w-11 h-6 bg-gray-200 rounded-full peer peer-checked:after:translate-x-full after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-[#27124A]"></div>
                        </div>
                        <label for="status" class="ml-3 block text-gray-700 font-medium cursor-pointer">
                            User Aktif
                        </label>
                    </div>
                </div>
            </div>
            
            <div class="mt-10 pt-8 border-t border-gray-200">
                <div class="flex justify-end space-x-4">
                    <a href="{{ route('owner.users.index') }}" 
                       class="px-6 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold rounded-xl transition-all duration-300 border border-gray-300">
                        <i class="fas fa-times mr-2"></i> Batal
                    </a>
                    <button type="submit"
                            class="px-6 py-3 bg-[#27124A] hover:bg-[#3A1B6E] text-white font-semibold rounded-xl transition-all duration-300 transform hover:-translate-y-1 shadow-md hover:shadow-lg">
                        <i class="fas fa-save mr-2"></i> Update User
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection