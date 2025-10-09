<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth','role:admin'])->group(function () {
    Route::get('/admin/dashboard', function (){
        return view('admin.dashboard');
    });
});

Route::middleware(['auth','role:user'])->group(function () {
    Route::get('/user/dashboard', function (){
        return view('user.dashboard');
    });
});
