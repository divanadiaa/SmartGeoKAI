<?php

namespace Database\Seeders;

use App\Models\Asset;
use App\Models\District;
use App\Models\Province;
use App\Models\Regency;
use App\Models\User;
use Illuminate\Database\Seeder;

class AssetSeeder extends Seeder
{
    public function run(): void
    {
        $province = Province::where('name', 'Jawa Tengah')->first();
        $regency = Regency::where('name', 'Kabupaten Purworejo')->first();
        $district = District::where('name', 'Bayan')->where('regency_id', $regency?->id)->first();
        $user = User::where('username', 'petugas1')->first();

        if (!$province || !$regency || !$district || !$user) {
            return;
        }

        Asset::updateOrCreate(
            ['id_asset' => '06.01.00001'],
            [
                'province_id' => $province->id,
                'regency_id' => $regency->id,
                'district_id' => $district->id,
                'asset_type' => 'Tanah',
                'classification' => 'Operasional',
                'asset_group' => 'Produksi',
                'status' => 'Clear',
                'area_m2' => 323101.0,
                'latitude' => -7.7296600307,
                'longitude' => 109.9241356,
                'description' => "INFORMASI ASET\nStatus Perolehan : Nasionalisasi\nNilai Perolehan BUMN : Rp 1.136.806\n\nSERTIFIKAT\nTgl. Perolehan : 17/11/1941\nTgl. Keluaran Sertifikat : 01/01/1991\nNomor Sertifikat : Grondkaart No. 8\nStatus Tanah : Grondkaart\nTercatat Atas Nama : Staatsspoorwegen in Ned: Indie\nDikeluarkan Oleh : Directeur van Verkeer en Waterstaat\n\nDATA ADMINISTRASI BERJALAN\nKeterangan Aset : Sudah disertifikasi\nPeruntukan : Jalur KA\nStatus Produktivitas : Produktif\nKelompok Pengguna : Instansi\nNama Pengguna : Multi Penyewa\nStatus Pengelolaan : Dikelola Pihak Lain\nLuas Dikelola Pihak Lain : 1",
                'gmaps_url' => 'https://maps.google.com/?q=-7.7296600307,109.9241356',
                'created_by' => $user->id,
                'updated_by' => $user->id,
            ]
        );
    }
}