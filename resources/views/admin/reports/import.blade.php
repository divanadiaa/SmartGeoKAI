@extends('layouts.admin', ['title' => 'Import Data Aset'])

@section('content')

    <div class="page-section">
        <div class="content-card">
            <h2 class="section-title">Kelola Import Data Aset</h2>

            <p class="section-subtitle">
                Download template CSV terlebih dahulu, isi data aset sesuai format,
                lalu upload file untuk mengimport data aset ke sistem.
            </p>
        </div>
    </div>

    <div class="page-section" id="import-result">
        @if(session('success'))
            <div class="import-alert import-alert-success" id="success-alert">
                <div class="import-alert-content">
                    <div class="import-alert-title">
                        Import Berhasil
                    </div>

                    <div class="import-alert-message">
                        {{ session('success') }}
                    </div>
                </div>

                <button type="button"
                        class="import-alert-close"
                        onclick="document.getElementById('success-alert').remove()">
                    ×
                </button>
            </div>
        @endif

        @if(session('import_errors'))
            <div class="import-alert import-alert-danger" id="error-alert">
                <div class="import-alert-content">
                    <div class="import-alert-title">
                        Import Gagal / Sebagian Data Tidak Masuk
                    </div>

                    <div class="import-alert-message">
                        Data berhasil diimport:
                        <strong>{{ session('import_success_count', 0) }}</strong>
                    </div>

                    <div class="import-error-list">
                        @foreach(session('import_errors') as $error)
                            <div class="import-error-item">
                                {{ $error }}
                            </div>
                        @endforeach
                    </div>
                </div>

                <button type="button"
                        class="import-alert-close"
                        onclick="document.getElementById('error-alert').remove()">
                    ×
                </button>
            </div>
        @endif

        @if($errors->any())
            <div class="import-alert import-alert-danger" id="validation-alert">
                <div class="import-alert-content">
                    <div class="import-alert-title">
                        File Tidak Dapat Diproses
                    </div>

                    <div class="import-error-list">
                        @foreach($errors->all() as $error)
                            <div class="import-error-item">
                                {{ $error }}
                            </div>
                        @endforeach
                    </div>
                </div>

                <button type="button"
                        class="import-alert-close"
                        onclick="document.getElementById('validation-alert').remove()">
                    ×
                </button>
            </div>
        @endif
    </div>

    <div class="page-section">
        <div class="content-card">

            <div class="toolbar" style="justify-content: space-between; align-items: center;">
                <div>
                    <h2 class="section-title" style="margin-bottom: 6px;">
                        Template Import
                    </h2>

                    <p class="section-subtitle" style="margin-bottom: 0;">
                        Gunakan template resmi agar format data sesuai dengan sistem.
                    </p>
                </div>

                <a href="{{ route('admin.reports.import.template') }}"
                   class="btn btn-success">
                    Download Template CSV
                </a>
            </div>

        </div>
    </div>

    <div class="page-section">
        <div class="content-card">

            <h2 class="section-title">Upload File CSV</h2>

            <p class="section-subtitle">
                Upload file CSV yang sudah diisi sesuai format template import data aset.
            </p>

            <form action="{{ route('admin.reports.import.store') }}"
                  method="POST"
                  enctype="multipart/form-data">

                @csrf

                <div class="form-group">
                    <label class="form-label">
                        File CSV
                    </label>

                    <input type="file"
                           name="file"
                           accept=".csv"
                           required
                           class="form-control">
                </div>

                <div class="toolbar" style="margin-top: 22px;">
                    <button type="submit" class="btn btn-primary">
                        Import Data
                    </button>

                    <a href="{{ route('admin.assets.index') }}"
                       class="btn btn-secondary">
                        Kembali
                    </a>
                </div>

            </form>

        </div>
    </div>

    <div class="page-section">
        <div class="content-card">

            <h2 class="section-title">
                Contoh Pengisian CSV
            </h2>

            <p class="section-subtitle">
                Contoh format pengisian data aset yang benar sesuai dengan sistem manajemen aset.
            </p>

            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Kolom</th>
                            <th>Contoh Isi</th>
                            <th>Keterangan</th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr>
                            <td><strong>id_asset</strong></td>
                            <td>06.01.00001</td>
                            <td>ID unik aset</td>
                        </tr>

                        <tr>
                            <td><strong>status</strong></td>
                            <td>Clear</td>
                            <td>Clear / Proses / Masalah</td>
                        </tr>

                        <tr>
                            <td><strong>province</strong></td>
                            <td>Jawa Tengah</td>
                            <td>Nama provinsi sesuai database wilayah</td>
                        </tr>

                        <tr>
                            <td><strong>regency</strong></td>
                            <td>Purworejo</td>
                            <td>Nama kabupaten/kota sesuai provinsi</td>
                        </tr>

                        <tr>
                            <td><strong>district</strong></td>
                            <td>Purworejo</td>
                            <td>Nama kecamatan sesuai kabupaten/kota</td>
                        </tr>

                        <tr>
                            <td><strong>asset_type</strong></td>
                            <td>Tanah</td>
                            <td>Tanah / Bangunan</td>
                        </tr>

                        <tr>
                            <td><strong>classification</strong></td>
                            <td>ROW</td>
                            <td>ROW / Fasilitas / Operasional</td>
                        </tr>

                        <tr>
                            <td><strong>asset_group</strong></td>
                            <td>Produksi</td>
                            <td>Produksi / Non Produksi</td>
                        </tr>

                        <tr>
                            <td><strong>area_m2</strong></td>
                            <td>1200</td>
                            <td>Luas aset dalam meter persegi</td>
                        </tr>

                        <tr>
                            <td><strong>latitude</strong></td>
                            <td>-7.7829</td>
                            <td>Koordinat latitude lokasi aset</td>
                        </tr>

                        <tr>
                            <td><strong>longitude</strong></td>
                            <td>110.3671</td>
                            <td>Koordinat longitude lokasi aset</td>
                        </tr>

                        <tr>
                            <td><strong>description</strong></td>
                            <td>Aset tanah area stasiun</td>
                            <td>Keterangan atau deskripsi aset</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="import-note">
                <strong>Catatan:</strong><br>

                • File wajib menggunakan format CSV.<br>
                • ID aset tidak boleh duplikat.<br>
                • Data wilayah harus sesuai dengan data wilayah pada sistem.<br>
                • Foto aset dan dokumen aset tidak termasuk proses import.<br>
                • Sistem otomatis membuat link Google Maps berdasarkan latitude dan longitude.
            </div>
        </div>
    </div>

