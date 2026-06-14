@extends('layouts.admin', ['title' => 'Tambah User'])

@section('content')
    <div class="page-section">
        <div class="content-card">
            <h2 class="section-title">Form Tambah User</h2>
            <p class="section-subtitle">
                Tambahkan akun admin atau petugas lapangan ke dalam sistem SmartGeoKAI.
            </p>
        </div>
    </div>

    <div class="page-section">
        <form action="{{ route('admin.users.store') }}" method="POST">
            @csrf

            @include('admin.users._form', [
                'buttonLabel' => 'Simpan User'
            ])
        </form>
    </div>
@endsection