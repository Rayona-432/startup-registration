<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\StartupController; 

Route::resource('startups', StartupController::class); // AJAX route to verify payment
Route::post('/startups/verify-payment', [StartupController::class,'verifyPayment'])->name('startups.verifyPayment');

Route::get('/', function () {
    return view('welcome');
});
