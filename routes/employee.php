<?php

use App\Http\Controllers\Employee\RegisterController;
use Illuminate\Support\Facades\Route;

Route::prefix('employee')->as('employee.')
    ->group(function () {
        Route::get('/register', [RegisterController::class, 'showRegisterForm'])
            ->name('register');

        // Latest in this group
        Route::fallback(fn() => redirect()->to('home'));
    });
