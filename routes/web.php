<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\Dashboard;
use App\Http\Controllers\Admin\Profile;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

//admin auth
Route::get('admin', [AuthController::class, 'index'])->name('index');
Route::post('admin/login', [AuthController::class, 'login'])->name('login');
Route::get('admin/dashboard', [Dashboard::class, 'index'])->name('dashboard');
Route::get('admin/profile', [Profile::class, 'index'])->name('profile');
Route::post('admin/profile', [Profile::class, 'change_password'])->name('change_password');
Route::get('admin/logout', [AuthController::class, 'logout'])->name('logout');

