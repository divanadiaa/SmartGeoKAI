<?php

return [

    'required' => ':attribute wajib diisi.',
    'unique' => ':attribute sudah digunakan.',
    'confirmed' => 'Konfirmasi :attribute tidak sesuai.',
    'numeric' => ':attribute harus berupa angka.',
    'exists' => ':attribute yang dipilih tidak valid.',
    'image' => ':attribute harus berupa gambar.',
    'url' => ':attribute harus berupa URL yang valid.',
    'mimes' => ':attribute harus berformat: :values.',

    'min' => [
        'string' => ':attribute minimal :min karakter.',
        'numeric' => ':attribute minimal :min.',
        'file' => ':attribute minimal :min KB.',
        'array' => ':attribute minimal :min item.',
    ],

    'max' => [
        'string' => ':attribute maksimal :max karakter.',
        'numeric' => ':attribute maksimal :max.',
        'file' => ':attribute maksimal :max KB.',
        'array' => ':attribute maksimal :max item.',
    ],

    'attributes' => [

        // USER
        'full_name' => 'Nama Lengkap',
        'username' => 'Username',
        'nip' => 'NIP',
        'role' => 'Role',
        'password' => 'Password',
        'password_confirmation' => 'Konfirmasi Password',
        'is_active' => 'Status Akun',

        // ASSET
        'id_asset' => 'ID Aset',
        'province_id' => 'Provinsi',
        'regency_id' => 'Kabupaten/Kota',
        'district_id' => 'Kecamatan',
        'asset_type' => 'Jenis Aset',
        'classification' => 'Klasifikasi',
        'asset_group' => 'Kelompok Aset',
        'status' => 'Status',
        'area_m2' => 'Luas Aset',
        'latitude' => 'Latitude',
        'longitude' => 'Longitude',
        'gmaps_url' => 'Link Google Maps',
        'description' => 'Deskripsi',
        'images' => 'Gambar Aset',
        'documents' => 'Dokumen Aset',
    ],

];