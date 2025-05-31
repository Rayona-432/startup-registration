<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/registration', [App\Http\Controllers\RegistrationController::class, 'index'])->name('registration');
Route::post('/startup/register', [App\Http\Controllers\RegistrationController::class, 'store'])->name('startups.store');
Route::get('/payment/success', [App\Http\Controllers\PaymentController::class, 'success']);

Route::get('/login', [App\Http\Controllers\LoginController::class, 'index'])->name('login');
