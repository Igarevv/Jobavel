<?php

use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\AdminHomeController;
use Illuminate\Support\Facades\Route;

Route::get('/admin/island', [AdminHomeController::class, 'index'])->name('admin.island');

Route::get('/admin/sign-in', [AdminAuthController::class, 'signInIndex']);

Route::post('/admin/sign-in', [AdminAuthController::class, 'login'])->name('admin.sign-in');