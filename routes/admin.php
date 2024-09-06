<?php

use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\AdminHomeController;
use App\Http\Controllers\Admin\RolesPermissions\AdminPermissionsController;
use App\Http\Controllers\Admin\RolesPermissions\AdminRolesController;
use App\Http\Controllers\Admin\Users\AdminsController;
use App\Http\Controllers\Admin\Users\EmployeesController;
use App\Http\Controllers\Admin\Users\EmployersController;
use App\Http\Controllers\Admin\Users\TemporarilyDeletedUsersController;
use App\Http\Controllers\Admin\Users\UnverifiedUsersController;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')->name('admin.')->group(function () {
    /*
    * ---------------------------------
    * -       Admin Main Page         -
    * ---------------------------------
    */

    Route::get('/island', [AdminHomeController::class, 'index'])->middleware('auth.admin')
        ->name('island');

    /*
    * ---------------------------------
    * -       Admin Auth System       -
    * ---------------------------------
    */

    Route::middleware('guest:admin')->group(function () {
        Route::get('/sign-in', [AdminAuthController::class, 'signInIndex'])->name('sign-in.show');

        Route::post('/sign-in', [AdminAuthController::class, 'login'])->name('sign-in');
    });
    Route::post('/logout', [AdminAuthController::class, 'logout'])->middleware('auth.admin')->name('logout');

    Route::prefix('users')->name('users.')->group(function () {
        /*
        * ---------------------------------
        * -      Admin Users Section      -
        * ---------------------------------
        */

        Route::group(['middleware' => 'auth.admin'], function () {
            /*
            * ---------------------------------
            * -       Unverified Users        -
            * ---------------------------------
            */

            Route::controller(UnverifiedUsersController::class)->prefix('unverified')->group(function () {
                Route::get('/', 'index')->name('unverified');

                Route::delete('/{identity:user_id}/softdel', 'delete')->name('unverified.delete');

                Route::post('/emails/send-to-unverified', 'sendEmailToVerifyUsers')->name('emails.send');
            });

            /*
            * ---------------------------------
            * -          Employers            -
            * ---------------------------------
            */

            Route::controller(EmployersController::class)->prefix('employers')->group(function () {
                Route::get('/', 'index')->name('employers');

                Route::get('/partials', 'fetchEmployers');

                Route::get('/search', 'search')->name('employers.search');
            });

            /*
            * ---------------------------------
            * -          Employees            -
            * ---------------------------------
            */

            Route::controller(EmployeesController::class)->prefix('employees')->group(function () {
                Route::get('/', 'index')->name('employees');

                Route::get('/search', 'search')->name('employees.search');
            });

            /*
            * ---------------------------------
            * -   Temporarily Deleted Users   -
            * ---------------------------------
            */

            Route::controller(TemporarilyDeletedUsersController::class)->prefix('temporarily-deleted')->group(function (
            ) {
                Route::get('/', 'index')->name('temporarily-deleted');

                Route::get('/search', 'search')->name('temporarily-deleted.search');

                Route::post('/{identity:user_id}/give-second-chance', 'sendEmailToRestoreUser')
                    ->withTrashed()
                    ->name('temporarily-deleted.restore');
            });
        });

        /*
        * ---------------------------------
        * -            Admins             -
        * ---------------------------------
        */

        Route::controller(AdminsController::class)->middleware('auth.admin:super-admin')
            ->prefix('admins')
            ->group(function () {
                Route::get('/', 'index')->name('admins');

                Route::post('/register', 'register')->name('admins.register');
            });
    });

    /*
    * ---------------------------------
    * -     Roles and Permissions     -
    * ---------------------------------
    */

    Route::middleware('auth.admin:super-admin')->group(function () {
        Route::controller(AdminRolesController::class)->group(function () {
            Route::get('/roles-permissions', 'index')->name('roles-permissions');

            Route::post('/role/store', 'storeRole')->name('role.store');

            Route::delete('/role/{role}/remove', 'delete')->name('roles.remove');
        });

        Route::controller(AdminPermissionsController::class)->group(function () {
            Route::post('/permission/store', 'storePermission')->name('permission.store');

            Route::post('/link-permissions-to-role', 'linkPermissionsToRole')->name('permissions-roles.link');

            Route::delete('/permission/{permission}/remove', 'delete')->name('permissions.remove');
        });
    });
});