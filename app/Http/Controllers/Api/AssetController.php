<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Asset;
use App\Models\AssetHistory;
use App\Models\District;
use App\Models\Regency;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class AssetController extends Controller
{
    public function index(Request $request)
    {
        $perPage = (int) $request->get('per_page', 10);

        if ($perPage < 1) {
            $perPage = 10;
        }

        if ($perPage > 2000) {
            $perPage = 2000;
        }

        $assets = Asset::with(['province', 'regency', 'district', 'images'])
            ->when($request->province_id, fn ($q) => $q->where('province_id', $request->province_id))
            ->when($request->regency_id, fn ($q) => $q->where('regency_id', $request->regency_id))
            ->when($request->district_id, fn ($q) => $q->where('district_id', $request->district_id))
            ->when($request->asset_type, fn ($q) => $q->where('asset_type', $request->asset_type))
            ->when($request->classification, fn ($q) => $q->where('classification', $request->classification))
            ->when($request->asset_group, fn ($q) => $q->where('asset_group', $request->asset_group))
            ->when($request->status, fn ($q) => $q->where('status', $request->status))
            ->when($request->search, function ($q) use ($request) {
                $search = $request->search;

                $q->where(function ($qq) use ($search) {
                    $qq->where('id_asset', 'like', "%{$search}%")
                        ->orWhereHas('province', fn ($p) => $p->where('name', 'like', "%{$search}%"))
                        ->orWhereHas('regency', fn ($r) => $r->where('name', 'like', "%{$search}%"))
                        ->orWhereHas('district', fn ($d) => $d->where('name', 'like', "%{$search}%"));
                });
            })
            ->orderBy('id_asset', 'asc')
            ->paginate($perPage);

        $assets->getCollection()->transform(function ($asset) {
            return [
                'id' => $asset->id,
                'id_asset' => $asset->id_asset,
                'status' => $asset->status,
                'province' => [
                    'name' => $asset->province?->name,
                ],
                'regency' => [
                    'name' => $asset->regency?->name,
                ],
                'district' => [
                    'name' => $asset->district?->name,
                ],
                'asset_type' => $asset->asset_type,
                'classification' => $asset->classification,
                'asset_group' => $asset->asset_group,
                'area_m2' => (float) $asset->area_m2,
                'latitude' => (float) $asset->latitude,
                'longitude' => (float) $asset->longitude,
                'description' => $asset->description,
                'thumbnail_url' => $asset->images->first()
                    ? asset('storage/' . $asset->images->first()->file_path)
                    : null,
            ];
        });

        return response()->json($assets);
    }

    public function map(Request $request)
    {
        $assets = Asset::with(['province', 'regency', 'district', 'images'])
            ->when($request->province_id, fn ($q) => $q->where('province_id', $request->province_id))
            ->when($request->regency_id, fn ($q) => $q->where('regency_id', $request->regency_id))
            ->when($request->district_id, fn ($q) => $q->where('district_id', $request->district_id))
            ->when($request->asset_type, fn ($q) => $q->where('asset_type', $request->asset_type))
            ->when($request->status, fn ($q) => $q->where('status', $request->status))
            ->when($request->search, function ($q) use ($request) {
                $search = $request->search;

                $q->where(function ($qq) use ($search) {
                    $qq->where('id_asset', 'like', "%{$search}%")
                        ->orWhereHas('province', fn ($p) => $p->where('name', 'like', "%{$search}%"))
                        ->orWhereHas('regency', fn ($r) => $r->where('name', 'like', "%{$search}%"))
                        ->orWhereHas('district', fn ($d) => $d->where('name', 'like', "%{$search}%"));
                });
            })
            ->orderBy('id_asset', 'asc')
            ->get()
            ->map(function ($asset) {
                return [
                    'id' => $asset->id,
                    'id_asset' => $asset->id_asset,
                    'status' => $asset->status,
                    'province' => [
                        'name' => $asset->province?->name,
                    ],
                    'regency' => [
                        'name' => $asset->regency?->name,
                    ],
                    'district' => [
                        'name' => $asset->district?->name,
                    ],
                    'asset_type' => $asset->asset_type,
                    'classification' => $asset->classification,
                    'asset_group' => $asset->asset_group,
                    'area_m2' => (float) $asset->area_m2,
                    'latitude' => (float) $asset->latitude,
                    'longitude' => (float) $asset->longitude,
                    'description' => $asset->description,
                    'thumbnail_url' => $asset->images->first()
                        ? asset('storage/' . $asset->images->first()->file_path)
                        : null,
                ];
            })
            ->values();

        return response()->json([
            'data' => $assets,
        ]);
    }

    public function show(Asset $asset)
    {
        $asset->load([
            'province',
            'regency',
            'district',
            'images',
            'documents',
            'creator',
        ]);

        return response()->json([
            'data' => [
                'id' => $asset->id,
                'id_asset' => $asset->id_asset,
                'status' => $asset->status,
                'province_id' => $asset->province_id,
                'province' => $asset->province?->name,
                'regency_id' => $asset->regency_id,
                'regency' => $asset->regency?->name,
                'district_id' => $asset->district_id,
                'district' => $asset->district?->name,
                'asset_type' => $asset->asset_type,
                'classification' => $asset->classification,
                'asset_group' => $asset->asset_group,
                'area_m2' => (float) $asset->area_m2,
                'latitude' => (float) $asset->latitude,
                'longitude' => (float) $asset->longitude,
                'description' => $asset->description,
                'gmaps_url' => $asset->gmaps_url,

                'images' => $asset->images->map(fn ($image) => [
                    'id' => $image->id,
                    'url' => asset('storage/' . $image->file_path),
                    'file_name' => $image->file_name,
                    'file_size' => $image->file_size,
                    'uploaded_at' => $image->created_at?->format('d-m-Y H:i'),
                ])->values(),

                'documents' => $asset->documents->map(fn ($document) => [
                    'id' => $document->id,
                    'url' => asset('storage/' . $document->file_path),
                    'file_name' => $document->file_name,
                    'file_size' => $document->file_size,
                    'file_type' => $document->file_type,
                    'uploaded_at' => $document->created_at?->format('d-m-Y H:i'),
                ])->values(),

                'created_by' => [
                    'id' => $asset->creator?->id,
                    'name' => $asset->creator?->full_name,
                ],
            ],
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_asset' => ['required', 'string', 'max:100', 'unique:assets,id_asset'],
            'province_id' => ['required', 'exists:provinces,id'],
            'regency_id' => ['required', 'exists:regencies,id'],
            'district_id' => ['required', 'exists:districts,id'],
            'asset_type' => ['required', 'in:Tanah,Bangunan'],
            'classification' => ['required', 'in:ROW,Fasilitas,Operasional'],
            'asset_group' => ['required', 'in:Produksi,Non Produksi'],
            'status' => ['required', 'in:Clear,Proses,Masalah'],
            'area_m2' => ['required', 'numeric', 'min:0'],
            'latitude' => ['required', 'numeric'],
            'longitude' => ['required', 'numeric'],
            'description' => ['nullable', 'string'],
            'images' => ['nullable', 'array', 'max:10'],
            'images.*' => ['image', 'max:2048'],
            'documents' => ['nullable', 'array', 'max:10'],
            'documents.*' => ['file', 'mimes:pdf,doc,docx,xls,xlsx', 'max:5120'],
        ]);

        $regency = Regency::findOrFail($validated['regency_id']);
        $district = District::findOrFail($validated['district_id']);

        if ((int) $regency->province_id !== (int) $validated['province_id']) {
            return response()->json(['message' => 'Kabupaten/Kota tidak sesuai dengan provinsi'], 422);
        }

        if ((int) $district->regency_id !== (int) $validated['regency_id']) {
            return response()->json(['message' => 'Kecamatan tidak sesuai dengan kabupaten/kota'], 422);
        }

        $assetData = $validated;
        unset($assetData['images'], $assetData['documents']);

        $asset = DB::transaction(function () use ($request, $assetData) {
            $asset = Asset::create([
                ...$assetData,
                'gmaps_url' => "https://maps.google.com/?q={$assetData['latitude']},{$assetData['longitude']}",
                'created_by' => $request->user()->id,
                'updated_by' => $request->user()->id,
            ]);

            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $file) {
                    $path = $file->store('assets', 'public');

                    $asset->images()->create([
                        'file_path' => $path,
                        'file_name' => $file->getClientOriginalName(),
                        'file_size' => $file->getSize(),
                    ]);
                }
            }

            if ($request->hasFile('documents')) {
                foreach ($request->file('documents') as $file) {
                    $path = $file->store('asset-documents', 'public');

                    $asset->documents()->create([
                        'file_path' => $path,
                        'file_name' => $file->getClientOriginalName(),
                        'file_size' => $file->getSize(),
                        'file_type' => $file->getClientOriginalExtension(),
                    ]);
                }
            }

            AssetHistory::create([
                'asset_id' => $asset->id,
                'user_id' => $request->user()->id,
                'action' => 'create',
                'notes' => 'Menambahkan aset baru dengan ID aset ' . $asset->id_asset,
            ]);

            return $asset;
        });

        return response()->json([
            'message' => 'Aset berhasil ditambahkan',
            'data' => $asset->load(['province', 'regency', 'district', 'images', 'documents']),
        ], 201);
    }

    public function update(Request $request, Asset $asset)
    {
        $validated = $request->validate([
            'id_asset' => ['required', 'string', 'max:100', 'unique:assets,id_asset,' . $asset->id],
            'province_id' => ['required', 'exists:provinces,id'],
            'regency_id' => ['required', 'exists:regencies,id'],
            'district_id' => ['required', 'exists:districts,id'],
            'asset_type' => ['required', 'in:Tanah,Bangunan'],
            'classification' => ['required', 'in:ROW,Fasilitas,Operasional'],
            'asset_group' => ['required', 'in:Produksi,Non Produksi'],
            'status' => ['required', 'in:Clear,Proses,Masalah'],
            'area_m2' => ['required', 'numeric', 'min:0'],
            'latitude' => ['required', 'numeric'],
            'longitude' => ['required', 'numeric'],
            'description' => ['nullable', 'string'],
            'images' => ['nullable', 'array', 'max:10'],
            'images.*' => ['image', 'max:2048'],
            'documents' => ['nullable', 'array', 'max:10'],
            'documents.*' => ['file', 'mimes:pdf,doc,docx,xls,xlsx', 'max:5120'],
        ]);

        $regency = Regency::findOrFail($validated['regency_id']);
        $district = District::findOrFail($validated['district_id']);

        if ((int) $regency->province_id !== (int) $validated['province_id']) {
            return response()->json(['message' => 'Kabupaten/Kota tidak sesuai dengan provinsi'], 422);
        }

        if ((int) $district->regency_id !== (int) $validated['regency_id']) {
            return response()->json(['message' => 'Kecamatan tidak sesuai dengan kabupaten/kota'], 422);
        }

        $assetData = $validated;
        unset($assetData['images'], $assetData['documents']);

        DB::transaction(function () use ($request, $assetData, $asset) {
            $oldIdAsset = $asset->id_asset;

            $asset->update([
                ...$assetData,
                'gmaps_url' => "https://maps.google.com/?q={$assetData['latitude']},{$assetData['longitude']}",
                'updated_by' => $request->user()->id,
            ]);

            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $file) {
                    $path = $file->store('assets', 'public');

                    $asset->images()->create([
                        'file_path' => $path,
                        'file_name' => $file->getClientOriginalName(),
                        'file_size' => $file->getSize(),
                    ]);
                }
            }

            if ($request->hasFile('documents')) {
                foreach ($request->file('documents') as $file) {
                    $path = $file->store('asset-documents', 'public');

                    $asset->documents()->create([
                        'file_path' => $path,
                        'file_name' => $file->getClientOriginalName(),
                        'file_size' => $file->getSize(),
                        'file_type' => $file->getClientOriginalExtension(),
                    ]);
                }
            }

            AssetHistory::create([
                'asset_id' => $asset->id,
                'user_id' => $request->user()->id,
                'action' => 'update',
                'notes' => 'Mengubah data aset ' . $oldIdAsset,
            ]);
        });

        return response()->json([
            'message' => 'Aset berhasil diupdate',
            'data' => $asset->load(['province', 'regency', 'district', 'images', 'documents']),
        ]);
    }

    public function deleteImage(Request $request, Asset $asset, $imageId)
    {
        $image = $asset->images()->where('id', $imageId)->firstOrFail();

        DB::transaction(function () use ($request, $asset, $image) {
            if (Storage::disk('public')->exists($image->file_path)) {
                Storage::disk('public')->delete($image->file_path);
            }

            $image->delete();

            AssetHistory::create([
                'asset_id' => $asset->id,
                'user_id' => $request->user()->id,
                'action' => 'update',
                'notes' => 'Menghapus salah satu gambar aset ' . $asset->id_asset,
            ]);
        });

        return response()->json([
            'message' => 'Gambar aset berhasil dihapus',
        ]);
    }

    public function deleteDocument(Request $request, Asset $asset, $documentId)
    {
        $document = $asset->documents()->where('id', $documentId)->firstOrFail();

        DB::transaction(function () use ($request, $asset, $document) {
            if (Storage::disk('public')->exists($document->file_path)) {
                Storage::disk('public')->delete($document->file_path);
            }

            $document->delete();

            AssetHistory::create([
                'asset_id' => $asset->id,
                'user_id' => $request->user()->id,
                'action' => 'update',
                'notes' => 'Menghapus dokumen aset ' . $asset->id_asset,
            ]);
        });

        return response()->json([
            'message' => 'Dokumen aset berhasil dihapus',
        ]);
    }

    public function destroy(Request $request, Asset $asset)
    {
        DB::transaction(function () use ($request, $asset) {

            foreach ($asset->images as $image) {
                if (Storage::disk('public')->exists($image->file_path)) {
                    Storage::disk('public')->delete($image->file_path);
                }
            }

            foreach ($asset->documents as $document) {
                if (Storage::disk('public')->exists($document->file_path)) {
                    Storage::disk('public')->delete($document->file_path);
                }
            }

            $asset->delete();
        });

        return response()->json([
            'message' => 'Aset berhasil dihapus',
        ]);
    }
}