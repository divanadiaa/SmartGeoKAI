<div class="card">
    @if ($errors->any())
        <div style="
            background:#fee2e2;
            border:1px solid #ef4444;
            color:#991b1b;
            padding:12px;
            border-radius:8px;
            margin-bottom:15px;">
            <strong>Terjadi kesalahan:</strong>
            <ul style="margin:8px 0 0 20px;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="form-grid">

        {{-- ID ASET --}}
        <div class="form-group">
            <label class="form-label">ID Aset</label>
            <input type="text"
                   name="id_asset"
                   class="form-control-full @error('id_asset') is-invalid @enderror"
                   value="{{ old('id_asset', $asset->id_asset ?? '') }}"
                   placeholder="Contoh: 06.01.00001">

            @error('id_asset')
                <small class="form-error-text">{{ $message }}</small>
            @enderror
        </div>

        {{-- STATUS --}}
        <div class="form-group">
            <label class="form-label">Status</label>
            <select name="status" class="form-control-full @error('status') is-invalid @enderror">
                <option value="">Pilih Status</option>
                <option value="Clear" {{ old('status', $asset->status ?? '') == 'Clear' ? 'selected' : '' }}>Clear</option>
                <option value="Proses" {{ old('status', $asset->status ?? '') == 'Proses' ? 'selected' : '' }}>Proses</option>
                <option value="Masalah" {{ old('status', $asset->status ?? '') == 'Masalah' ? 'selected' : '' }}>Masalah</option>
            </select>

            @error('status')
                <small class="form-error-text">{{ $message }}</small>
            @enderror
        </div>

        {{-- PROVINSI --}}
        <div class="form-group">
            <label class="form-label">Provinsi</label>
            <select name="province_id" id="province_id"
                    class="form-control-full @error('province_id') is-invalid @enderror">
                <option value="">Pilih Provinsi</option>
                @foreach($provinces as $province)
                    <option value="{{ $province->id }}"
                        {{ (string) old('province_id', $asset->province_id ?? '') === (string) $province->id ? 'selected' : '' }}>
                        {{ $province->name }}
                    </option>
                @endforeach
            </select>

            @error('province_id')
                <small class="form-error-text">{{ $message }}</small>
            @enderror
        </div>

        {{-- KABUPATEN --}}
        <div class="form-group">
            <label class="form-label">Kabupaten/Kota</label>
            <select name="regency_id" id="regency_id"
                    class="form-control-full @error('regency_id') is-invalid @enderror">
                <option value="">Pilih Kabupaten/Kota</option>
                @isset($regencies)
                    @foreach($regencies as $regency)
                        <option value="{{ $regency->id }}"
                            {{ (string) old('regency_id', $asset->regency_id ?? '') === (string) $regency->id ? 'selected' : '' }}>
                            {{ $regency->name }}
                        </option>
                    @endforeach
                @endisset
            </select>

            @error('regency_id')
                <small class="form-error-text">{{ $message }}</small>
            @enderror
        </div>

        {{-- KECAMATAN --}}
        <div class="form-group">
            <label class="form-label">Kecamatan</label>
            <select name="district_id" id="district_id"
                    class="form-control-full @error('district_id') is-invalid @enderror">
                <option value="">Pilih Kecamatan</option>
                @isset($districts)
                    @foreach($districts as $district)
                        <option value="{{ $district->id }}"
                            {{ (string) old('district_id', $asset->district_id ?? '') === (string) $district->id ? 'selected' : '' }}>
                            {{ $district->name }}
                        </option>
                    @endforeach
                @endisset
            </select>

            @error('district_id')
                <small class="form-error-text">{{ $message }}</small>
            @enderror
        </div>

        {{-- JENIS ASET --}}
        <div class="form-group">
            <label class="form-label">Jenis Aset</label>
            <select name="asset_type" class="form-control-full @error('asset_type') is-invalid @enderror">
                <option value="">Pilih Jenis Aset</option>
                <option value="Tanah" {{ old('asset_type', $asset->asset_type ?? '') == 'Tanah' ? 'selected' : '' }}>Tanah</option>
                <option value="Bangunan" {{ old('asset_type', $asset->asset_type ?? '') == 'Bangunan' ? 'selected' : '' }}>Bangunan</option>
            </select>

            @error('asset_type')
                <small class="form-error-text">{{ $message }}</small>
            @enderror
        </div>

        {{-- KLASIFIKASI --}}
        <div class="form-group">
            <label class="form-label">Klasifikasi</label>
            <select name="classification" class="form-control-full @error('classification') is-invalid @enderror">
                <option value="">Pilih Klasifikasi</option>
                <option value="ROW" {{ old('classification', $asset->classification ?? '') == 'ROW' ? 'selected' : '' }}>ROW</option>
                <option value="Fasilitas" {{ old('classification', $asset->classification ?? '') == 'Fasilitas' ? 'selected' : '' }}>Fasilitas</option>
                <option value="Operasional" {{ old('classification', $asset->classification ?? '') == 'Operasional' ? 'selected' : '' }}>Operasional</option>
            </select>

            @error('classification')
                <small class="form-error-text">{{ $message }}</small>
            @enderror
        </div>

        {{-- KELOMPOK --}}
        <div class="form-group">
            <label class="form-label">Kelompok</label>
            <select name="asset_group" class="form-control-full @error('asset_group') is-invalid @enderror">
                <option value="">Pilih Kelompok</option>
                <option value="Produksi" {{ old('asset_group', $asset->asset_group ?? '') == 'Produksi' ? 'selected' : '' }}>Produksi</option>
                <option value="Non Produksi" {{ old('asset_group', $asset->asset_group ?? '') == 'Non Produksi' ? 'selected' : '' }}>Non Produksi</option>
            </select>

            @error('asset_group')
                <small class="form-error-text">{{ $message }}</small>
            @enderror
        </div>

        {{-- LUAS --}}
        <div class="form-group">
            <label class="form-label">Luas (m²)</label>
            <input type="number"
                   step="0.01"
                   name="area_m2"
                   class="form-control-full @error('area_m2') is-invalid @enderror"
                   value="{{ old('area_m2', $asset->area_m2 ?? '') }}"
                   placeholder="Contoh: 323101.0">

            @error('area_m2')
                <small class="form-error-text">{{ $message }}</small>
            @enderror
        </div>

        {{-- LAT --}}
        <div class="form-group">
            <label class="form-label">Latitude</label>
            <input type="number"
                   step="0.0000000001"
                   name="latitude"
                   class="form-control-full @error('latitude') is-invalid @enderror"
                   value="{{ old('latitude', $asset->latitude ?? '') }}"
                   placeholder="-7.7296600307">

            @error('latitude')
                <small class="form-error-text">{{ $message }}</small>
            @enderror
        </div>

        {{-- LONG --}}
        <div class="form-group">
            <label class="form-label">Longitude</label>
            <input type="number"
                   step="0.0000000001"
                   name="longitude"
                   class="form-control-full @error('longitude') is-invalid @enderror"
                   value="{{ old('longitude', $asset->longitude ?? '') }}"
                   placeholder="109.9241356">

            @error('longitude')
                <small class="form-error-text">{{ $message }}</small>
            @enderror
        </div>

        {{-- GMAPS --}}
        <div class="form-group">
            <label class="form-label">Link Google Maps</label>
            <input type="text"
                   name="gmaps_url"
                   class="form-control-full @error('gmaps_url') is-invalid @enderror"
                   value="{{ old('gmaps_url', $asset->gmaps_url ?? '') }}"
                   placeholder="Kosongkan jika otomatis">

            @error('gmaps_url')
                <small class="form-error-text">{{ $message }}</small>
            @enderror
        </div>

        {{-- IMAGES --}}
        <div class="form-group">
            <label class="form-label">Gambar Aset (maks. 10 file)</label>
            <input type="file"
                name="images[]"
                class="form-control-full @error('images') is-invalid @enderror"
                multiple
                accept="image/*">

            <div class="muted" style="margin-top:6px;">
                Format gambar, maksimal 5MB per file.
            </div>

            @error('images')
                <small class="form-error-text">{{ $message }}</small>
            @enderror

            @if(isset($asset) && $asset->images->count())
                <div id="gambar-aset" style="margin-top:15px;">
                    <strong>Gambar Saat Ini</strong>

                    <div style="display:flex;flex-wrap:wrap;gap:12px;margin-top:10px;">
                        @foreach($asset->images as $image)
                            <div style="border:1px solid #ddd;padding:10px;border-radius:8px;text-align:center;">

                                <a href="{{ asset('storage/' . $image->file_path) }}"
                                target="_blank">
                                    <img src="{{ asset('storage/' . $image->file_path) }}"
                                        alt="{{ $image->file_name }}"
                                        style="width:150px;height:120px;object-fit:cover;border-radius:6px;">
                                </a>

                                <div style="margin-top:8px;">
                                    <a href="{{ route('admin.assets.deleteImage', [$asset->id, $image->id]) }}"
                                    onclick="return confirm('Hapus gambar ini?')"
                                    class="btn btn-danger btn-sm">
                                        Hapus
                                    </a>
                                </div>

                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>

        {{-- DOCUMENTS --}}
        <div class="form-group">
            <label class="form-label">Dokumen Aset (maks. 10 file)</label>
            <input type="file"
                name="documents[]"
                class="form-control-full @error('documents') is-invalid @enderror"
                multiple
                accept=".pdf,.doc,.docx,.xls,.xlsx">

            <div class="muted" style="margin-top:6px;">
                Format PDF, DOC, XLS. Maksimal 10MB per file.
            </div>

            @error('documents')
                <small class="form-error-text">{{ $message }}</small>
            @enderror

            @if(isset($asset) && $asset->documents->count())
                <div id="dokumen-aset" style="margin-top:15px;">
                    <strong>Dokumen Saat Ini</strong>

                    <table class="table" style="margin-top:10px;">
                        <thead>
                            <tr>
                                <th>Nama Dokumen</th>
                                <th width="180">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($asset->documents as $document)
                                <tr>
                                    <td>{{ $document->file_name }}</td>

                                    <td>
                                        <a href="{{ asset('storage/' . $document->file_path) }}"
                                        target="_blank"
                                        class="btn btn-info btn-sm">
                                            Lihat
                                        </a>

                                        <a href="{{ route('admin.assets.deleteDocument', [$asset->id, $document->id]) }}"
                                        onclick="return confirm('Hapus dokumen ini?')"
                                        class="btn btn-danger btn-sm">
                                            Hapus
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>

    </div>

    {{-- DESKRIPSI --}}
    <div class="form-group" style="margin-top:14px;">
        <label class="form-label">Deskripsi</label>
        <textarea name="description"
                  class="form-control-full @error('description') is-invalid @enderror"
                  rows="10"
                  placeholder="Masukkan deskripsi aset">{{ old('description', $asset->description ?? '') }}</textarea>

        @error('description')
            <small class="form-error-text">{{ $message }}</small>
        @enderror
    </div>

    {{-- ACTION --}}
    <div class="toolbar" style="margin-top:18px;">
        <button type="submit" class="btn btn-primary">{{ $buttonLabel }}</button>
        <a href="{{ route('admin.assets.index') }}" class="btn btn-secondary">Kembali</a>
    </div>
</div>