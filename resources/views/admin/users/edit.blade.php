@extends('layouts.admin', ['title' => 'Edit User'])

@section('content')
    <div class="page-section">
        <div class="content-card">
            <h2 class="section-title">Form Edit User</h2>
            <p class="section-subtitle">
                Perbarui data akun admin atau petugas lapangan.
            </p>
        </div>
    </div>

    <div class="page-section">
        <form action="{{ route('admin.users.update', $user) }}" method="POST">
            @csrf
            @method('PUT')

            @include('admin.users._form', [
                'buttonLabel' => 'Update User'
            ])
        </form>
    </div>
@endsection