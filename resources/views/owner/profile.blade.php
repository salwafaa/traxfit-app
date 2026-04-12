@extends('layouts.app')

@section('title', 'Profil Saya')
@section('page-title', 'Profil Saya')

@section('sidebar')
    @include('owner.partials.sidebar')
@endsection

@section('content')
<div class="max-w-2xl mx-auto">

    {{-- Card Header: Avatar & Info --}}
    <div style="background: #27124A; border-radius: 16px 16px 0 0; padding: 2rem 2rem 1.5rem;">
        <div class="flex items-center gap-4">
            <div style="width:60px; height:60px; border-radius:50%; background: linear-gradient(135deg,#6D28D9,#8B5CF6); display:flex; align-items:center; justify-content:center; border: 2.5px solid rgba(255,255,255,0.2); flex-shrink:0;">
                <i class="fas fa-user" style="color:#fff; font-size:22px;"></i>
            </div>
            <div>
                <h2 style="color:#fff; font-size:18px; font-weight:600;">{{ $user->nama }}</h2>
                <span style="display:inline-flex; align-items:center; gap:5px; background:rgba(139,92,246,0.25); color:#C4B5FD; font-size:11px; font-weight:500; padding:3px 12px; border-radius:99px; margin-top:5px; border: 0.5px solid rgba(139,92,246,0.35);">
                    <i class="fas fa-crown" style="font-size:9px;"></i>
                    {{ ucfirst($user->role) }}
                </span>
            </div>
        </div>
        @if($user->last_login)
        <div style="margin-top:1rem; font-size:12px; color:rgba(196,181,253,0.65); display:flex; align-items:center; gap:6px;">
            <i class="far fa-clock" style="font-size:11px;"></i>
            Login terakhir: {{ $user->last_login->format('d M Y, H:i') }} WIB
        </div>
        @endif
    </div>

    {{-- Card Body --}}
    <div style="background:#fff; border-radius:0 0 16px 16px; border:0.5px solid #DDD6FE; border-top:none; padding:1.75rem 2rem 2rem;">

        {{-- Alert sukses --}}
        @if(session('success'))
        <div style="display:flex; align-items:center; gap:10px; background:#F0FDF4; border:0.5px solid #BBF7D0; color:#166534; border-radius:10px; padding:10px 14px; font-size:13px; margin-bottom:1.25rem;">
            <i class="fas fa-check-circle" style="color:#16A34A; font-size:15px; flex-shrink:0;"></i>
            {{ session('success') }}
        </div>
        @endif

        {{-- Alert error --}}
        @if(session('error'))
        <div style="display:flex; align-items:center; gap:10px; background:#FEF2F2; border:0.5px solid #FECACA; color:#991B1B; border-radius:10px; padding:10px 14px; font-size:13px; margin-bottom:1.25rem;">
            <i class="fas fa-exclamation-circle" style="color:#DC2626; font-size:15px; flex-shrink:0;"></i>
            {{ session('error') }}
        </div>
        @endif

        <form method="POST" action="{{ route('owner.profile.update') }}">
            @csrf
            @method('PUT')

            {{-- Informasi Akun --}}
            <div style="background:#F5F3FF; border-radius:12px; padding:1.25rem 1.5rem; margin-bottom:1.25rem; border:0.5px solid #DDD6FE;">
                <div style="font-size:11px; font-weight:600; text-transform:uppercase; letter-spacing:0.06em; color:#6D28D9; display:flex; align-items:center; gap:7px; margin-bottom:1rem;">
                    <i class="fas fa-id-card" style="font-size:12px;"></i>
                    Informasi Akun
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label style="display:block; font-size:12px; font-weight:500; color:#6D28D9; margin-bottom:5px;">
                            Nama Lengkap <span style="color:#A855F7;">*</span>
                        </label>
                        <input type="text" name="nama" value="{{ old('nama', $user->nama) }}"
                            placeholder="Masukkan nama lengkap"
                            class="profile-input @error('nama') border-red-400 @enderror">
                        @error('nama')
                            <p style="font-size:11px; color:#DC2626; margin-top:4px;">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label style="display:block; font-size:12px; font-weight:500; color:#6D28D9; margin-bottom:5px;">
                            Username <span style="color:#A855F7;">*</span>
                        </label>
                        <input type="text" name="username" value="{{ old('username', $user->username) }}"
                            placeholder="Masukkan username"
                            class="profile-input @error('username') border-red-400 @enderror">
                        @error('username')
                            <p style="font-size:11px; color:#DC2626; margin-top:4px;">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            {{-- Ganti Password --}}
            <div style="background:#F5F3FF; border-radius:12px; padding:1.25rem 1.5rem; margin-bottom:1.25rem; border:0.5px solid #DDD6FE;">
                <div style="font-size:11px; font-weight:600; text-transform:uppercase; letter-spacing:0.06em; color:#6D28D9; display:flex; align-items:center; gap:7px; margin-bottom:4px;">
                    <i class="fas fa-lock" style="font-size:12px;"></i>
                    Ganti Password
                </div>
                <p style="font-size:11px; color:#A78BFA; margin-bottom:1rem;">Kosongkan jika tidak ingin mengganti password.</p>

                <div style="margin-bottom:1rem;">
                    <label style="display:block; font-size:12px; font-weight:500; color:#6D28D9; margin-bottom:5px;">Password Saat Ini</label>
                    <div style="position:relative;">
                        <input type="password" name="current_password" id="pw_current"
                            placeholder="Masukkan password saat ini"
                            class="profile-input profile-input-pw @error('current_password') border-red-400 @enderror">
                        <button type="button" onclick="togglePw('pw_current',this)" class="pw-eye-btn">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                    @error('current_password')
                        <p style="font-size:11px; color:#DC2626; margin-top:4px;">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label style="display:block; font-size:12px; font-weight:500; color:#6D28D9; margin-bottom:5px;">Password Baru</label>
                        <div style="position:relative;">
                            <input type="password" name="password" id="pw_new"
                                placeholder="Min. 6 karakter"
                                class="profile-input profile-input-pw @error('password') border-red-400 @enderror">
                            <button type="button" onclick="togglePw('pw_new',this)" class="pw-eye-btn">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                        @error('password')
                            <p style="font-size:11px; color:#DC2626; margin-top:4px;">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label style="display:block; font-size:12px; font-weight:500; color:#6D28D9; margin-bottom:5px;">Konfirmasi Password</label>
                        <div style="position:relative;">
                            <input type="password" name="password_confirmation" id="pw_confirm"
                                placeholder="Ulangi password baru"
                                class="profile-input profile-input-pw">
                            <button type="button" onclick="togglePw('pw_confirm',this)" class="pw-eye-btn">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Tombol Aksi --}}
            <div class="flex gap-3 mt-6">
                <button type="submit" class="profile-btn-save">
                    <i class="fas fa-save" style="font-size:14px;"></i>
                    Simpan Perubahan
                </button>
                <a href="{{ route('owner.dashboard') }}" class="profile-btn-cancel">
                    Batal
                </a>
            </div>

        </form>
    </div>

