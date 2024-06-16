<?php

use App\Http\Controllers\Employer\HomeController;
use App\Http\Controllers\Employer\RegisterController;
use App\Http\Controllers\Employer\VacancyController;
use Illuminate\Support\Facades\Route;

Route::prefix('employer')->name('employer.')->group(function () {
    Route::match(['get', 'post'], '/register', RegisterController::class)
        ->middleware('guest')
        ->name('register');

    // DELETE ALL withoutMiddleware
    Route::middleware('auth')->group(function () {
        Route::redirect('/', '/main');

        Route::get('/main', [HomeController::class, 'index'])
            ->name('main')
            ->withoutMiddleware('auth');

        Route::controller(VacancyController::class)->name('vacancy.')
            ->group(function () {
                Route::get('/vacancy', 'list')->name('list')->withoutMiddleware('auth');
                Route::view('/vacancy/create', 'employer.vacancy.create')->name('create')->withoutMiddleware('auth');
            });
    });

    // Latest
    // Route::fallback(fn() => redirect()->to('home'));
});
