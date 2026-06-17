@extends('layouts.admin-auth', ['title' => 'Login Admin SmartGeoKAI'])

@section('content')
    <div class="auth-header">
        <div class="auth-icon-wrap">
            <svg width="34" height="34" viewBox="0 0 24 24" fill="none">
                <path d="M12 12C14.7614 12 17 9.76142 17 7C17 4.23858 14.7614 2 12 2C9.23858 2 7 4.23858 7 7C7 9.76142 9.23858 12 12 12Z" stroke="#0D47A1" stroke-width="1.8"/>
                <path d="M4 21C4 17.6863 7.58172 15 12 15C16.4183 15 20 17.6863 20 21" stroke="#2E7D32" stroke-width="1.8" stroke-linecap="round"/>
            </svg>
        </div>

        <h1 class="auth-title">Login Admin</h1>

        <div class="auth-subtitle">
            Masuk ke dashboard SmartGeoKAI untuk mengelola aset, petugas, dan laporan operasional.
        </div>
    </div>

    @if(session('success'))
        <div class="alert-success">{{ session('success') }}</div>
    @endif

    @if($errors->any())
        <div class="alert-error">
            <ul class="error-list">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.login.store') }}" method="POST">
        @csrf

        <div class="form-group">
            <label class="form-label">Username</label>

            <div class="input-wrap">
                <span class="input-icon">
                    <svg viewBox="0 0 24 24" fill="none">
                        <path d="M12 12C14.2091 12 16 10.2091 16 8C16 5.79086 14.2091 4 12 4C9.79086 4 8 5.79086 8 8C8 10.2091 9.79086 12 12 12Z" stroke="currentColor" stroke-width="1.8"/>
                        <path d="M5 20C5 16.6863 8.13401 14 12 14C15.866 14 19 16.6863 19 20" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
                    </svg>
                </span>

                <input type="text" name="username" class="form-control" placeholder="Masukkan username admin" value="{{ old('username') }}">
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

                <input type="password" id="password" name="password" class="form-control" placeholder="Masukkan password" style="padding-right:50px;">

                <button type="button" onclick="togglePassword()" style="position:absolute;right:14px;top:50%;transform:translateY(-50%);border:none;background:none;cursor:pointer;color:#6f7f90;font-size:16px;">
                </button>
            </div>
        </div>

        <button type="submit" class="btn-primary">Masuk ke Dashboard</button>
    </form>

    <div class="auth-note">
        Akses ini hanya ditujukan untuk administrator sistem.
    </div>

    <script>
        function togglePassword() {
            const password = document.getElementById('password');
            password.type = password.type === 'password' ? 'text' : 'password';
        }
    </script>
@endsection