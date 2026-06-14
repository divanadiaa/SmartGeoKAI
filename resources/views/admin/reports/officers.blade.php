@extends('layouts.admin', ['title' => 'Laporan Petugas'])

@section('content')
    <div class="content-card" style="margin-bottom: 20px;">
        <div class="toolbar" style="justify-content: space-between; align-items: center;">
            <div>
                <h2 class="section-title" style="margin-bottom: 6px;">Laporan Aktivitas Petugas</h2>
                <div class="section-subtitle" style="margin-bottom: 0;">
                    Ringkasan aktivitas petugas lapangan berdasarkan histori CRUD aset dari aplikasi SmartGeoKAI.
                </div>
            </div>

            <a href="{{ route('admin.reports.index') }}" class="btn btn-secondary">
                Kembali ke Laporan Aset
            </a>
        </div>
    </div>

    <div class="content-card" id="table-officers" style="margin-bottom: 20px;">
        <h2 class="section-title">Ringkasan Petugas</h2>

        <table>
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Username</th>
                    <th>NIP</th>
                    <th>Status</th>
                    <th>Total Aset Dibuat</th>
                    <th>Create</th>
                    <th>Update</th>
                    <th>Aktivitas Terakhir</th>
                </tr>
            </thead>
            <tbody>
                @forelse($officers as $officer)
                    <tr>
                        <td><strong>{{ $officer->full_name }}</strong></td>
                        <td>{{ $officer->username }}</td>
                        <td>{{ $officer->nip }}</td>
                        <td>
                            @if($officer->is_active)
                                <span class="badge badge-success">Aktif</span>
                            @else
                                <span class="badge badge-danger">Tidak Aktif</span>
                            @endif
                        </td>
                        <td>{{ $officer->assets_created_count }}</td>
                        <td><span class="badge badge-info">{{ $officer->total_create }}</span></td>
                        <td><span class="badge badge-warning">{{ $officer->total_update }}</span></td>
                        <td>
                            {{ $officer->asset_histories_max_created_at ? \Carbon\Carbon::parse($officer->asset_histories_max_created_at)->translatedFormat('d F Y, H:i') : '-' }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9">Belum ada data petugas.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div style="margin-top: 16px; display:flex; justify-content:space-between; align-items:center; gap:12px; flex-wrap:wrap;">
            <div class="muted">
                Menampilkan {{ $officers->firstItem() ?? 0 }} - {{ $officers->lastItem() ?? 0 }} dari {{ $officers->total() }} data petugas
            </div>

            <div class="custom-pagination-wrap">
                {{ $officers->withQueryString()->fragment('table-officers')->onEachSide(1)->links() }}
            </div>
        </div>
    </div>

    <div class="content-card">
        <div class="toolbar" style="justify-content: space-between; align-items: end;">
            <div>
                <h2 class="section-title" style="margin-bottom: 6px;">Riwayat Aktivitas Petugas</h2>
                <div class="section-subtitle" style="margin-bottom: 0;">
                    Menampilkan tanggal/jam, nama petugas, aksi, ID aset, dan catatan aktivitas.
                </div>
            </div>

                <form method="GET"
                    class="form-inline"
                    style="margin-bottom: 22px; align-items:center; gap:10px;">
                <select name="user_id" class="form-control">
                    <option value="">Semua Petugas</option>
                    @foreach($petugasList as $petugas)
                        <option value="{{ $petugas->id }}" {{ request('user_id') == $petugas->id ? 'selected' : '' }}>
                            {{ $petugas->full_name }}
                        </option>
                    @endforeach
                </select>

                <input
                    type="text"
                    name="id_asset"
                    class="form-control"
                    value="{{ request('id_asset') }}"
                    placeholder="Cari ID Aset">

                <select name="action" class="form-control">
                    <option value="">Semua Aksi</option>
                    <option value="create" {{ request('action') == 'create' ? 'selected' : '' }}>Create</option>
                    <option value="update" {{ request('action') == 'update' ? 'selected' : '' }}>Update</option>
                </select>

                <input
                    type="date"
                    name="activity_date"
                    class="form-control"
                    value="{{ request('activity_date') }}">

                <button class="btn btn-primary" type="submit">Filter</button>

                <a href="{{ route('admin.reports.officers') }}" class="btn btn-secondary">Reset</a>
            </form>
        </div>

        <table>
            <thead>
                <tr>
                    <th>Tanggal/Jam</th>
                    <th>Nama Petugas</th>
                    <th>Aksi</th>
                    <th>ID Aset</th>
                    <th>Catatan</th>
                </tr>
            </thead>
            <tbody>
                @forelse($histories as $history)
                    <tr>
                        <td>{{ $history->created_at?->translatedFormat('d F Y, H:i') }}</td>
                        <td>{{ $history->user?->full_name ?? '-' }}</td>
                        <td>
                            @if($history->action === 'create')
                                <span class="badge badge-success">Create</span>
                            @elseif($history->action === 'update')
                                <span class="badge badge-warning">Update</span>
                            @endif
                        </td>
                        <td>{{ $history->asset?->id_asset ?? '-' }}</td>
                        <td>{{ $history->notes ?? '-' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5">Belum ada riwayat aktivitas petugas.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div style="margin-top: 16px; display:flex; justify-content:space-between; align-items:center; gap:12px; flex-wrap:wrap;">
            <div class="muted">
                Menampilkan {{ $histories->firstItem() ?? 0 }} - {{ $histories->lastItem() ?? 0 }} dari {{ $histories->total() }} riwayat
            </div>

            <div class="custom-pagination-wrap">
                {{ $histories->appends(request()->query())->onEachSide(1)->links() }}
            </div>
        </div>
    </div>
@endsection

@push('styles')
<style>
    .custom-pagination-wrap nav[role="navigation"] {
        width: auto !important;
    }

    .custom-pagination-wrap nav[role="navigation"] > div {
        display: flex !important;
        align-items: center !important;
        justify-content: flex-end !important;
        gap: 8px !important;
        flex-wrap: wrap !important;
    }

    .custom-pagination-wrap nav[role="navigation"] a,
    .custom-pagination-wrap nav[role="navigation"] span {
        min-width: 42px !important;
        height: 42px !important;
        padding: 0 14px !important;
        border-radius: 12px !important;
        font-size: 14px !important;
        line-height: 1 !important;
        display: inline-flex !important;
        align-items: center !important;
        justify-content: center !important;
        text-decoration: none !important;
        box-sizing: border-box !important;
    }

    .custom-pagination-wrap nav[role="navigation"] a {
        background: #eef3f8 !important;
        color: #102235 !important;
        border: 1px solid #dbe4ee !important;
    }

    .custom-pagination-wrap nav[role="navigation"] a:hover {
        background: #e3ebf5 !important;
    }

    .custom-pagination-wrap nav[role="navigation"] span[aria-current="page"],
    .custom-pagination-wrap nav[role="navigation"] span[aria-current="page"] span {
        background: linear-gradient(135deg, #0d47a1, #1565c0) !important;
        color: #ffffff !important;
        border: 1px solid #0d47a1 !important;
    }

    .custom-pagination-wrap nav[role="navigation"] span[aria-disabled="true"],
    .custom-pagination-wrap nav[role="navigation"] span[aria-disabled="true"] span {
        background: #f3f5f7 !important;
        color: #98a4b3 !important;
        border: 1px solid #e4e9ef !important;
    }
</style>
@endpush