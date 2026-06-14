<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AssetHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function show(Request $request)
    {
        return response()->json(['data' => $request->user()]);
    }

    public function changePassword(Request $request)
    {
        $validated = $request->validate([
            'current_password' => ['required', 'string'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);

        $user = $request->user();

        if (!Hash::check($validated['current_password'], $user->password)) {
            return response()->json(['message' => 'Password lama salah'], 422);
        }

        $user->update([
            'password' => $validated['password'],
        ]);

        return response()->json(['message' => 'Password berhasil diubah']);
    }

    public function histories(Request $request)
    {
        $histories = AssetHistory::with(['asset', 'user'])
            ->where('user_id', $request->user()->id)
            ->latest()
            ->paginate(10);

        $histories->getCollection()->transform(function ($history) {
            return [
                'id' => $history->id,
                'action' => $history->action,
                'notes' => $history->notes,

                'asset' => [
                    'id_asset' => $history->asset?->id_asset ?? '',
                ],

                'user' => [
                    'full_name' => $history->user?->full_name ?? '',
                ],

                'created_at' => $history->created_at
                    ? $history->created_at
                        ->timezone('Asia/Jakarta')
                        ->translatedFormat('d F Y, H:i')
                    : '',
            ];
        });

        return response()->json($histories);
    }
}