@endsection

@push('styles')
<style>
    .import-alert {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 16px;
        padding: 18px;
        border-radius: 18px;
        margin-bottom: 18px;
        box-shadow: 0 10px 24px rgba(15, 23, 42, 0.05);
    }

    .import-alert-success {
        background: #ecfdf3;
        border: 1px solid #bbf7d0;
        color: #166534;
    }

    .import-alert-danger {
        background: #fef2f2;
        border: 1px solid #fecaca;
        color: #991b1b;
    }

    .import-alert-content {
        flex: 1;
    }

    .import-alert-title {
        font-size: 15px;
        font-weight: 800;
        margin-bottom: 6px;
    }

    .import-alert-message {
        font-size: 14px;
        line-height: 1.6;
        margin-bottom: 10px;
    }

    .import-alert-close {
        width: 30px;
        height: 30px;
        border: none;
        border-radius: 999px;
        background: rgba(255, 255, 255, 0.75);
        color: inherit;
        font-size: 22px;
        line-height: 1;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }

    .import-alert-close:hover {
        background: rgba(255, 255, 255, 1);
    }

    .import-error-list {
        max-height: 260px;
        overflow-y: auto;
        display: flex;
        flex-direction: column;
        gap: 8px;
    }

    .import-error-item {
        background: #ffffff;
        border: 1px solid #f3d1d1;
        border-radius: 12px;
        padding: 10px 12px;
        font-size: 13px;
        line-height: 1.5;
    }

    .import-note {
        margin-top: 18px;
        padding: 14px 16px;
        background: #fff8e6;
        border: 1px solid #fde7a3;
        border-radius: 14px;
        color: #92400e;
        font-size: 13px;
        line-height: 1.7;
    }
</style>
@endpush