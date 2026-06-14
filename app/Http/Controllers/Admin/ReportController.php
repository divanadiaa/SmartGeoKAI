<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Asset;
use App\Models\AssetHistory;
use App\Models\District;
use App\Models\Province;
use App\Models\Regency;
use App\Models\User;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $order = strtolower($request->get('order', 'asc'));

        if (!in_array($order, ['asc', 'desc'])) {
            $order = 'asc';
        }

        $assets = Asset::with(['province', 'regency', 'district', 'creator'])
            ->when($request->status, fn($q) => $q->where('status', $request->status))
            ->when($request->province_id, fn($q) => $q->where('province_id', $request->province_id))
            ->when($request->regency_id, fn($q) => $q->where('regency_id', $request->regency_id))
            ->when($request->district_id, fn($q) => $q->where('district_id', $request->district_id))
            ->orderBy('id_asset', $order)
            ->paginate(10)
            ->withQueryString();

        $provinces = Province::orderBy('name')->get();

        $regencies = $request->province_id
            ? Regency::where('province_id', $request->province_id)->orderBy('name')->get()
            : collect();

        $districts = $request->regency_id
            ? District::where('regency_id', $request->regency_id)->orderBy('name')->get()
            : collect();

        return view('admin.reports.index', compact(
            'assets',
            'provinces',
            'regencies',
            'districts',
            'order'
        ));
    }

    public function officers(Request $request)
    {
        $officers = User::where('role', 'petugas')
            ->withCount('assetsCreated')
            ->withCount([
                'assetHistories as total_create' => fn($q) => $q->where('action', 'create'),
                'assetHistories as total_update' => fn($q) => $q->where('action', 'update'),
            ])
            ->withMax('assetHistories', 'created_at')
            ->latest()
            ->paginate(10, ['*'], 'officers_page');

        $histories = AssetHistory::with(['user', 'asset'])
            ->when($request->role_filter, function ($q) use ($request) {
                if ($request->role_filter === 'petugas') {
                    $q->whereHas('user', fn($userQuery) => $userQuery->where('role', 'petugas'));
                }

                if ($request->role_filter === 'administrator') {
                    $q->whereHas('user', function ($userQuery) {
                        $userQuery->whereIn('role', ['admin', 'administrator']);
                    });
                }
            })
            ->when($request->user_id, fn($q) => $q->where('user_id', $request->user_id))
            ->when($request->action, fn($q) => $q->where('action', $request->action))
            ->when($request->id_asset, function ($q) use ($request) {
                $q->whereHas('asset', function ($assetQuery) use ($request) {
                    $assetQuery->where('id_asset', 'like', '%' . $request->id_asset . '%');
                });
            })
            ->when($request->activity_date, function ($q) use ($request) {
                $q->whereDate('created_at', $request->activity_date);
            })
            ->latest()
            ->paginate(10, ['*'], 'histories_page')
            ->withQueryString();

        $petugasList = User::whereIn('role', ['petugas', 'admin', 'administrator'])
            ->orderBy('full_name')
            ->get();

        return view('admin.reports.officers', compact('officers', 'histories', 'petugasList'));
    }

    public function exportCsv(Request $request): StreamedResponse
    {
        $assets = Asset::with(['province', 'regency', 'district', 'creator'])
            ->when($request->status, fn($q) => $q->where('status', $request->status))
            ->when($request->province_id, fn($q) => $q->where('province_id', $request->province_id))
            ->when($request->regency_id, fn($q) => $q->where('regency_id', $request->regency_id))
            ->when($request->district_id, fn($q) => $q->where('district_id', $request->district_id))
            ->orderBy('id_asset', 'asc')
            ->get();

        $fileName = 'laporan_aset.csv';

        return response()->streamDownload(function () use ($assets) {
            $handle = fopen('php://output', 'w');

            fputcsv($handle, [
                'ID Asset',
                'Status',
                'Provinsi',
                'Kabupaten/Kota',
                'Kecamatan',
                'Jenis Aset',
                'Klasifikasi',
                'Kelompok',
                'Luas m2',
                'Latitude',
                'Longitude',
                'Keterangan',
                'Google Maps',
                'Input Oleh',
                'Tanggal Dibuat',
                'Terakhir Diupdate',
            ]);

            foreach ($assets as $asset) {
                fputcsv($handle, [
                    $asset->id_asset,
                    $asset->status,
                    $asset->province?->name,
                    $asset->regency?->name,
                    $asset->district?->name,
                    $asset->asset_type,
                    $asset->classification,
                    $asset->asset_group,
                    $asset->area_m2,
                    $asset->latitude,
                    $asset->longitude,
                    $asset->description,
                    $asset->gmaps_url,
                    $asset->creator?->full_name,
                    $asset->created_at?->format('d-m-Y H:i'),
                    $asset->updated_at?->format('d-m-Y H:i'),
                ]);
            }

            fclose($handle);
        }, $fileName);
    }

    public function importForm()
    {
        return view('admin.reports.import');
    }

    public function downloadTemplate()
    {
        $fileName = 'template_import_aset.csv';

        return response()->streamDownload(function () {
            $handle = fopen('php://output', 'w');

            fputcsv($handle, [
                'id_asset',
                'status',
                'province',
                'regency',
                'district',
                'asset_type',
                'classification',
                'asset_group',
                'area_m2',
                'latitude',
                'longitude',
                'description',
            ]);

            fclose($handle);
        }, $fileName);
    }

    public function importStore(Request $request)
    {
        $request->validate([
            'file' => ['required', 'file', 'mimes:csv,txt'],
        ]);

        $file = fopen($request->file('file')->getRealPath(), 'r');

        if (!$file) {
            return back()->with('error', 'File tidak dapat dibaca.');
        }

        $header = fgetcsv($file);

        if (!$header) {
            fclose($file);
            return back()->with('error', 'File CSV kosong atau format tidak valid.');
        }

        $header = array_map(fn($item) => trim($item), $header);

        $requiredHeaders = [
            'id_asset',
            'status',
            'province',
            'regency',
            'district',
            'asset_type',
            'classification',
            'asset_group',
            'area_m2',
            'latitude',
            'longitude',
            'description',
        ];

        foreach ($requiredHeaders as $requiredHeader) {
            if (!in_array($requiredHeader, $header)) {
                fclose($file);
                return back()->with('error', 'Kolom ' . $requiredHeader . ' tidak ditemukan pada file CSV.');
            }
        }

        $successCount = 0;
        $errors = [];
        $rowNumber = 1;

        while (($row = fgetcsv($file)) !== false) {
            $rowNumber++;

            if (count(array_filter($row)) === 0) {
                continue;
            }

            $data = array_combine($header, $row);

            if (!$data) {
                $errors[] = "Baris {$rowNumber}: format kolom tidak sesuai.";
                continue;
            }

            $idAsset = trim($data['id_asset'] ?? '');
            $status = trim($data['status'] ?? '');
            $provinceName = trim($data['province'] ?? '');
            $regencyName = trim($data['regency'] ?? '');
            $districtName = trim($data['district'] ?? '');
            $assetType = trim($data['asset_type'] ?? '');
            $classification = trim($data['classification'] ?? '');
            $assetGroup = trim($data['asset_group'] ?? '');
            $areaM2 = trim($data['area_m2'] ?? '');
            $latitude = trim($data['latitude'] ?? '');
            $longitude = trim($data['longitude'] ?? '');
            $description = trim($data['description'] ?? '');

            if ($idAsset === '') {
                $errors[] = "Baris {$rowNumber}: id_asset wajib diisi.";
                continue;
            }

            if (Asset::where('id_asset', $idAsset)->exists()) {
                $errors[] = "Baris {$rowNumber}: ID aset {$idAsset} sudah ada.";
                continue;
            }

            if (!in_array($status, ['Clear', 'Proses', 'Masalah'])) {
                $errors[] = "Baris {$rowNumber}: status harus Clear, Proses, atau Masalah.";
                continue;
            }

            if (!in_array($assetType, ['Tanah', 'Bangunan'])) {
                $errors[] = "Baris {$rowNumber}: asset_type harus Tanah atau Bangunan.";
                continue;
            }

            if (!in_array($classification, ['ROW', 'Fasilitas', 'Operasional'])) {
                $errors[] = "Baris {$rowNumber}: classification harus ROW, Fasilitas, atau Operasional.";
                continue;
            }

            if (!in_array($assetGroup, ['Produksi', 'Non Produksi'])) {
                $errors[] = "Baris {$rowNumber}: asset_group harus Produksi atau Non Produksi.";
                continue;
            }

            $province = $this->findProvinceByName($provinceName);

            if (!$province) {
                $errors[] = "Baris {$rowNumber}: provinsi {$provinceName} tidak ditemukan.";
                continue;
            }

            $regency = $this->findRegencyByName($regencyName, $province->id);

            if (!$regency) {
                $errors[] = "Baris {$rowNumber}: kabupaten/kota {$regencyName} tidak sesuai dengan provinsi {$provinceName}.";
                continue;
            }

            $district = $this->findDistrictByName($districtName, $regency->id);

            if (!$district) {
                $errors[] = "Baris {$rowNumber}: kecamatan {$districtName} tidak sesuai dengan kabupaten/kota {$regencyName}.";
                continue;
            }

            if (!is_numeric($areaM2) || !is_numeric($latitude) || !is_numeric($longitude)) {
                $errors[] = "Baris {$rowNumber}: area_m2, latitude, dan longitude harus angka.";
                continue;
            }

            $asset = Asset::create([
                'id_asset' => $idAsset,
                'status' => $status,
                'province_id' => $province->id,
                'regency_id' => $regency->id,
                'district_id' => $district->id,
                'asset_type' => $assetType,
                'classification' => $classification,
                'asset_group' => $assetGroup,
                'area_m2' => $areaM2,
                'latitude' => $latitude,
                'longitude' => $longitude,
                'description' => $description,
                'gmaps_url' => 'https://maps.google.com/?q=' . $latitude . ',' . $longitude,
                'created_by' => auth()->id(),
                'updated_by' => auth()->id(),
            ]);

            AssetHistory::create([
                'asset_id' => $asset->id,
                'user_id' => auth()->id(),
                'action' => 'create',
                'notes' => 'Admin mengimpor data aset ' . $asset->id_asset,
            ]);

            $successCount++;
        }

        fclose($file);

        if (!empty($errors)) {
            return redirect()
                ->to(route('admin.reports.import.form') . '#import-result')
                ->with('import_errors', $errors)
                ->with('import_success_count', $successCount);
        }

        return redirect()
            ->to(route('admin.reports.import.form') . '#import-result')
            ->with('success', 'Data aset berhasil diimport. Total data masuk: ' . $successCount);
    }

    private function normalizeRegionName(string $value): string
    {
        $value = strtolower(trim($value));
        $value = str_replace(['kabupaten ', 'kab. ', 'kota ', 'kec. ', 'kecamatan '], '', $value);
        $value = preg_replace('/\s+/', ' ', $value);

        return trim($value);
    }

    private function findProvinceByName(string $name): ?Province
    {
        $target = $this->normalizeRegionName($name);

        return Province::get()->first(function ($province) use ($target) {
            return $this->normalizeRegionName($province->name) === $target;
        });
    }

    private function findRegencyByName(string $name, int $provinceId): ?Regency
    {
        $target = $this->normalizeRegionName($name);

        return Regency::where('province_id', $provinceId)
            ->get()
            ->first(function ($regency) use ($target) {
                return $this->normalizeRegionName($regency->name) === $target;
            });
    }

    private function findDistrictByName(string $name, int $regencyId): ?District
    {
        $target = $this->normalizeRegionName($name);

        return District::where('regency_id', $regencyId)
            ->get()
            ->first(function ($district) use ($target) {
                return $this->normalizeRegionName($district->name) === $target;
            });
    }
}