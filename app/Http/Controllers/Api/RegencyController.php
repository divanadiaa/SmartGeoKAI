<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Regency;
use Illuminate\Http\Request;

class RegencyController extends Controller
{
    public function index(Request $request)
    {
        $request->validate([
            'province_id' => ['required', 'exists:provinces,id'],
        ]);

        return response()->json([
            'data' => Regency::where('province_id', $request->province_id)
                ->orderBy('name')
                ->get()
        ]);
    }
}