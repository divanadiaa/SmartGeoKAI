@extends('layouts.admin', ['title' => 'Manajemen User'])

@section('content')
    <div class="grid" style="margin-bottom:20px;">
        <div class="stat-card">
            <div class="stat-top">
                <div>
                    <div class="stat-label">Total User</div>
                    <div class="stat-value">{{ $stats['total_users'] }}</div>
                </div>
                <div class="stat-icon icon-blue">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                        <path d="M17 21V19C17 17.3431 15.6569 16 14 16H6C4.34315 16 3 17.3431 3 19V21" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
                        <path d="M10 13C12.2091 13 14 11.2091 14 9C14 6.79086 12.2091 5 10 5C7.79086 5 6 6.79086 6 9C6 11.2091 7.79086 13 10 13Z" stroke="currentColor" stroke-width="1.8"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-top">
                <div>
                    <div class="stat-label">Total Admin</div>
                    <div class="stat-value">{{ $stats['total_admins'] }}</div>
                </div>
                <div class="stat-icon icon-orange">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                        <path d="M12 3L19 7V12C19 16.5 15.8 20.4 12 21C8.2 20.4 5 16.5 5 12V7L12 3Z" stroke="currentColor" stroke-width="1.8" stroke-linejoin="round"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-top">
                <div>
                    <div class="stat-label">Petugas</div>
                    <div class="stat-value">{{ $stats['total_petugas'] }}</div>
                </div>
                <div class="stat-icon icon-green">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                        <path d="M12 21C15.5 17.8 19 14.1 19 10A7 7 0 1 0 5 10C5 14.1 8.5 17.8 12 21Z" stroke="currentColor" stroke-width="1.8" stroke-linejoin="round"/>
                        <circle cx="12" cy="10" r="2.6" stroke="currentColor" stroke-width="1.8"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-top">
                <div>
                    <div class="stat-label">User Aktif</div>
                    <div class="stat-value">{{ $stats['active_users'] }}</div>
                </div>
                <div class="stat-icon icon-blue">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                        <path d="M20 7L10 17L5 12" stroke="currentColor" stroke-width="2.1" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <div class="content-card" id="table-users">
        <h2 class="section-title">Daftar User Sistem</h2>
        <div class="section-subtitle">Kelola akun admin dan petugas lapangan dengan kontrol status aktif/nonaktif.</div>

        <form method="GET" class="form-inline">
            <input type="text" name="search" class="form-control" placeholder="Cari nama / username / NIP" value="{{ request('search') }}">
            <button class="btn btn-primary" type="submit">Filter</button>
            <a href="{{ route('admin.users.create') }}" class="btn btn-success">Tambah User</a>
        </form>

        <table>
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Username</th>
                    <th>NIP</th>
                    <th>Role</th>
                    <th>Status</th>
                    <th style="width: 180px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                    <tr>
                        <td><strong>{{ $user->full_name }}</strong></td>
                        <td>{{ $user->username }}</td>
                        <td>{{ $user->nip }}</td>
                        <td>
                            @if($user->role === 'admin')
                                <span class="badge badge-info">Admin</span>
                            @else
                                <span class="badge badge-success">Petugas</span>
                            @endif
                        </td>
                        <td>
                            @if($user->is_active)
                                <span class="badge badge-success">Aktif</span>
                            @else
                                <span class="badge badge-danger">Tidak Aktif</span>
                            @endif
                        </td>
                        <td>
                            <div style="display:flex; gap:8px; align-items:center;">
                                <a href="{{ route('admin.users.show', $user) }}" class="icon-action icon-view" title="Lihat">
                                    <i class="fas fa-eye"></i>
                                </a>

                                <a href="{{ route('admin.users.edit', $user) }}" class="icon-action icon-edit" title="Edit">
                                    <i class="fas fa-pen"></i>
                                </a>

                                <form action="{{ route('admin.users.toggle-active', $user) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('PATCH')
                                    <button class="icon-action {{ $user->is_active ? 'icon-warning' : 'icon-success' }}" type="submit" title="{{ $user->is_active ? 'Nonaktifkan' : 'Aktifkan' }}">
                                        @if($user->is_active)
                                            <i class="fas fa-user-slash"></i>
                                        @else
                                            <i class="fas fa-user-check"></i>
                                        @endif
                                    </button>
                                </form>

                                <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="delete-form" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button class="icon-action icon-delete" type="submit" title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6">Belum ada user.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div style="margin-top: 16px;">
            {{ $users->withQueryString()->fragment('table-users')->links() }}
        </div>
    </div>
@endsection