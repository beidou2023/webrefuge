<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth','role:1'])->group(function () {
    Route::get('/user/dashboard', function (){
        return view('user.dashboard');
    });
});

Route::middleware(['auth','role:2'])->group(function () {
    Route::get('/manager/dashboard', function (){
        return view('manager.dashboard');
    });
});

Route::middleware(['auth','role:3'])->group(function () {
    Route::get('/admin/dashboard', function (){
        return view('admin.dashboard');
    });
});
