<?php

use App\Http\Controllers\Employer\EmployerAccountController;
use App\Http\Controllers\Employer\HomeController;
use App\Http\Controllers\Employer\RegisterController;
use App\Http\Controllers\Employer\VacancyController;
use App\Http\Controllers\FileController;
use Illuminate\Support\Facades\Route;

Route::prefix('vacancies')->name('vacancies.')->whereNumber('vacancy')->group(function () {
    /*
     * ---------------------------------
     * -         Show vacancy          -
     * ---------------------------------
     */

    Route::get('/{vacancy}', [VacancyController::class, 'show'])->name('show');

    /*
     * ---------------------------------
     * -         Edit vacancy          -
     * ---------------------------------
     */

    Route::get('/{vacancy}/edit', [VacancyController::class, 'showEdit'])->name('show.edit');
    Route::post('/edit', [VacancyController::class, 'edit'])->name('edit');
});

Route::name('employer.')->group(function () {
    /*
     * ---------------------------------
     * -     Registration section      -
     * ---------------------------------
     */

    Route::match(['get', 'post'], '/register', RegisterController::class)
        ->prefix('employer')
        ->middleware('guest')
        ->name('register');

    Route::group(['middleware' => ['auth', 'role:employer']], function () {
        Route::prefix('employer')->group(function () {
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

            Route::controller(EmployerAccountController::class)->name('account.')->group(function () {
                /*
                * TODO: MAKE SCHEDULE TO DELETE UNVERIFIED EMAILS
                */
                Route::post('/account/update', 'update')->name('update');
                Route::post('/account/verify-contact-email', 'verifyContactEmail')->name('verify-contact-email');
                Route::post('/account/resend-code', 'resendCode')->name('resend-code');
            });

            /*
            * ---------------------------------
            * -         File storage          -
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
    });
});

