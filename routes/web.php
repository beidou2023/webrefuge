<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SpecialRatController;

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

Route::get('/', [HomeController::class, 'index'])->name('index');
Route::get('/cares', [HomeController::class, 'cares'])->name('cares'); //cares
Route::get('/myths', [HomeController::class, 'myths'])->name('myths'); //myths


Route::get('/adoption', [SpecialRatController::class, 'index'])->name('adoption');


Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        $user = auth()->user();
        
        switch($user->role) {
            case 1: return view('user.dashboard');
            case 2: return view('manager.dashboard');
            case 3: return view('admin.dashboard');
            default: return redirect('/login');
        }
    })->name('dashboard');
});

// ========================= USER =========================
Route::middleware(['auth','role:1'])->group(function () {

});

// ========================================================


// ========================= MANAGER =========================
Route::middleware(['auth','role:2'])->group(function () {

});

// ========================================================

// ========================= ADMIN =========================

Route::middleware(['auth','role:3'])->group(function () {

});

// ========================================================