@extends('layouts.admin', ['title' => 'Detail User'])

@section('content')
    <div class="page-section">
        <div class="content-card">
            <h2 class="section-title">Detail User</h2>
            <p class="section-subtitle">
                Informasi lengkap akun yang terdaftar di sistem.
            </p>
        </div>
    </div>

    <div class="page-section">
        <div class="card">
            <div class="detail-grid">
                <div class="detail-item">
                    <div class="detail-label">Nama Lengkap</div>
                    <div class="detail-value">{{ $user->full_name }}</div>
                </div>

                <div class="detail-item">
                    <div class="detail-label">Username</div>
                    <div class="detail-value">{{ $user->username }}</div>
                </div>

                <div class="detail-item">
                    <div class="detail-label">NIP</div>
                    <div class="detail-value">{{ $user->nip }}</div>
                </div>

                <div class="detail-item">
                    <div class="detail-label">Role</div>
                    <div class="detail-value">
                        @if($user->role === 'admin')
                            <span class="badge badge-info">Admin</span>
                        @else
                            <span class="badge badge-success">Petugas</span>
                        @endif
                    </div>
                </div>

                <div class="detail-item">
                    <div class="detail-label">Status Akun</div>
                    <div class="detail-value">
                        @if($user->is_active)
                            <span class="badge badge-success">Aktif</span>
                        @else
                            <span class="badge badge-danger">Tidak Aktif</span>
                        @endif
                    </div>
                </div>

                <div class="detail-item">
                    <div class="detail-label">Dibuat Pada</div>
                    <div class="detail-value">{{ $user->created_at?->translatedFormat('d F Y, H:i') }}</div>
                </div>

                <div class="detail-item">
                    <div class="detail-label">Terakhir Diupdate</div>
                    <div class="detail-value">{{ $user->updated_at?->translatedFormat('d F Y, H:i') }}</div>
                </div>
            </div>

            <div class="toolbar" style="margin-top: 18px;">
                <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-primary">Edit User</a>
                <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Kembali</a>
            </div>
        </div>
    </div>
@endsection