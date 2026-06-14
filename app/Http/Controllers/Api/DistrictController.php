<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\District;
use Illuminate\Http\Request;

class DistrictController extends Controller
{
    public function index(Request $request)
    {
        $request->validate([
            'regency_id' => ['required', 'exists:regencies,id'],
        ]);

        return response()->json([
            'data' => District::where('regency_id', $request->regency_id)
                ->orderBy('name')
                ->get()
        ]);
    }
}