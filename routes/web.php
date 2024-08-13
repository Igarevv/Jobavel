<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\EmailVerificationController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Vacancy\VacancyEmployeeController;
use App\Http\Controllers\VacancyController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [HomeController::class, 'index'])->name('home');

/*
 * ---------------------------------
 * -    Authentication section     -
 * ---------------------------------
 */

Route::prefix('auth')->name('login.')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->middleware(
        'auth'
    )->name('logout');

    Route::middleware('guest')->group(function () {
        Route::get('/login', [AuthController::class, 'index'])->name('show');
        Route::post('/login', [AuthController::class, 'login'])->name('enter');
    });
});

/*
 * ---------------------------------
 * -  Email verification section   -
 * ---------------------------------
 */

Route::prefix('/auth/email/verify')->middleware('auth')->group(
    function () {
        Route::view('/show', 'auth.email.resend-email')->name('verification.notice')
            ->middleware('unverified');

        Route::get('/{user_id}/{hash}', [EmailVerificationController::class, 'verifyEmail'])
            ->middleware('signed.email')
            ->name('verification.verify')
            ->withoutMiddleware('auth');

        Route::post('/resend', [EmailVerificationController::class, 'resendEmail'])
            ->name('verification.send');
    }
);

/*
 * ---------------------------------
 * -      Vacancy public view      -
 * ---------------------------------
 */

Route::prefix('vacancies')->name('vacancies.')->group(function () {
    Route::get('/', [VacancyController::class, 'all'])->name('all');

    Route::get('/{vacancy}', [VacancyController::class, 'show'])->name('show');

    /*
    * ---------------------------------
    * -  Employee func with vacancy   -
    * ---------------------------------
    */

    Route::middleware('auth')->name('employee.')->group(function () {
        Route::post('/{vacancy}/apply', [VacancyEmployeeController::class, 'apply'])
            ->name('apply');

        Route::post('/{vacancy}/withdraw', [VacancyEmployeeController::class, 'withDrawVacancy'])
            ->name('withdraw');
    });
});

Route::redirect('/home', '/');
