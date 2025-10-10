<?php

use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ManagerController;
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
    Route::post('/user/update', [UserController::class, 'update'])->name('user.update');
    // otros métodos
});

// ========================================================

// ========================= MANAGER =========================

Route::middleware(['auth','role:2'])->group(function () {
    Route::post('/manager/add-rat', [ManagerController::class, 'addRat'])->name('manager.addRat');
});

// ========================================================

// ========================= ADMIN =========================

Route::middleware(['auth','role:3'])->group(function () {
    Route::post('/admin/add-shelter', [AdminController::class, 'addShelter'])->name('admin.addShelter');
});

// ========================================================
