<?php

use App\Http\Controllers\Admin\RolesPermissions\AdminPermissionsController;
use App\Http\Controllers\Admin\Vacancies\VacancyController;
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

Route::get('/vacancy/skills', [SkillsController::class, 'getAllSkills'])->middleware('role:employer,employee');

Route::get('/vacancy/{vacancy}/employees',
    [VacancyEmployeeController::class, 'appliedEmployees'])->middleware('role:employer');

Route::get('/admin/roles/{role}/permissions',
    [AdminPermissionsController::class, 'permissionsByRole'])->middleware('role:admin');

Route::get('/admin/employers/{employer:employer_id}/vacancies', [VacancyController::class, 'employerVacancies'])
    ->middleware('role:admin');