<?php

use App\Http\Controllers\Employer\RegisterController;
use Illuminate\Support\Facades\Route;

Route::prefix('employer')->as('employer.')
    ->group(function () {
        Route::get('/register', [RegisterController::class, 'showRegisterForm'])
            ->name('register');

        // Latest in this group
        Route::fallback(fn() => redirect()->route('home'));
    });
