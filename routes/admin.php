<?php

use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\AdminHomeController;
use App\Http\Controllers\Admin\RolesPermissions\AdminPermissionsController;
use App\Http\Controllers\Admin\RolesPermissions\AdminRolesController;
use App\Http\Controllers\Admin\Users\EmployeesController;
use App\Http\Controllers\Admin\Users\EmployersController;
use App\Http\Controllers\Admin\Users\TemporarilyDeletedUsersController;
use App\Http\Controllers\Admin\Users\UnverifiedUsersController;
use Illuminate\Support\Facades\Route;

Route::get('/admin/island', [AdminHomeController::class, 'index'])->name('admin.island');

Route::get('/admin/users/unverified', [UnverifiedUsersController::class, 'index'])->name('admin.users.unverified');

Route::delete('/admin/users/unverified/{identity:user_id}/softdel', [UnverifiedUsersController::class, 'delete'])
    ->name('admin.unverified.delete');

Route::get('/admin/users/employees', [EmployeesController::class, 'index'])->name('admin.users.employees');

Route::get('/admin/users/employers', [EmployersController::class, 'index'])->name('admin.users.employers');

Route::get('/admin/employers/search', [EmployersController::class, 'search'])->name('admin.employers.search');

Route::get('/admin/employees/search', [EmployeesController::class, 'search'])->name('admin.employees.search');

Route::get('/admin/temporarily-deleted/search', [TemporarilyDeletedUsersController::class, 'search'])->name(
    'admin.temporarily-deleted.search'
);
Route::post(
    '/admin/temporarily-delete/{identity:user_id}/give-second-chance',
    [TemporarilyDeletedUsersController::class, 'sendEmailToRestoreUser']
)->withTrashed()->name('admin.temporarily-deleted.restore');

Route::get('/admin/users/temporarily-deleted', [TemporarilyDeletedUsersController::class, 'index'])->name(
    'admin.users.temporarily-deleted'
);
//Route::get('/admin/users/admins', [AdminsController::class, 'index'])->name('admin.users.admins');

Route::get('/admin/sign-in', [AdminAuthController::class, 'signInIndex']);

Route::post('/admin/sign-in', [AdminAuthController::class, 'login'])->name('admin.sign-in');

Route::get('/admin/roles-permissions', [AdminRolesController::class, 'index'])->name(
    'admin.roles-permissions'
);

Route::delete('/admin/role/{role}/remove', [AdminRolesController::class, 'delete'])->name('admin.roles.remove');

Route::post('/admin/emails/send-to-unverified', [UnverifiedUsersController::class, 'sendEmailToVerifyUsers'])->name(
    'admin.emails.send'
);

Route::post('/admin/role/store', [AdminRolesController::class, 'storeRole'])->name('admin.role.store');

Route::post('/admin/permission/store', [AdminPermissionsController::class, 'storePermission'])->name(
    'admin.permission.store'
);

Route::post('/admin/link-permissions-to-role', [AdminPermissionsController::class, 'linkPermissionsToRole'])->name(
    'admin.permissions-roles.link'
);

Route::delete('/admin/permission/{permission}/remove', [AdminPermissionsController::class, 'delete'])
    ->name('admin.permissions.remove');