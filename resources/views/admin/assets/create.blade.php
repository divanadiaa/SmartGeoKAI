@extends('layouts.admin', ['title' => 'Tambah Aset'])

@section('content')
    <div class="page-section">
        <div class="content-card">
            <h2 class="section-title">Form Tambah Aset</h2>
            <p class="section-subtitle">
                Masukkan data aset baru lengkap dengan wilayah, status, koordinat, dan dokumentasi gambar.
            </p>
        </div>
    </div>

    <div class="page-section">
        <form action="{{ route('admin.assets.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            @include('admin.assets._form', [
                'buttonLabel' => 'Simpan Aset'
            ])
        </form>
    </div>
@endsection

@section('scripts')
    @include('admin.assets._region-script')
@endsection