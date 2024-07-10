<?php

use App\Http\Controllers\Employer\EmployerAccountController;
use App\Http\Controllers\Employer\HomeController;
use App\Http\Controllers\Employer\RegisterController;
use App\Http\Controllers\Employer\VacancyController;
use App\Http\Controllers\FileController;
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
        Route::get('/main', [HomeController::class, 'index'])->name('main');

        /*
         * ---------------------------------
         * -       Employer account        -
         * ---------------------------------
         */
        /*
         * TODO: MAKE SCHEDULE TO DELETE UNVERIFIED EMAILS
         */
        Route::controller(EmployerAccountController::class)->name('account.')->group(function () {
            Route::post('/account/update', 'update')->name('update');
            Route::post('/account/verify-contact-email', 'verifyContactEmail')->name('verify-contact-email');
            Route::post('/account/resend-code', 'resendCode')->name('resend-code');
        });

        /*
         * ---------------------------------
         * -          ile storage          -
         * ---------------------------------
         */
        Route::post('/logo', [FileController::class, 'uploadLogo'])->name('logo.upload');

        /*
         * ---------------------------------
         * -     Vacancy manipulation      -
         * ---------------------------------
         */
        Route::middleware(['verified'])->group(function () {
            Route::prefix('vacancy')->name('vacancy.')->group(function () {
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

    // Latest
    // Route::fallback(fn() => redirect()->to('home'));
});
