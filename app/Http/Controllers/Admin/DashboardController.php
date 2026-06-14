<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Asset;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $totalAssets = Asset::count();
        $clearAssets = Asset::where('status', 'Clear')->count();
        $prosesAssets = Asset::where('status', 'Proses')->count();
        $masalahAssets = Asset::where('status', 'Masalah')->count();

        $totalUsers = User::count();
        $totalAdmins = User::where('role', 'admin')->count();
        $totalPetugas = User::where('role', 'petugas')->count();
        $activeUsers = User::where('is_active', true)->count();

        $latestAssets = Asset::with(['province', 'regency', 'district', 'creator'])
            ->latest()
            ->take(10)
            ->get();

        return view('admin.dashboard.index', compact(
            'totalAssets',
            'clearAssets',
            'prosesAssets',
            'masalahAssets',
            'totalUsers',
            'totalAdmins',
            'totalPetugas',
            'activeUsers',
            'latestAssets'
        ));
    }
}