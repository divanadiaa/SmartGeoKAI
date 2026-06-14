<?php

namespace Database\Seeders;

use App\Models\District;
use App\Models\Province;
use App\Models\Regency;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class RegionSeeder extends Seeder
{
    public function run(): void
    {
        $basePath = database_path('data/regions');

        $provinceFile = $basePath . '/provinces.json';
        $regencyFile = $basePath . '/regencies.json';
        $districtFile = $basePath . '/districts.json';

        if (!File::exists($provinceFile) || !File::exists($regencyFile) || !File::exists($districtFile)) {
            $this->command->error('File wilayah tidak ditemukan di database/data/regions');
            return;
        }

        $provinces = json_decode(File::get($provinceFile), true);
        $regencies = json_decode(File::get($regencyFile), true);
        $districts = json_decode(File::get($districtFile), true);

        if (!is_array($provinces) || !is_array($regencies) || !is_array($districts)) {
            $this->command->error('Format JSON wilayah tidak valid.');
            return;
        }

        DB::transaction(function () use ($provinces, $regencies, $districts) {
            foreach ($provinces as $province) {
                Province::updateOrCreate(
                    ['code' => (string) $province['code']],
                    ['name' => $province['name']]
                );
            }

            $provinceMap = Province::pluck('id', 'code')->toArray();

            foreach ($regencies as $regency) {
                $provinceCode = (string) $regency['province_code'];

                if (!isset($provinceMap[$provinceCode])) {
                    continue;
                }

                Regency::updateOrCreate(
                    ['code' => (string) $regency['code']],
                    [
                        'province_id' => $provinceMap[$provinceCode],
                        'name' => $regency['name'],
                    ]
                );
            }

            $regencyMap = Regency::pluck('id', 'code')->toArray();

            foreach ($districts as $district) {
                $regencyCode = (string) $district['regency_code'];

                if (!isset($regencyMap[$regencyCode])) {
                    continue;
                }

                District::updateOrCreate(
                    ['code' => (string) $district['code']],
                    [
                        'regency_id' => $regencyMap[$regencyCode],
                        'name' => $district['name'],
                    ]
                );
            }
        });

        $this->command->info('Import wilayah selesai.');
        $this->command->info('Total provinsi: ' . Province::count());
        $this->command->info('Total kabupaten/kota: ' . Regency::count());
        $this->command->info('Total kecamatan: ' . District::count());
    }
}