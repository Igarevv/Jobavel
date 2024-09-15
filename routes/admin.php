<?php

use App\Http\Controllers\Admin\Account\AdminAccountController;
use App\Http\Controllers\Admin\Account\AdminAuthController;
use App\Http\Controllers\Admin\AdminHomeController;
use App\Http\Controllers\Admin\RolesPermissions\AdminPermissionsController;
use App\Http\Controllers\Admin\RolesPermissions\AdminRolesController;
use App\Http\Controllers\Admin\Skills\AdminSkillsController;
use App\Http\Controllers\Admin\Users\AdminsController;
use App\Http\Controllers\Admin\Users\EmployeesController;
use App\Http\Controllers\Admin\Users\EmployersController;
use App\Http\Controllers\Admin\Users\TemporarilyDeletedUsersController;
use App\Http\Controllers\Admin\Users\UnverifiedUsersController;
use App\Http\Controllers\Admin\Vacancies\VacancyController;
use App\Http\Controllers\Auth\EmailVerificationController;
use Illuminate\Support\Facades\Route;

Route::get('/admin/confirm-email/{id}/{email}', [EmailVerificationController::class, 'confirmAdminEmailChanging'])
    ->middleware('signed')
    ->name('admin.confirm-email-change');

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

                Route::get('/table', 'fetchUnverified')->name('unverified.table');

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

                Route::get('/table', 'fetchEmployers')->name('employers.table');
            });

            /*
            * ---------------------------------
            * -          Employees            -
            * ---------------------------------
            */

            Route::controller(EmployeesController::class)->prefix('employees')->group(function () {
                Route::get('/', 'index')->name('employees');

                Route::get('/table', 'fetchEmployees')->name('employees.table');
            });

            /*
            * ---------------------------------
            * -   Temporarily Deleted Users   -
            * ---------------------------------
            */

            Route::controller(TemporarilyDeletedUsersController::class)->prefix('temporarily-deleted')->group(
                function () {
                    Route::get('/', 'index')->name('temporarily-deleted');

                    Route::get('/table', 'fetchTemporarilyDeletedUsers')->name('temporarily-deleted.table');

                    Route::post('/{identity:user_id}/give-second-chance', 'sendEmailToRestoreUser')
                        ->withTrashed()
                        ->name('temporarily-deleted.restore');
                }
            );
        });

        /*
        * ---------------------------------
        * -            Admins             -
        * ---------------------------------
        */

        Route::middleware('auth.admin:super-admin')->prefix('admins')->group(function () {
            Route::controller(AdminsController::class)->group(function () {
                Route::get('/', 'index')->name('admins');

                Route::get('/table', 'fetchAdmins')->name('admins.table');
            });

            Route::post('/register', [AdminAuthController::class, 'register'])->name('admins.register');
        });
    });

    Route::middleware('auth.admin')->group(function () {
        /*
        * ---------------------------------
        * -       Account Settings        -
        * ---------------------------------
        */

        Route::controller(AdminAccountController::class)->prefix('account')->group(function () {
            Route::get('/settings', 'fetchAccountInfo')->name('settings');

            Route::post('/reset-password', 'resetPassword')->name('reset-password');

            Route::post('/update-info', 'updateAccountInfo')->name('account.update');
        });

        /*
        * ---------------------------------
        * -           Vacancies           -
        * ---------------------------------
        */

        Route::controller(VacancyController::class)->prefix('vacancies')
            ->name('vacancies.')
            ->group(function () {
                Route::get('/', 'index')->name('index');

                Route::get('/{vacancy}/employer', 'vacancyOwner')->name('employer');

                Route::get('/table', 'fetchVacancies')->name('table');
            });

        /*
        * ---------------------------------
        * -          Tech skills          -
        * ---------------------------------
        */

        Route::controller(AdminSkillsController::class)->prefix('skills')
            ->name('skills.')
            ->group(function () {
                Route::get('/', 'index')->name('index');

                Route::get('/table', 'fetchSkills')->name('table');

                Route::withoutMiddleware('auth.admin')->group(function () {
                    Route::post('/create', 'create')->name('create');

                    Route::patch('/{skill}/edit', 'update')->name('edit');

                    Route::delete('/{skill}/delete', 'delete')->name('delete');
                })->middleware('auth.admin:super-admin');
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
