@extends('layouts.admin', ['title' => 'Manajemen Aset'])

@section('content')
    <div class="page-section">
        <div class="content-card">
            <div class="toolbar" style="justify-content: space-between; align-items: center;">
                <div>
                    <h2 class="section-title" style="margin-bottom: 6px;">Kelola Manajemen Aset</h2>
                    <p class="section-subtitle" style="margin-bottom: 0;">
                        Kelola data aset PT KAI Daop 6 Yogyakarta secara rapi dan terorganisir agar lebih mudah dipantau dan dikelola.
                    </p>
                </div>

                <div class="toolbar" style="margin-top: 0;">
                    <a href="{{ route('admin.assets.index') }}" class="btn btn-secondary">Lihat Semua</a>
                    <a href="{{ route('admin.assets.create') }}" class="btn btn-success">+ Tambah Aset</a>
                </div>
            </div>
        </div>
    </div>

    <div class="page-section">
        <div class="content-card">
            <h2 class="section-title">Filter Data Aset</h2>
            <p class="section-subtitle">
                Cari data berdasarkan ID aset, status, jenis aset, dan wilayah administratif.
            </p>

            <form method="GET" class="form-inline">
                <input
                    type="text"
                    name="id_asset"
                    class="form-control"
                    placeholder="Cari ID Aset"
                    value="{{ request('id_asset') }}">

                <select name="status" class="form-control">
                    <option value="">Semua Status</option>
                    <option value="Clear" {{ request('status') == 'Clear' ? 'selected' : '' }}>Clear</option>
                    <option value="Proses" {{ request('status') == 'Proses' ? 'selected' : '' }}>Proses</option>
                    <option value="Masalah" {{ request('status') == 'Masalah' ? 'selected' : '' }}>Masalah</option>
                </select>

                <select name="asset_type" class="form-control">
                    <option value="">Semua Jenis</option>
                    <option value="Tanah" {{ request('asset_type') == 'Tanah' ? 'selected' : '' }}>Tanah</option>
                    <option value="Bangunan" {{ request('asset_type') == 'Bangunan' ? 'selected' : '' }}>Bangunan</option>
                </select>

                <select name="province_id" id="province_id" class="form-control">
                    <option value="">Provinsi</option>
                    @foreach($provinces as $province)
                        <option value="{{ $province->id }}"
                            {{ (string) request('province_id') === (string) $province->id ? 'selected' : '' }}>
                            {{ $province->name }}
                        </option>
                    @endforeach
                </select>

                <select name="regency_id" id="regency_id" class="form-control">
                    <option value="">Kabupaten/Kota</option>
                    @foreach($regencies as $regency)
                        <option value="{{ $regency->id }}"
                            {{ (string) request('regency_id') === (string) $regency->id ? 'selected' : '' }}>
                            {{ $regency->name }}
                        </option>
                    @endforeach
                </select>

                <select name="district_id" id="district_id" class="form-control">
                    <option value="">Kecamatan</option>
                    @foreach($districts as $district)
                        <option value="{{ $district->id }}"
                            {{ (string) request('district_id') === (string) $district->id ? 'selected' : '' }}>
                            {{ $district->name }}
                        </option>
                    @endforeach
                </select>

                <button class="btn btn-primary" type="submit">Filter</button>
                <a href="{{ route('admin.assets.index') }}" class="btn btn-secondary">Reset</a>
            </form>
        </div>
    </div>

    <div class="page-section">
        <div class="content-card" id="table-assets">
            <div class="toolbar" style="justify-content: space-between; align-items: center;">
                <div>
                    <h2 class="section-title" style="margin-bottom: 6px;">Daftar Aset</h2>
                    <p class="section-subtitle" style="margin-bottom: 0;">
                        Menampilkan data aset dengan pagination 10 data per halaman.
                    </p>
                </div>

                <span class="badge badge-info">
                    Total halaman: {{ $assets->lastPage() }}
                </span>
            </div>

            <table>
                <thead>
                    <tr>
                        <th>
                            @php
                                $currentSort = $sort ?? request('sort', 'desc');
                                $nextSort = $currentSort === 'asc' ? 'desc' : 'asc';
                            @endphp

                            <a href="{{ route('admin.assets.index', array_merge(request()->all(), ['sort' => $nextSort])) }}#table-assets"
                                style="display:inline-flex; align-items:center; gap:6px; text-decoration:none; color:inherit;">
                                <span>ID ASET</span>
                                @if ($currentSort === 'asc')
                                    <span style="font-size:14px; color:#2F9447;">↑</span>
                                @else
                                    <span style="font-size:14px; color:#2F9447;">↓</span>
                                @endif
                            </a>
                        </th>
                        <th>Status</th>
                        <th>Wilayah</th>
                        <th>Jenis</th>
                        <th>Klasifikasi</th>
                        <th>Kelompok</th>
                        <th>Input Oleh</th>
                        <th style="width: 120px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($assets as $asset)
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

                            <td>
                                {{ $asset->province?->name }}<br>
                                <span class="muted">
                                    {{ $asset->regency?->name }} / {{ $asset->district?->name }}
                                </span>
                            </td>

                            <td>{{ $asset->asset_type }}</td>
                            <td>{{ $asset->classification }}</td>
                            <td>{{ $asset->asset_group }}</td>
                            <td>{{ $asset->creator?->full_name }}</td>

                            <td>
                                <div style="display:flex; gap:8px; align-items:center;">
                                    <a href="{{ route('admin.assets.show', $asset) }}" class="icon-action icon-view" title="Detail">
                                        <i class="fas fa-eye"></i>
                                    </a>

                                    <a href="{{ route('admin.assets.edit', $asset) }}" class="icon-action icon-edit" title="Edit">
                                        <i class="fas fa-pen"></i>
                                    </a>

                                    <form action="{{ route('admin.assets.destroy', $asset) }}"
                                          method="POST"
                                          class="delete-form"
                                          style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="icon-action icon-delete" title="Hapus">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8">Belum ada data aset.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <div style="margin-top: 18px; display:flex; justify-content:space-between; align-items:center; gap:12px; flex-wrap:wrap;">
                <div class="muted">
                    Menampilkan {{ $assets->firstItem() ?? 0 }} - {{ $assets->lastItem() ?? 0 }} dari {{ $assets->total() }} data aset
                </div>

                <div class="custom-pagination-wrap">
                    {{ $assets->withQueryString()->fragment('table-assets')->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    @include('admin.assets._region-script')
@endsection

@push('styles')
<style>
    .form-inline .form-control {
        width: 180px;
    }

    .form-inline .btn {
        white-space: nowrap;
    }

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