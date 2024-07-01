<?php

use App\Http\Controllers\Employer\HomeController;
use App\Http\Controllers\Employer\RegisterController;
use App\Http\Controllers\Employer\VacancyController;
use App\Persistence\Models\User;
use Illuminate\Support\Facades\Route;

Route::prefix('employer')->name('employer.')->group(function () {
    $role = User::EMPLOYER;

    Route::match(['get', 'post'], '/register', RegisterController::class)
        ->middleware('guest')
        ->name('register');

    Route::middleware(['auth', "role:$role"])->group(function () {
        Route::redirect('/', '/main');

        Route::get('/main', [HomeController::class, 'index'])
            ->name('main');

        Route::group(['middleware' => 'verified'], function () {
            Route::resource('vacancy', VacancyController::class)->only(
                ['store', 'create', 'index']
            );
        })->name('vacancy.');
    });

    // Latest
    // Route::fallback(fn() => redirect()->to('home'));
});
