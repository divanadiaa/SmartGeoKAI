<?php

use App\Http\Controllers\Admin\AssetController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\RegionController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('admin.login');
});

Route::prefix('admin')->name('admin.')->group(function () {
    Route::middleware('guest')->group(function () {
        Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
        Route::post('/login', [AuthController::class, 'login'])->name('login.store');
    });

    Route::middleware(['auth', 'admin.only'])->group(function () {
        Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        Route::resource('/users', UserController::class);
        Route::patch('/users/{user}/toggle-active', [UserController::class, 'toggleActive'])->name('users.toggle-active');

        Route::resource('/assets', AssetController::class);

        Route::get('/assets/{id}/delete-image/{imageId}', [AssetController::class, 'deleteImage'])->name('assets.deleteImage');

        Route::get('/assets/{id}/delete-document/{documentId}',[AssetController::class, 'deleteDocument'])->name('assets.deleteDocument');
        Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');

        Route::get('/reports/export/csv', [ReportController::class, 'exportCsv'])->name('reports.export.csv');
        Route::get('/reports/officers', [ReportController::class, 'officers'])->name('reports.officers');

        Route::get('/reports/import', [ReportController::class, 'importForm'])
            ->name('reports.import.form');

        Route::post('/reports/import', [ReportController::class, 'importStore'])
            ->name('reports.import.store');

        Route::get('/reports/import/template', [ReportController::class, 'downloadTemplate'])
            ->name('reports.import.template');

        Route::prefix('regions')->name('regions.')->group(function () {
            Route::get('/regencies',[RegionController::class, 'regencies'])->name('regencies');
            Route::get('/districts', [RegionController::class, 'districts'])->name('districts');
        });
    });
});