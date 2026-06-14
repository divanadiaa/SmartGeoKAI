<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query()
            ->when($request->search, function ($q) use ($request) {
                $q->where(function ($qq) use ($request) {
                    $qq->where('full_name', 'like', '%' . $request->search . '%')
                        ->orWhere('username', 'like', '%' . $request->search . '%')
                        ->orWhere('nip', 'like', '%' . $request->search . '%');
                });
            })
            ->latest();

        $users = $query->paginate(10);

        $stats = [
            'total_users' => User::count(),
            'total_admins' => User::where('role', 'admin')->count(),
            'total_petugas' => User::where('role', 'petugas')->count(),
            'active_users' => User::where('is_active', true)->count(),
        ];

        return view('admin.users.index', compact('users', 'stats'));
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'full_name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:100', 'unique:users,username'],
            'nip' => ['required', 'string', 'max:50', 'unique:users,nip'],
            'role' => ['required', 'in:admin,petugas'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        User::create([
            'full_name' => $validated['full_name'],
            'username' => $validated['username'],
            'nip' => $validated['nip'],
            'role' => $validated['role'],
            'password' => bcrypt($validated['password']),
            'is_active' => $request->boolean('is_active'),
        ]);

        return redirect()
            ->to(route('admin.users.index') . '#table-users')
            ->with('success', 'Berhasil menambahkan user baru.');
    }

    public function show(User $user)
    {
        return view('admin.users.show', compact('user'));
    }

    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'full_name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:100', 'unique:users,username,' . $user->id],
            'nip' => ['required', 'string', 'max:50', 'unique:users,nip,' . $user->id],
            'role' => ['required', 'in:admin,petugas'],
            'password' => ['nullable', 'string', 'min:6', 'confirmed'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $data = [
            'full_name' => $validated['full_name'],
            'username' => $validated['username'],
            'nip' => $validated['nip'],
            'role' => $validated['role'],
            'is_active' => $request->boolean('is_active'),
        ];

        if (!empty($validated['password'])) {
            $data['password'] = bcrypt($validated['password']);
        }

        $user->update($data);

        return redirect()
            ->to(route('admin.users.index') . '#table-users')
            ->with('success', 'Berhasil mengupdate data user.');
    }

    public function destroy(User $user)
    {
        if (auth()->id() === $user->id) {
            return back()->with('error', 'Admin tidak bisa menghapus akun sendiri.');
        }

        $user->delete();

        return redirect()
            ->to(route('admin.users.index') . '#table-users')
            ->with('success', 'Berhasil menghapus data user.');
    }

    public function toggleActive(User $user)
    {
        if (auth()->id() === $user->id) {
            return back()->with('error', 'Admin tidak bisa menonaktifkan akun sendiri.');
        }

        $user->update([
            'is_active' => !$user->is_active,
        ]);

        return redirect()
            ->to(route('admin.users.index') . '#table-users')
            ->with('success', 'Berhasil mengubah status user.');
    }
}