@extends('layouts.admin', ['title' => 'Dashboard'])

@section('content')
    @php
        $clearPercent = $totalAssets > 0 ? round(($clearAssets / $totalAssets) * 100) : 0;
        $prosesPercent = $totalAssets > 0 ? round(($prosesAssets / $totalAssets) * 100) : 0;
        $masalahPercent = $totalAssets > 0 ? round(($masalahAssets / $totalAssets) * 100) : 0;
    @endphp

    <div class="page-section">
        <div class="grid">
            <div class="stat-card">
                <div class="stat-top">
                    <div>
                        <div class="stat-label">Total Aset</div>
                        <div class="stat-value">{{ $totalAssets }}</div>
                    </div>
                    <div class="stat-icon icon-blue">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                            <path d="M4 7.5L12 4L20 7.5L12 11L4 7.5Z" stroke="currentColor" stroke-width="1.8" stroke-linejoin="round"/>
                            <path d="M4 12L12 15.5L20 12" stroke="currentColor" stroke-width="1.8" stroke-linejoin="round"/>
                            <path d="M4 16.5L12 20L20 16.5" stroke="currentColor" stroke-width="1.8" stroke-linejoin="round"/>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-top">
                    <div>
                        <div class="stat-label">Aset Clear</div>
                        <div class="stat-value">{{ $clearAssets }}</div>
                    </div>
                    <div class="stat-icon icon-green">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                            <path d="M20 7L10 17L5 12" stroke="currentColor" stroke-width="2.1" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-top">
                    <div>
                        <div class="stat-label">Aset Proses</div>
                        <div class="stat-value">{{ $prosesAssets }}</div>
                    </div>
                    <div class="stat-icon icon-orange">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                            <path d="M12 6V12L16 14" stroke="currentColor" stroke-width="2.1" stroke-linecap="round" stroke-linejoin="round"/>
                            <circle cx="12" cy="12" r="8" stroke="currentColor" stroke-width="1.8"/>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-top">
                    <div>
                        <div class="stat-label">Aset Masalah</div>
                        <div class="stat-value">{{ $masalahAssets }}</div>
                    </div>
                    <div class="stat-icon icon-red">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                            <path d="M12 8V12" stroke="currentColor" stroke-width="2.1" stroke-linecap="round"/>
                            <circle cx="12" cy="16" r="1.2" fill="currentColor"/>
                            <path d="M10.29 3.86L1.82 18A2 2 0 0 0 3.53 21H20.47A2 2 0 0 0 22.18 18L13.71 3.86A2 2 0 0 0 10.29 3.86Z" stroke="currentColor" stroke-width="1.8"/>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-top">
                    <div>
                        <div class="stat-label">Total User</div>
                        <div class="stat-value">{{ $totalUsers }}</div>
                    </div>
                    <div class="stat-icon icon-blue">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                            <path d="M17 21V19C17 17.3431 15.6569 16 14 16H6C4.34315 16 3 17.3431 3 19V21" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
                            <path d="M10 13C12.2091 13 14 11.2091 14 9C14 6.79086 12.2091 5 10 5C7.79086 5 6 5.567 6 7.5C6 9.433 7.567 11 9.5 11Z" stroke="currentColor" stroke-width="1.8"/>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-top">
                    <div>
                        <div class="stat-label">Admin Sistem</div>
                        <div class="stat-value">{{ $totalAdmins }}</div>
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
                        <div class="stat-label">Petugas Lapangan</div>
                        <div class="stat-value">{{ $totalPetugas }}</div>
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
                        <div class="stat-value">{{ $activeUsers }}</div>
                    </div>
                    <div class="stat-icon icon-blue">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                            <path d="M20 7L10 17L5 12" stroke="currentColor" stroke-width="2.1" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="page-section">
        <div style="display:grid; grid-template-columns: 1.3fr 0.7fr; gap:18px; align-items:stretch;">
            <div class="content-card" style="height:100%;">
                <h2 class="section-title">Aktivitas & Ringkasan Operasional</h2>
                <p class="section-subtitle">Komposisi status aset terkini berdasarkan data yang masuk ke sistem.</p>

                <div class="progress-group">
                    <div class="progress-item">
                        <div class="meta">
                            <span>Aset Clear</span>
                            <span>{{ $clearPercent }}%</span>
                        </div>
                        <div class="progress-bar">
                            <div class="progress-fill fill-green" style="width: {{ $clearPercent }}%;"></div>
                        </div>
                    </div>

                    <div class="progress-item">
                        <div class="meta">
                            <span>Aset Proses</span>
                            <span>{{ $prosesPercent }}%</span>
                        </div>
                        <div class="progress-bar">
                            <div class="progress-fill fill-orange" style="width: {{ $prosesPercent }}%;"></div>
                        </div>
                    </div>

                    <div class="progress-item">
                        <div class="meta">
                            <span>Aset Masalah</span>
                            <span>{{ $masalahPercent }}%</span>
                        </div>
                        <div class="progress-bar">
                            <div class="progress-fill fill-red" style="width: {{ $masalahPercent }}%;"></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="content-card" style="height:100%; display:flex; flex-direction:column; margin-top:0;">
                <h2 class="section-title">Aksi Cepat</h2>
                <p class="section-subtitle">Akses menu penting untuk mempercepat pengelolaan sistem.</p>

                <div style="display:grid; grid-template-columns:1fr; gap:12px;">
                    <a href="{{ route('admin.assets.create') }}" class="btn btn-primary" style="width:100%; justify-content:center; padding:14px 16px;">
                        Tambah Aset
                    </a>

                    <a href="{{ route('admin.users.create') }}" class="btn btn-success" style="width:100%; justify-content:center; padding:14px 16px;">
                        Tambah User
                    </a>

                    <a href="{{ route('admin.reports.index') }}" class="btn btn-secondary" style="width:100%; justify-content:center; padding:14px 16px;">
                        Laporan Aset
                    </a>

                    <a href="{{ route('admin.reports.officers') }}" class="btn btn-secondary" style="width:100%; justify-content:center; padding:14px 16px;">
                        Laporan Petugas
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="page-section">
        <div class="content-card">
            <div class="toolbar" style="justify-content: space-between; align-items: center;">
                <div>
                    <h2 class="section-title" style="margin-bottom: 6px;">Data Aset Terbaru</h2>
                    <p class="section-subtitle" style="margin-bottom: 0;">
                        Menampilkan maksimal 10 aset terbaru yang ditambahkan admin atau petugas lapangan.
                    </p>
                </div>

                <a href="{{ route('admin.assets.index') }}" class="btn btn-secondary">Lihat Semua</a>
            </div>

            <table>
                <thead>
                    <tr>
                        <th>ID Asset</th>
                        <th>Status</th>
                        <th>Wilayah</th>
                        <th>Jenis</th>
                        <th>Ditambahkan Oleh</th>
                        <th>Tanggal</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($latestAssets as $asset)
                        <tr>
                            <td><strong>{{ $asset->id_asset }}</strong></td>
                            <td>
                                @if($asset->status === 'Clear')
                                    <span class="badge badge-success">Clear</span>
                                @elseif($asset->status === 'Proses')
                                    <span class="badge badge-warning">Proses</span>
                                @else
                                    <span class="badge badge-danger">Masalah</span>
                                @endif
                            </td>
                            <td>{{ $asset->province?->name }} / {{ $asset->regency?->name }} / {{ $asset->district?->name }}</td>
                            <td>{{ $asset->asset_type }}</td>
                            <td>{{ $asset->creator?->full_name }}</td>
                            <td>{{ $asset->created_at->translatedFormat('d F Y, H:i') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6">Belum ada data aset.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection