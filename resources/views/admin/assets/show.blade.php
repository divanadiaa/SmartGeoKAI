@extends('layouts.admin', ['title' => 'Detail Aset'])

@section('content')
    <div class="page-section">
        <div class="content-card">
            <h2 class="section-title">Detail Aset</h2>
            <p class="section-subtitle">
                Informasi lengkap aset beserta wilayah, status, koordinat, deskripsi, foto, dan dokumen aset.
            </p>
        </div>
    </div>

    <div class="page-section">
        <div class="card">
            <div class="detail-grid">

                <div class="detail-item">
                    <div class="detail-label">ID Aset</div>
                    <div class="detail-value">
                        {{ $asset->id_asset }}
                    </div>
                </div>

                <div class="detail-item">
                    <div class="detail-label">Status</div>
                    <div class="detail-value">
                        @if($asset->status === 'Clear')
                            <span class="badge badge-success">Clear</span>
                        @elseif($asset->status === 'Proses')
                            <span class="badge badge-warning">Proses</span>
                        @else
                            <span class="badge badge-danger">Masalah</span>
                        @endif
                    </div>
                </div>

                <div class="detail-item">
                    <div class="detail-label">Provinsi</div>
                    <div class="detail-value">
                        {{ $asset->province?->name ?? '-' }}
                    </div>
                </div>

                <div class="detail-item">
                    <div class="detail-label">Kabupaten / Kota</div>
                    <div class="detail-value">
                        {{ $asset->regency?->name ?? '-' }}
                    </div>
                </div>

                <div class="detail-item">
                    <div class="detail-label">Kecamatan</div>
                    <div class="detail-value">
                        {{ $asset->district?->name ?? '-' }}
                    </div>
                </div>

                <div class="detail-item">
                    <div class="detail-label">Jenis Aset</div>
                    <div class="detail-value">
                        {{ $asset->asset_type ?? '-' }}
                    </div>
                </div>

                <div class="detail-item">
                    <div class="detail-label">Klasifikasi</div>
                    <div class="detail-value">
                        {{ $asset->classification ?? '-' }}
                    </div>
                </div>

                <div class="detail-item">
                    <div class="detail-label">Kelompok</div>
                    <div class="detail-value">
                        {{ $asset->asset_group ?? '-' }}
                    </div>
                </div>

                <div class="detail-item">
                    <div class="detail-label">Luas Area</div>
                    <div class="detail-value">
                        {{ $asset->area_m2 ?? 0 }} m²
                    </div>
                </div>

                <div class="detail-item">
                    <div class="detail-label">Latitude</div>
                    <div class="detail-value">
                        {{ $asset->latitude ?? '-' }}
                    </div>
                </div>

                <div class="detail-item">
                    <div class="detail-label">Longitude</div>
                    <div class="detail-value">
                        {{ $asset->longitude ?? '-' }}
                    </div>
                </div>

                <div class="detail-item">
                    <div class="detail-label">Ditambahkan Oleh</div>
                    <div class="detail-value">
                        {{ $asset->creator?->full_name ?? '-' }}
                    </div>
                </div>

                <div class="detail-item">
                    <div class="detail-label">Dibuat Pada</div>
                    <div class="detail-value">
                        {{ $asset->created_at?->format('d M Y H:i') ?? '-' }}
                    </div>
                </div>

                <div class="detail-item">
                    <div class="detail-label">Terakhir Diupdate</div>
                    <div class="detail-value">
                        {{ $asset->updated_at?->format('d M Y H:i') ?? '-' }}
                    </div>
                </div>

            </div>

            <div class="form-group" style="margin-top: 18px;">
                <label class="form-label">Deskripsi</label>

                <pre style="
                    white-space: pre-wrap;
                    word-break: break-word;
                    background: #f8fbff;
                    border: 1px solid #e8eef5;
                    padding: 16px;
                    border-radius: 18px;
                    font-family: inherit;
                    font-size: 14px;
                    line-height: 1.7;
                    margin: 0;
                ">{{ $asset->description ?: '-' }}</pre>
            </div>

            <div class="form-group" style="margin-top: 24px;">
                <label class="form-label">Google Maps</label>

                @if($asset->gmaps_url)
                    <a href="{{ $asset->gmaps_url }}"
                       target="_blank"
                       class="btn btn-success">
                        <i class="fas fa-map-marker-alt"></i>
                        Buka di Google Maps
                    </a>
                @else
                    <div class="muted">
                        Link Google Maps tidak tersedia
                    </div>
                @endif
            </div>

            <div class="form-group" style="margin-top: 24px;">
                <label class="form-label">Foto Aset</label>

                @if($asset->images && $asset->images->count())
                    <div class="image-list">
                        @foreach($asset->images as $image)
                            <div class="image-card">
                                <img src="{{ asset('storage/' . $image->file_path) }}" alt="{{ $image->file_name }}">

                                <div class="muted" style="margin-top: 8px;">
                                    {{ $image->file_name }}
                                </div>

                                <div class="muted" style="margin-top: 4px; font-size: 12px;">
                                    Upload: {{ $image->created_at?->format('d M Y H:i') ?? '-' }}
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="muted">
                        Belum ada foto aset
                    </div>
                @endif
            </div>

            <div class="form-group" style="margin-top: 28px;">
                <label class="form-label">Dokumen Aset</label>

                @if($asset->documents && $asset->documents->count())
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Nama Dokumen</th>
                                    <th>Tipe</th>
                                    <th>Ukuran</th>
                                    <th>Tanggal Upload</th>
                                    <th style="width: 140px;">Aksi</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach($asset->documents as $document)
                                    <tr>
                                        <td>
                                            {{ $document->file_name }}
                                        </td>

                                        <td>
                                            {{ strtoupper($document->file_type ?? '-') }}
                                        </td>

                                        <td>
                                            @if($document->file_size)
                                                {{ number_format($document->file_size / 1024, 1) }} KB
                                            @else
                                                -
                                            @endif
                                        </td>

                                        <td>
                                            {{ $document->created_at?->format('d M Y H:i') ?? '-' }}
                                        </td>

                                        <td>
                                            <div style="display: flex; gap: 8px;">

                                                <a href="{{ asset('storage/' . $document->file_path) }}"
                                                   target="_blank"
                                                   class="icon-action icon-view"
                                                   title="Lihat Dokumen">
                                                    <i class="fas fa-eye"></i>
                                                </a>

                                                <a href="{{ asset('storage/' . $document->file_path) }}"
                                                   download
                                                   class="icon-action icon-edit"
                                                   title="Download Dokumen">
                                                    <i class="fas fa-download"></i>
                                                </a>

                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="muted">
                        Belum ada dokumen aset
                    </div>
                @endif
            </div>

            <div class="toolbar" style="margin-top: 32px;">
                <a href="{{ route('admin.assets.edit', $asset->id) }}"
                   class="btn btn-primary">
                    Edit Aset
                </a>

                <a href="{{ route('admin.assets.index') }}"
                   class="btn btn-secondary">
                    Kembali
                </a>
            </div>

        </div>
    </div>
@endsection