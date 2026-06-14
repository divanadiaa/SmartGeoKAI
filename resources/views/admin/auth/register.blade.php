@extends('layouts.admin-auth', ['title' => 'Register Admin SmartGeoKAI'])

@section('content')
    <div class="auth-header">
        <div class="auth-icon-wrap">
            <svg width="34" height="34" viewBox="0 0 24 24" fill="none">
                <path d="M12 12C14.7614 12 17 9.76142 17 7C17 4.23858 14.7614 2 12 2C9.23858 2 7 4.23858 7 7C7 9.76142 9.23858 12 12 12Z" stroke="#0D47A1" stroke-width="1.8"/>
                <path d="M20 21V18" stroke="#2E7D32" stroke-width="1.8" stroke-linecap="round"/>
                <path d="M18.5 19.5H21.5" stroke="#2E7D32" stroke-width="1.8" stroke-linecap="round"/>
                <path d="M4 21C4 17.6863 7.58172 15 12 15C13.4404 15 14.792 15.2855 15.9811 15.7858" stroke="#0D47A1" stroke-width="1.8" stroke-linecap="round"/>
            </svg>
        </div>

        <h1 class="auth-title">Register Admin</h1>
        <div class="auth-subtitle">
            Buat akun administrator untuk akses pengelolaan sistem SmartGeoKAI.
        </div>
    </div>

    @if($errors->any())
        <div class="alert-error">
            <ul class="error-list">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.register.store') }}" method="POST">
        @csrf

        <div class="form-group">
            <label class="form-label">Nama Lengkap</label>
            <div class="input-wrap">
                <span class="input-icon">
                    <svg viewBox="0 0 24 24" fill="none">
                        <path d="M12 12C14.2091 12 16 10.2091 16 8C16 5.79086 14.2091 4 12 4C9.79086 4 8 5.79086 8 8C8 10.2091 9.79086 12 12 12Z" stroke="currentColor" stroke-width="1.8"/>
                        <path d="M5 20C5 16.6863 8.13401 14 12 14C15.866 14 19 16.6863 19 20" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
                    </svg>
                </span>
                <input type="text" name="full_name" class="form-control" placeholder="Masukkan nama lengkap" value="{{ old('full_name') }}">
            </div>
        </div>

        <div class="form-group">
            <label class="form-label">Username</label>
            <div class="input-wrap">
                <span class="input-icon">
                    <svg viewBox="0 0 24 24" fill="none">
                        <path d="M4 7.5C4 6.11929 5.11929 5 6.5 5H17.5C18.8807 5 20 6.11929 20 7.5V16.5C20 17.8807 18.8807 19 17.5 19H6.5C5.11929 19 4 17.8807 4 16.5V7.5Z" stroke="currentColor" stroke-width="1.8"/>
                        <path d="M8 9H16" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
                        <path d="M8 13H13" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
                    </svg>
                </span>
                <input type="text" name="username" class="form-control" placeholder="Masukkan username" value="{{ old('username') }}">
            </div>
        </div>

        <div class="form-group">
            <label class="form-label">NIP</label>
            <div class="input-wrap">
                <span class="input-icon">
                    <svg viewBox="0 0 24 24" fill="none">
                        <rect x="5" y="4" width="14" height="16" rx="2" stroke="currentColor" stroke-width="1.8"/>
                        <path d="M8 8H16" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
                        <path d="M8 12H16" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
                    </svg>
                </span>
                <input type="text" name="nip" class="form-control" placeholder="Masukkan NIP" value="{{ old('nip') }}">
            </div>
        </div>

        <div class="form-group">
            <label class="form-label">Password</label>
            <div class="input-wrap">
                <span class="input-icon">
                    <svg viewBox="0 0 24 24" fill="none">
                        <rect x="5" y="11" width="14" height="9" rx="2" stroke="currentColor" stroke-width="1.8"/>
                        <path d="M8 11V8.5C8 6.01472 9.79086 4 12 4C14.2091 4 16 6.01472 16 8.5V11" stroke="currentColor" stroke-width="1.8"/>
                    </svg>
                </span>
                <input type="password" name="password" class="form-control" placeholder="Masukkan password">
            </div>
        </div>

        <div class="form-group">
            <label class="form-label">Konfirmasi Password</label>
            <div class="input-wrap">
                <span class="input-icon">
                    <svg viewBox="0 0 24 24" fill="none">
                        <path d="M20 6L9 17L4 12" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </span>
                <input type="password" name="password_confirmation" class="form-control" placeholder="Masukkan ulang password">
            </div>
        </div>

        <button type="submit" class="btn-primary">Buat Akun Admin</button>
    </form>

    <div class="auth-link">
        Sudah punya akun?
        <a href="{{ route('admin.login') }}">Login sekarang</a>
    </div>
@endsection