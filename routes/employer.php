<?php

use App\Http\Controllers\Employer\EmployerAccountController;
use App\Http\Controllers\Employer\HomeController;
use App\Http\Controllers\Employer\RegisterController;
use App\Http\Controllers\Employer\VacancyManipulationController;
use App\Http\Controllers\Employer\VacancyViewController;
use App\Http\Controllers\FileController;
use Illuminate\Support\Facades\Route;

Route::prefix('vacancies')->name('vacancies.')->whereNumber('vacancy')->group(function () {
    /*
     * ---------------------------------
     * -      Vacancy public view      -
     * ---------------------------------
     */

    Route::get('/{vacancy}', [VacancyViewController::class, 'show'])->name('show');
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

            Route::middleware(['verified'])->group(function () {
                /*
                * ---------------------------------
                * -      Vacancy show view        -
                * ---------------------------------
                */

                Route::controller(VacancyViewController::class)->prefix('vacancy')
                    ->name('vacancy.')
                    ->group(function () {
                        Route::get('/published', 'published')->name('published');
                        Route::get('/unpublished', 'unpublished')->name('unpublished');
                        Route::get('/{vacancy}/edit', 'showEdit')->whereNumber('vacancy')
                            ->name('show.edit');
                        Route::get('/create', 'create')->name('create');
                        Route::get('/trashed', 'viewTrashed')->name('trashed');
                    });

                /*
                * ---------------------------------
                * -     Vacancy manipulation      -
                * ---------------------------------
                */

                Route::resource('vacancy', VacancyManipulationController::class)
                    ->only(['destroy', 'store', 'update']);

                Route::controller(VacancyManipulationController::class)->prefix('vacancy')
                    ->name('vacancy.')
                    ->group(function () {
                        Route::post('/publish/{vacancy}', 'publish')->name('publish');

                        Route::post('/unpublish/{vacancy}', 'unpublish')->name('unpublish');

                        Route::delete('/delete/{vacancy}/forever',
                            'deleteForever')->name('delete-forever')->withTrashed();

                        Route::post('/restore/{vacancy}', 'restore')->name('restore')->withTrashed();
                    })->whereNumber('vacancy');

                Route::post('/');
            });
        });
    });
});

