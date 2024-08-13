<?php

use App\Http\Controllers\Employee\CvController;
use App\Http\Controllers\Employee\EmployeeAccountController;
use App\Http\Controllers\Employee\HomeController;
use App\Http\Controllers\Employee\RegisterController;
use App\Http\Controllers\Vacancy\VacancyEmployeeController;
use Illuminate\Support\Facades\Route;

/*
* ---------------------------------
* -     View employee resume      -
* ---------------------------------
*/

Route::get('/resume/{employee:employee_id}', [CvController::class, 'showResume'])->name('employee.resume');

Route::prefix('employee')->name('employee.')->group(function () {
    /*
    * ---------------------------------
    * -     Employee registration     -
    * ---------------------------------
    */

    Route::match(['get', 'post'], '/register', RegisterController::class)
        ->middleware('guest')
        ->name('register');

    Route::middleware(['auth', "role:employee"])->group(function () {
        Route::redirect('/', '/main');

        /*
        * ---------------------------------
        * -      Employee home page       -
        * ---------------------------------
        */

        Route::get('/main', [HomeController::class, 'index'])->name('main');

        Route::middleware(['verified'])->group(function () {
            /*
            * ---------------------------------
            * -   Employee CV manipulations   -
            * ---------------------------------
            */

            Route::resource('cv', CvController::class)->only('create', 'store', 'index');

            Route::post('/cv/delete', [CvController::class, 'destroy'])->name('cv.destroy');

            Route::post('/account/personal-information', [EmployeeAccountController::class, 'update'])
                ->name('account.personal-info');

            /*
            * ---------------------------------
            * - Applied vacancies by employee -
            * ---------------------------------
            */

            Route::name('vacancy.')->prefix('vacancy')->group(function () {
                Route::get('/applied', [VacancyEmployeeController::class, 'appliedVacancies'])
                    ->name('applied');

                Route::post('/applied/change', [VacancyEmployeeController::class, 'changeAttachedDataForVacancy'])
                    ->name('applied.change');
            });
        });
    });
});

Route::fallback(fn() => redirect()->route('home'));
