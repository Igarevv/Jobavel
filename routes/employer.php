<?php

use App\Http\Controllers\Employer\HomeController;
use App\Http\Controllers\Employer\RegisterController;
use App\Http\Controllers\Employer\VacancyController;
use App\Persistence\Models\User;
use Illuminate\Support\Facades\Route;

Route::prefix('employer')->name('employer.')->group(function () {
    $role = User::EMPLOYER;

    /*
     * ---------------------------------
     * -     Registration section      -
     * ---------------------------------
     */
    Route::match(['get', 'post'], '/register', RegisterController::class)
        ->middleware('guest')
        ->name('register');

    Route::middleware(['auth', "role:$role"])->group(function () {
        Route::redirect('/', '/main');

        /*
         * ---------------------------------
         * -      Employer home page       -
         * ---------------------------------
         */
        Route::get('/main', [HomeController::class, 'index'])
            ->name('main');

        /*
         * ---------------------------------
         * -     Vacancy manipulation      -
         * ---------------------------------
         */
        Route::name('vacancy.')->group(function () {
            Route::middleware(['verified'])->group(function () {
                /*
                 * ---------------------------------
                 * -     None resource methods     -
                 * ---------------------------------
                 */
                Route::prefix('/vacancy')->group(function () {
                    Route::get('/published',
                        [VacancyController::class, 'published'])
                        ->name('published');
                    Route::get('/unpublished',
                        [VacancyController::class, 'unpublished'])
                        ->name('unpublished');
                });
                
                Route::resource('vacancy', VacancyController::class)
                    ->only(['create', 'store']);
            });
        });
    });

    // Latest
    // Route::fallback(fn() => redirect()->to('home'));
});
