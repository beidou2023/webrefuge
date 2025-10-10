<?php

use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ManagerController;
use App\Http\Controllers\RatController;
use App\Http\Controllers\SpecialRatController;
use App\Http\Controllers\UserController;


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

        switch ($user->role) {
            case 1:
                return app(\App\Http\Controllers\UserController::class)->dashboard();
            case 2:
                return app(\App\Http\Controllers\ManagerController::class)->dashboard();
            case 3:
                return app(\App\Http\Controllers\AdminController::class)->dashboard();
            default:
                return redirect('/login');
        }
    })->name('dashboard');
});

// ========================= USER =========================

Route::middleware(['auth','role:1'])->group(function () {
    // Dashboard usuario
    Route::get('/user/dashboard', [UserController::class, 'dashboard'])->name('user.dashboard');
    
    // Perfil
    Route::get('/user/profile', [UserController::class, 'profile'])->name('user.profile');
    
    // Adopción
    Route::get('/user/adoption/form', [UserController::class, 'showAdoptionForm'])->name('user.adoption.form');
    Route::post('/user/adoption/submit', [UserController::class, 'submitAdoption'])->name('user.adoption.submit');
    
    // Ratas
    Route::get('/user/rats/available', [RatController::class, 'available'])->name('user.rats.available');
    Route::get('/user/rats/special', [RatController::class, 'special'])->name('user.rats.special');
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
