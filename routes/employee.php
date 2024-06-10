<?php

use App\Http\Controllers\Employee\RegisterController;
use Illuminate\Support\Facades\Route;

Route::prefix('employee')->name('employee.')->group(function () {
    Route::match(['get', 'post'], '/register', RegisterController::class)
        ->middleware('guest')
        ->name('register');

    Route::middleware('auth')->group(function () {
        Route::redirect('/', '/main');

        Route::get('/main', function () {
            return 'employee main page';
        })->name('main');
    });

    // Latest
    // Route::fallback(fn() => redirect()->to('home'));
});
