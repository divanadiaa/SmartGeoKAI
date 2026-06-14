<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\Concerns\ApiResponse;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    use ApiResponse;

    public function login(Request $request)
    {
        $validated = $request->validate([
            'username' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        $user = User::where('username', $validated['username'])->first();

        if (!$user || !Hash::check($validated['password'], $user->password)) {
            return $this->errorResponse('Username atau password salah', 422);
        }

        if ($user->role !== 'petugas') {
            return $this->errorResponse('Akun ini bukan petugas', 403);
        }

        if (!$user->is_active) {
            return $this->errorResponse('Akun petugas tidak aktif', 403);
        }

        $user->tokens()->delete();
        $token = $user->createToken('petugas-token')->plainTextToken;

        return $this->successResponse([
            'token' => $token,
            'user' => $user,
        ], 'Login berhasil');
    }

    public function me(Request $request)
    {
        return $this->successResponse($request->user(), 'Data profile berhasil diambil');
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()?->delete();

        return $this->successResponse(null, 'Logout berhasil');
    }
}