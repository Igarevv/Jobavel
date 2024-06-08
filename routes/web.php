<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Employee\RegisterController as EmployeeRegister;
use App\Http\Controllers\Employer\RegisterController as EmployerRegister;

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

Route::get('/login', [AuthController::class, 'index'])->name('login');

Route::prefix('employer')->as('employer.')->group(function () {
   Route::controller(EmployerRegister::class)->group(function () {
      Route::get('/register', 'showRegisterForm')->name('register');
   });
});

Route::prefix('employee')->as('employee.')->group(function () {
    Route::controller(EmployeeRegister::class)->group(function () {
        Route::get('/register', 'showRegisterForm')->name('register');
    });
});

Route::redirect('/home', '/');
