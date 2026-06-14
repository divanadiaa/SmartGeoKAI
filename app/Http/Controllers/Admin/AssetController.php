<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Asset;
use App\Models\AssetHistory;
use App\Models\AssetDocument;
use App\Models\District;
use App\Models\Province;
use App\Models\Regency;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class AssetController extends Controller
{
    public function index(Request $request)
    {
        $sort = strtolower($request->get('sort', 'desc'));

        if (!in_array($sort, ['asc', 'desc'])) {
            $sort = 'desc';
        }

        $assets = Asset::with(['province', 'regency', 'district', 'creator'])
            ->when($request->id_asset, fn ($q) => $q->where('id_asset', 'like', '%' . $request->id_asset . '%'))
            ->when($request->status, fn ($q) => $q->where('status', $request->status))
            ->when($request->asset_type, fn ($q) => $q->where('asset_type', $request->asset_type))
            ->when($request->province_id, fn ($q) => $q->where('province_id', $request->province_id))
            ->when($request->regency_id, fn ($q) => $q->where('regency_id', $request->regency_id))
            ->when($request->district_id, fn ($q) => $q->where('district_id', $request->district_id))
            ->orderBy('id_asset', $sort)
            ->paginate(10)
            ->withQueryString();

        $provinces = Province::orderBy('name')->get();

        $regencies = $request->province_id
            ? Regency::where('province_id', $request->province_id)->orderBy('name')->get()
            : collect();

        $districts = $request->regency_id
            ? District::where('regency_id', $request->regency_id)->orderBy('name')->get()
            : collect();

        return view('admin.assets.index', compact(
            'assets',
            'provinces',
            'regencies',
            'districts',
            'sort'
        ));
    }

    public function create()
    {
        $provinces = Province::orderBy('name')->get();

        return view('admin.assets.create', compact('provinces'));
    }

    public function store(Request $request)
    {
        try {
            $validated = $this->validateAsset($request);

            $this->validateRegionRelation(
                (int) $validated['province_id'],
                (int) $validated['regency_id'],
                (int) $validated['district_id']
            );

            DB::transaction(function () use ($request, $validated) {
                $asset = Asset::create([
                    'id_asset' => $validated['id_asset'],
                    'province_id' => $validated['province_id'],
                    'regency_id' => $validated['regency_id'],
                    'district_id' => $validated['district_id'],
                    'asset_type' => $validated['asset_type'],
                    'classification' => $validated['classification'],
                    'asset_group' => $validated['asset_group'],
                    'status' => $validated['status'],
                    'area_m2' => $validated['area_m2'],
                    'latitude' => $validated['latitude'],
                    'longitude' => $validated['longitude'],
                    'description' => $validated['description'] ?? null,
                    'gmaps_url' => !empty($validated['gmaps_url'])
                        ? $validated['gmaps_url']
                        : "https://maps.google.com/?q={$validated['latitude']},{$validated['longitude']}",
                    'created_by' => auth()->id(),
                    'updated_by' => auth()->id(),
                ]);

                $this->storeImages($request, $asset);
                $this->storeDocuments($request, $asset);

                AssetHistory::create([
                    'asset_id' => $asset->id,
                    'user_id' => auth()->id(),
                    'action' => 'create',
                    'notes' => 'Admin menambahkan data aset ' . $asset->id_asset,
                ]);
            });

            return redirect()
                ->to(route('admin.assets.index') . '#table-assets')
                ->with('success', 'Berhasil menambahkan data aset ' . $validated['id_asset'] . '.');
        } catch (ValidationException $e) {
            throw $e;
        } catch (\Throwable $e) {
            report($e);

            return back()
                ->withInput()
                ->with('error', 'Gagal menambahkan data aset.');
        }
    }

    public function show(Asset $asset)
    {
        $asset->load([
            'province',
            'regency',
            'district',
            'creator',
            'images',
            'documents',
        ]);

        return view('admin.assets.show', compact('asset'));
    }

    public function edit(Asset $asset)
    {
        $asset->load(['images', 'documents']);

        $provinces = Province::orderBy('name')->get();
        $regencies = Regency::where('province_id', $asset->province_id)->orderBy('name')->get();
        $districts = District::where('regency_id', $asset->regency_id)->orderBy('name')->get();

        return view('admin.assets.edit', compact('asset', 'provinces', 'regencies', 'districts'));
    }

    public function update(Request $request, Asset $asset)
    {
        try {
            $validated = $this->validateAsset($request, $asset->id);

            $this->validateRegionRelation(
                (int) $validated['province_id'],
                (int) $validated['regency_id'],
                (int) $validated['district_id']
            );

            DB::transaction(function () use ($request, $validated, $asset) {
                $asset->update([
                    'id_asset' => $validated['id_asset'],
                    'province_id' => $validated['province_id'],
                    'regency_id' => $validated['regency_id'],
                    'district_id' => $validated['district_id'],
                    'asset_type' => $validated['asset_type'],
                    'classification' => $validated['classification'],
                    'asset_group' => $validated['asset_group'],
                    'status' => $validated['status'],
                    'area_m2' => $validated['area_m2'],
                    'latitude' => $validated['latitude'],
                    'longitude' => $validated['longitude'],
                    'description' => $validated['description'] ?? null,
                    'gmaps_url' => !empty($validated['gmaps_url'])
                        ? $validated['gmaps_url']
                        : "https://maps.google.com/?q={$validated['latitude']},{$validated['longitude']}",
                    'updated_by' => auth()->id(),
                ]);

                $this->storeImages($request, $asset);
                $this->storeDocuments($request, $asset);

                AssetHistory::create([
                    'asset_id' => $asset->id,
                    'user_id' => auth()->id(),
                    'action' => 'update',
                    'notes' => 'Admin mengubah data aset ' . $asset->id_asset,
                ]);
            });

            return redirect()
                ->to(route('admin.assets.index') . '#table-assets')
                ->with('success', 'Berhasil mengupdate data aset ' . $validated['id_asset'] . '.');
        } catch (ValidationException $e) {
            throw $e;
        } catch (\Throwable $e) {
            report($e);

            return back()
                ->withInput()
                ->with('error', 'Gagal mengupdate data aset.');
        }
    }

    public function deleteImage($id, $imageId)
    {
        try {
            $asset = Asset::with('images')->findOrFail($id);
            $image = $asset->images()->where('id', $imageId)->firstOrFail();

            DB::transaction(function () use ($asset, $image) {
                if (Storage::disk('public')->exists($image->file_path)) {
                    Storage::disk('public')->delete($image->file_path);
                }

                $image->delete();

                AssetHistory::create([
                    'asset_id' => $asset->id,
                    'user_id' => auth()->id(),
                    'action' => 'update',
                    'notes' => 'Admin menghapus salah satu gambar aset ' . $asset->id_asset,
                ]);
            });

            return back()->with('success', 'Gambar aset berhasil dihapus.');
        } catch (\Throwable $e) {
            report($e);

            return back()->with('error', 'Gagal menghapus gambar aset.');
        }
    }

    public function deleteDocument($id, $documentId)
    {
        try {
            $asset = Asset::with('documents')->findOrFail($id);
            $document = $asset->documents()->where('id', $documentId)->firstOrFail();

            DB::transaction(function () use ($asset, $document) {
                if (Storage::disk('public')->exists($document->file_path)) {
                    Storage::disk('public')->delete($document->file_path);
                }

                $document->delete();

                AssetHistory::create([
                    'asset_id' => $asset->id,
                    'user_id' => auth()->id(),
                    'action' => 'update',
                    'notes' => 'Admin menghapus dokumen aset ' . $asset->id_asset,
                ]);
            });

            return back()->with('success', 'Dokumen aset berhasil dihapus.');
        } catch (\Throwable $e) {
            report($e);

            return back()->with('error', 'Gagal menghapus dokumen aset.');
        }
    }

    public function downloadDocument(AssetDocument $document)
    {
        return response()->download(
            storage_path('app/public/' . $document->file_path),
            $document->file_name
        );
    }

    public function destroy(Asset $asset)
    {
        try {
            $idAsset = $asset->id_asset;

            $asset->load(['images', 'documents']);

            DB::transaction(function () use ($asset, $idAsset) {
                AssetHistory::create([
                    'asset_id' => $asset->id,
                    'user_id' => auth()->id(),
                    'action' => 'delete',
                    'notes' => 'Admin menghapus data aset ' . $idAsset,
                ]);

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

            return redirect()
                ->to(route('admin.assets.index') . '#table-assets')
                ->with('success', 'Berhasil menghapus data aset ' . $idAsset . '.');
        } catch (\Throwable $e) {
            report($e);

            return back()->with('error', 'Gagal menghapus data aset.');
        }
    }

    private function validateAsset(Request $request, ?int $assetId = null): array
    {
        return $request->validate([
            'id_asset' => ['required', 'string', 'max:100', 'unique:assets,id_asset,' . $assetId],
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
            'gmaps_url' => ['nullable', 'url'],

            'images' => ['nullable', 'array', 'max:10'],
            'images.*' => ['image', 'max:5120'],

            'documents' => ['nullable', 'array', 'max:10'],
            'documents.*' => ['file', 'mimes:pdf,doc,docx,xls,xlsx', 'max:10240'],
        ], [
            'images.*.image' => 'File gambar harus berupa JPG, PNG, WEBP, atau format gambar lainnya.',
            'images.*.max' => 'Ukuran gambar maksimal 5 MB per file.',

            'documents.*.mimes' => 'Dokumen harus berformat PDF, DOC, DOCX, XLS, atau XLSX.',
            'documents.*.max' => 'Ukuran dokumen maksimal 10 MB per file.',
        ]);
    }

    private function validateRegionRelation(int $provinceId, int $regencyId, int $districtId): void
    {
        $regency = Regency::findOrFail($regencyId);
        $district = District::findOrFail($districtId);

        if ((int) $regency->province_id !== $provinceId) {
            throw ValidationException::withMessages([
                'regency_id' => 'Kabupaten/Kota tidak sesuai dengan provinsi yang dipilih.',
            ]);
        }

        if ((int) $district->regency_id !== $regencyId) {
            throw ValidationException::withMessages([
                'district_id' => 'Kecamatan tidak sesuai dengan kabupaten/kota yang dipilih.',
            ]);
        }
    }

    private function storeImages(Request $request, Asset $asset): void
    {
        if (!$request->hasFile('images')) {
            return;
        }

        foreach ($request->file('images') as $file) {
            $path = $file->store('assets', 'public');

            $asset->images()->create([
                'file_path' => $path,
                'file_name' => $file->getClientOriginalName(),
                'file_size' => $file->getSize(),
            ]);
        }
    }

    private function storeDocuments(Request $request, Asset $asset): void
    {
        if (!$request->hasFile('documents')) {
            return;
        }

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
}