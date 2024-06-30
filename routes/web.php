<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\EmailVerificationController;
use App\Http\Controllers\HomeController;
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
 * - Authentication section
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
 * - Email verification section
 * ---------------------------------
 */
Route::prefix('/auth/email/verify')->group(function () {
    Route::view('/show', 'verify-email')->middleware('auth')->name(
        'verification.notice'
    );
    Route::get(
        '/{user_id}/{hash}',
        [EmailVerificationController::class, 'verifyEmail']
    )
        ->middleware('signed')
        ->name('verification.verify');

    Route::post('/resend', [EmailVerificationController::class, 'resendEmail'])
        ->middleware(['auth', 'throttle:6,1'])->name('verification.send');
});

Route::redirect('/home', '/');
