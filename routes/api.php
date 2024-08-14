<?php

use App\Http\Controllers\Vacancy\SkillsController;
use App\Http\Controllers\Vacancy\VacancyEmployeeController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::get('/vacancy/skills', [SkillsController::class, 'getAllSkills']);

Route::get('/vacancy/{vacancy}/employees', [VacancyEmployeeController::class, 'appliedEmployees']);