</div>

<style>
    .profile-input {
        width: 100%;
        height: 40px;
        padding: 0 12px;
        background: #fff;
        border: 1px solid #DDD6FE;
        border-radius: 8px;
        font-size: 14px;
        color: #27124A;
        outline: none;
        transition: border-color .15s, box-shadow .15s;
    }
    .profile-input:focus {
        border-color: #8B5CF6;
        box-shadow: 0 0 0 3px rgba(139,92,246,0.15);
    }
    .profile-input-pw {
        padding-right: 38px;
    }
    .pw-eye-btn {
        position: absolute;
        right: 10px;
        top: 50%;
        transform: translateY(-50%);
        background: none;
        border: none;
        cursor: pointer;
        color: #A78BFA;
        padding: 0;
        line-height: 1;
        font-size: 14px;
    }
    .pw-eye-btn:hover {
        color: #6D28D9;
    }
    .profile-btn-save {
        flex: 1;
        height: 42px;
        background: #27124A;
        color: #fff;
        border: none;
        border-radius: 10px;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 7px;
        transition: background .15s;
    }
    .profile-btn-save:hover {
        background: #3A1B6E;
    }
    .profile-btn-cancel {
        height: 42px;
        padding: 0 20px;
        background: #fff;
        color: #6D28D9;
        border: 1px solid #DDD6FE;
        border-radius: 10px;
        font-size: 14px;
        font-weight: 500;
        display: flex;
        align-items: center;
        text-decoration: none;
        transition: background .15s;
    }
    .profile-btn-cancel:hover {
        background: #F5F3FF;
    }
</style>
@endsection

@section('scripts')
<script>
    function togglePw(id, btn) {
        const inp = document.getElementById(id);
        const icon = btn.querySelector('i');
        if (inp.type === 'password') {
            inp.type = 'text';
            icon.classList.replace('fa-eye', 'fa-eye-slash');
        } else {
            inp.type = 'password';
            icon.classList.replace('fa-eye-slash', 'fa-eye');
        }
    }
</script>
@endsection