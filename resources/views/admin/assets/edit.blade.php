@extends('layouts.admin', ['title' => 'Edit Aset'])

@section('content')
    <div class="page-section">
        <div class="content-card">
            <h2 class="section-title">Form Edit Aset</h2>
            <p class="section-subtitle">
                Perbarui data aset, wilayah administratif, koordinat, dan dokumentasi pendukung.
            </p>
        </div>
    </div>

    <div class="page-section">
        <form action="{{ route('admin.assets.update', $asset) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            @include('admin.assets._form', [
                'buttonLabel' => 'Update Aset'
            ])
        </form>
    </div>
@endsection

@section('scripts')
    @include('admin.assets._region-script')
@endsection