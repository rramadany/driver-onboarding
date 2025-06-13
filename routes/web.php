<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\DriverController;
use App\Http\Controllers\Admin\UserManagementController;
use App\Http\Controllers\Admin\AuditLogController;
use App\Http\Controllers\ReportController;

Route::middleware('guest')->group(function () {
    Route::get('login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('login', [AuthenticatedSessionController::class, 'store']);
});

Route::middleware('auth')->group(function () {
    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

    Route::get('/', function () {
        return redirect()->route('drivers.index');
    })->name('dashboard');


    Route::prefix('drivers')->name('drivers.')->group(function () {
        // HR & Supervisor & Admin //
        Route::middleware('can:manage-drivers')->group(function () {
            Route::get('/create', [DriverController::class, 'create'])->name('create');
            Route::post('/', [DriverController::class, 'store'])->name('store');
            Route::get('/{driver}/edit', [DriverController::class, 'edit'])->name('edit');
            Route::put('/{driver}', [DriverController::class, 'update'])->name('update');
            Route::delete('/{driver}', [DriverController::class, 'destroy'])->name('destroy');
            Route::post('/{driver}/submit', [DriverController::class, 'submit'])->name('submit');
        });

        // Supervisor & Admin //
        Route::middleware('can:approve-drivers')->group(function () {
            Route::post('/{driver}/approve', [DriverController::class, 'approve'])->name('approve');
            Route::post('/{driver}/reject', [DriverController::class, 'reject'])->name('reject');
        });

        // Everyone //
        // This overlaps with manage-drivers
        Route::get('/', [DriverController::class, 'index'])->name('index');
        Route::get('/{driver}', [DriverController::class, 'show'])->name('show');
        Route::get('/{driver}/export-pdf', [DriverController::class, 'exportPdf'])->name('export.pdf');
        Route::get('/{driver}/document/{type}', [DriverController::class, 'showDocument'])->name('document.show');
    });

    // Everyone//
    // I know it looks ugly but I think having a separate controller for bulk exports is a Good Thing
    Route::prefix('reports')->name('reports.')->group(function () {
        Route::get('/drivers/export/xlsx', [ReportController::class, 'exportDriversXLSX'])->name('drivers.export.xlsx');
        Route::get('/drivers/export/csv', [ReportController::class, 'exportDriversCSV'])->name('drivers.export.csv');
    });

    // Admin Only //
    Route::middleware('can:manage-users')->prefix('admin')->name('admin.')->group(function () {
        Route::resource('users', UserManagementController::class);
        Route::get('audit-logs', [AuditLogController::class, 'index'])->name('audit-logs.index');
    });

});