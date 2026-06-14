<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\District;
use App\Models\Regency;
use Illuminate\Http\Request;

class RegionController extends Controller
{
    public function regencies(Request $request)
    {
        $validated = $request->validate([
            'province_id' => ['required', 'exists:provinces,id'],
        ]);

        $regencies = Regency::where('province_id', $validated['province_id'])
            ->orderBy('name')
            ->get(['id', 'name']);

        return response()->json([
            'data' => $regencies,
        ]);
    }

    public function districts(Request $request)
    {
        $validated = $request->validate([
            'regency_id' => ['required', 'exists:regencies,id'],
        ]);

        $districts = District::where('regency_id', $validated['regency_id'])
            ->orderBy('name')
            ->get(['id', 'name']);

        return response()->json([
            'data' => $districts,
        ]);
    }
}