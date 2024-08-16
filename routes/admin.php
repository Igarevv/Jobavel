<?php

use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\AdminHomeController;
use App\Http\Controllers\Admin\AdminRolesPermissionsController;
use Illuminate\Support\Facades\Route;

Route::get('/admin/island', [AdminHomeController::class, 'index'])->name('admin.island');

Route::get('/admin/sign-in', [AdminAuthController::class, 'signInIndex']);

Route::post('/admin/sign-in', [AdminAuthController::class, 'login'])->name('admin.sign-in');

Route::get('/admin/roles-permissions', [AdminRolesPermissionsController::class, 'index'])->name('admin.roles-permissions');

Route::post('/admin/role/store', [AdminRolesPermissionsController::class, 'storeRole'])->name('admin.role.store');

Route::post('/admin/permission/store', [AdminRolesPermissionsController::class, 'storePermission'])->name('admin.permission.store');

Route::get('/admin/roles/{role}/permissions', [AdminRolesPermissionsController::class, 'permissionsByRole']);

Route::post('/admin/link-permissions-to-role', [AdminRolesPermissionsController::class, 'linkPermissionsToRole'])->name('admin.permissions-roles.link');
