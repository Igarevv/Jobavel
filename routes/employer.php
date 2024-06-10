<?php

use App\Http\Controllers\Employer\RegisterController;
use Illuminate\Support\Facades\Route;

Route::prefix('employer')->name('employer.')->group(function () {
    Route::match(['get', 'post'], '/register', RegisterController::class)
        ->middleware('guest')
        ->name('register');

    Route::middleware('auth')->group(function () {
        Route::redirect('/', '/main');

        Route::get('/main', function () {
            return 'employer main page';
        })->name('main');
    });

    // Latest
    // Route::fallback(fn() => redirect()->to('home'));
});
