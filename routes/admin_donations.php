<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DonationController;

Route::prefix('admin/donations')
    ->name('admin.donations.')
    ->middleware(['auth:admin'])
    ->group(function () {
        Route::get('/', [DonationController::class, 'index'])->name('index');
        Route::get('/walkins', [DonationController::class, 'walkins'])->name('walkins');
        Route::get('/{donation}', [DonationController::class, 'show'])->name('show');
        Route::put('/{donation}/status', [DonationController::class, 'updateStatus'])->name('update-status');
        Route::delete('/{donation}', [DonationController::class, 'destroy'])->name('destroy');
        Route::get('/export', [DonationController::class, 'export'])->name('export');
    });
