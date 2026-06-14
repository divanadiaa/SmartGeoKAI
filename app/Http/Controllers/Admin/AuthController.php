<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showRegister()
    {
        return view('admin.auth.register');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'full_name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:100', 'unique:users,username'],
            'nip' => ['required', 'string', 'max:50', 'unique:users,nip'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);

        User::create([
            'full_name' => $validated['full_name'],
            'username' => $validated['username'],
            'nip' => $validated['nip'],
            'password' => $validated['password'],
            'role' => 'admin',
            'is_active' => true,
        ]);

        return redirect()->route('admin.login')->with('success', 'Register admin berhasil. Silakan login.');
    }

    public function showLogin()
    {
        return view('admin.auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        if (!Auth::attempt($credentials, $request->boolean('remember'))) {
            return back()->withErrors([
                'username' => 'Username atau password salah.',
            ])->onlyInput('username');
        }

        $request->session()->regenerate();

        if (auth()->user()->role !== 'admin') {
            Auth::logout();
            return back()->withErrors([
                'username' => 'Akun ini bukan admin.',
            ]);
        }

        if (!auth()->user()->is_active) {
            Auth::logout();
            return back()->withErrors([
                'username' => 'Akun admin tidak aktif.',
            ]);
        }

        return redirect()->route('admin.dashboard');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login');
    }
}