<?php

use App\Http\Controllers\Employee\EmployeeAccountController;
use App\Http\Controllers\Employee\HomeController;
use App\Http\Controllers\Employee\RegisterController;
use Illuminate\Support\Facades\Route;

Route::prefix('employee')->name('employee.')->group(function () {
    Route::match(['get', 'post'], '/register', RegisterController::class)
        ->middleware('guest')
        ->name('register');

    Route::middleware(['auth', "role:employee"])->group(function () {
        Route::redirect('/', '/main');

        Route::get('/main', [HomeController::class, 'index'])->name('main');

        Route::post('/account/personal-information', [EmployeeAccountController::class, 'update'])->name(
            'account.personal-info'
        );
    });
});

Route::fallback(fn() => redirect()->to('employee.main'));