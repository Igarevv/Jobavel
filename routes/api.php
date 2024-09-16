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

Route::get('/vacancy/skills', [SkillsController::class, 'getAllSkills']);

Route::get(
    '/vacancy/{vacancy}/employees',
    [VacancyEmployeeController::class, 'appliedEmployees']
);

Route::get(
    '/admin/roles/{role}/permissions',
    [AdminPermissionsController::class, 'permissionsByRole']
)->middleware('auth.admin.api');

Route::get('/admin/person/{adminIdentifier}/permissions', [AdminPermissionsController::class, 'permissionsForAdmin'])
    ->middleware('auth.admin.api');

Route::get('/admin/employers/{employer:employer_id}/vacancies', [VacancyController::class, 'employerVacancies']
)->middleware('auth.admin.api');
