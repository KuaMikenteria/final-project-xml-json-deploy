<?php

use App\Http\Controllers\ReservationController;
use Illuminate\Support\Facades\Route;

Route::prefix('reservations')->group(function () {
    Route::get('/', [ReservationController::class, 'index']);
    Route::post('/', [ReservationController::class, 'store']);
    Route::get('/{reservation}', [ReservationController::class, 'show']);
    Route::put('/{reservation}', [ReservationController::class, 'update']);
    Route::patch('/{reservation}', [ReservationController::class, 'update']);
    Route::delete('/{reservation}', [ReservationController::class, 'destroy']);
});


