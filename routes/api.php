<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\StartupApiController;

Route::prefix('api')->middleware('api')->group(function () {
    Route::apiResource('startups', StartupApiController::class);
    Route::post('startups/verify-payment', [StartupApiController::class, 'verifyPayment']);
});