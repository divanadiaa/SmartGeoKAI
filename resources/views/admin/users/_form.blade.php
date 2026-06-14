<div class="card">
    <div class="form-grid">

        {{-- FULL NAME --}}
        <div class="form-group">
            <label class="form-label">Nama Lengkap</label>
            <input
                type="text"
                name="full_name"
                class="form-control-full @error('full_name') is-invalid @enderror"
                value="{{ old('full_name', $user->full_name ?? '') }}"
                placeholder="Masukkan nama lengkap">

            @error('full_name')
                    <small class="form-error-text">{{ $message }}</small>
            @enderror
        </div>

        {{-- USERNAME --}}
        <div class="form-group">
            <label class="form-label">Username</label>
            <input
                type="text"
                name="username"
                class="form-control-full @error('username') is-invalid @enderror"
                value="{{ old('username', $user->username ?? '') }}"
                placeholder="Masukkan username">

            @error('username')
                    <small class="form-error-text">{{ $message }}</small>
            @enderror
        </div>

        {{-- NIP --}}
        <div class="form-group">
            <label class="form-label">NIP</label>
            <input
                type="text"
                name="nip"
                class="form-control-full @error('nip') is-invalid @enderror"
                value="{{ old('nip', $user->nip ?? '') }}"
                placeholder="Masukkan NIP">

            @error('nip')
                    <small class="form-error-text">{{ $message }}</small>
            @enderror
        </div>

        {{-- ROLE --}}
        <div class="form-group">
            <label class="form-label">Role</label>
            <select name="role" class="form-control-full @error('role') is-invalid @enderror">
                <option value="">Pilih role</option>
                <option value="admin" {{ old('role', $user->role ?? '') == 'admin' ? 'selected' : '' }}>Admin</option>
                <option value="petugas" {{ old('role', $user->role ?? '') == 'petugas' ? 'selected' : '' }}>Petugas</option>
            </select>

            @error('role')
                    <small class="form-error-text">{{ $message }}</small>
            @enderror
        </div>

        {{-- STATUS --}}
        <div class="form-group">
            <label class="form-label">Status Akun</label>
            <select name="is_active" class="form-control-full">
                <option value="1" {{ (string) old('is_active', isset($user) ? (int) $user->is_active : 1) === '1' ? 'selected' : '' }}>Aktif</option>
                <option value="0" {{ (string) old('is_active', isset($user) ? (int) $user->is_active : 1) === '0' ? 'selected' : '' }}>Tidak Aktif</option>
            </select>
        </div>

        {{-- PASSWORD --}}
        <div class="form-group">
            <label class="form-label">
                Password {{ isset($user) ? '(opsional)' : '' }}
            </label>
            <input
                type="password"
                name="password"
                class="form-control-full @error('password') is-invalid @enderror"
                placeholder="{{ isset($user) ? 'Kosongkan jika tidak ingin diubah' : 'Masukkan password' }}">

            @error('password')
                    <small class="form-error-text">{{ $message }}</small>
            @enderror
        </div>

        {{-- CONFIRM PASSWORD --}}
        <div class="form-group">
            <label class="form-label">Konfirmasi Password</label>
            <input
                type="password"
                name="password_confirmation"
                class="form-control-full"
                placeholder="Masukkan konfirmasi password">
        </div>

    </div>

    <div class="toolbar" style="margin-top: 18px;">
        <button type="submit" class="btn btn-primary">{{ $buttonLabel }}</button>
        <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Kembali</a>
    </div>
</div>