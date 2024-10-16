<?php

use App\Http\Controllers\Admin\Account\AdminAccountController;
use App\Http\Controllers\Admin\Account\AdminAuthController;
use App\Http\Controllers\Admin\AdminHomeController;
use App\Http\Controllers\Admin\RolesPermissions\AdminPermissionsController;
use App\Http\Controllers\Admin\RolesPermissions\AdminRolesController;
use App\Http\Controllers\Admin\Skills\AdminSkillsController;
use App\Http\Controllers\Admin\Users\AdminBannedUsersController;
use App\Http\Controllers\Admin\Users\AdminsController;
use App\Http\Controllers\Admin\Users\EmployeesController;
use App\Http\Controllers\Admin\Users\EmployersController;
use App\Http\Controllers\Admin\Users\TemporarilyDeletedUsersController;
use App\Http\Controllers\Admin\Users\UnverifiedUsersController;
use App\Http\Controllers\Admin\Vacancies\ModerateVacancyController;
use App\Http\Controllers\Admin\Vacancies\VacancyController;
use App\Http\Controllers\Auth\EmailVerificationController;
use App\Http\Controllers\Vacancy\VacancyEmployerViewController;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')->name('admin.')->middleware('admin')->group(function () {
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
    Route::post('/logout', [AdminAuthController::class, 'logout'])->middleware('auth.admin')->name(
        'logout'
    );

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

            Route::controller(UnverifiedUsersController::class)->prefix('unverified')->group(
                function () {
                    Route::get('/', 'index')->name('unverified');

                    Route::get('/table', 'fetchUnverified')->name('unverified.table');

                    Route::delete('/{identity:user_id}/softdel', 'delete')->name('unverified.delete');

                    Route::post('/emails/send-to-unverified', 'sendEmailToVerifyUsers')->name(
                        'emails.send'
                    );
                }
            );

            /*
            * ---------------------------------
            * -          Employers            -
            * ---------------------------------
            */

            Route::controller(EmployersController::class)->prefix('employers')->group(function () {
                Route::get('/', 'index')->name('employers');

                Route::get('/table', 'fetchEmployers')->name('employers.table');

                Route::post('/{employer:employer_id}/ban', 'banEmployer')->name('employers.ban');
            });

            /*
            * ---------------------------------
            * -          Employees            -
            * ---------------------------------
            */

            Route::controller(EmployeesController::class)->prefix('employees')->group(function () {
                Route::get('/', 'index')->name('employees');

                Route::get('/table', 'fetchEmployees')->name('employees.table');

                Route::post('/{employee:employee_id}/ban', 'banEmployee')->name('employees.ban');
            });

            /*
            * ---------------------------------
            * -   Temporarily Deleted Users   -
            * ---------------------------------
            */

            Route::controller(TemporarilyDeletedUsersController::class)
                ->prefix('temporarily-deleted')
                ->group(
                    function () {
                        Route::get('/', 'index')->name('temporarily-deleted');

                        Route::get('/table', 'fetchTemporarilyDeletedUsers')->name(
                            'temporarily-deleted.table'
                        );

                        Route::post('/{identity:user_id}/give-second-chance', 'sendEmailToRestoreUser')
                            ->withTrashed()
                            ->name('temporarily-deleted.restore');
                    }
                );

            /*
            * ---------------------------------
            * -         Banned users          -
            * ---------------------------------
            */

            Route::controller(AdminBannedUsersController::class)->prefix('banned')->group(
                function () {
                    Route::get('/', 'index')->name('banned');

                    Route::get('/table', 'fetchBannedUsers')->name('banned.table');
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

                Route::get('/{admin:admin_id}/actions', 'fetchActionsMadeByAdmin')->name('admins.actions');

                Route::post('/{identity:admin_id}/deactivate', 'deactivateAdmin')->name('admins.deactivate');

                Route::post('/{identity:admin_id}/activate', 'activateAdmin')->name('admins.activate');
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

                Route::post('/{vacancy}/delete', 'deleteVacancyByAdmin')->withTrashed()->name('delete');
            });

        Route::get(
            '/vacancy/{vacancy}/trashed',
            [VacancyEmployerViewController::class, 'showTrashedPreview']
        )->name('vacancy.trashed');

        /*
        * ---------------------------------
        * -          Moderation           -
        * ---------------------------------
        */

        Route::controller(ModerateVacancyController::class)->prefix('vacancies/moderate')
            ->name('vacancies.')
            ->group(function () {
                Route::get('/', 'index')->name('moderate');

                Route::get('/table', 'fetchVacanciesToModerate')->name('moderate-table');

                Route::get('/{vacancy}/view', 'vacancyModerateView')->name('moderate-view');

                Route::post('/{vacancy}/approve', 'approve')->name('approve');

                Route::post('/{vacancy}/reject', 'reject')->name('reject');
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

                Route::post('/create', 'create')->name('create');

                Route::patch('/{skill}/edit', 'update')->name('edit');

                Route::delete('/{skill}/delete', 'delete')->name('delete');
            });
    });

    /*
    * ---------------------------------
    * -     Roles and Permissions     -
    * ---------------------------------
    */

    Route::middleware('auth.admin')->group(function () {
        Route::controller(AdminRolesController::class)->group(function () {
            Route::get('/roles-permissions', 'index')->name('roles-permissions');

            Route::post('/role/store', 'storeRole')->name('role.store');

            Route::delete('/role/{role}/remove', 'delete')->name('roles.remove');
        });

        Route::controller(AdminPermissionsController::class)->group(function () {
            Route::post('/permission/store', 'storePermission')->name('permission.store');

            Route::post('/link-permissions-to-role', 'linkPermissionsToRole')->name(
                'permissions-roles.link'
            );

            Route::post('/link-permissions-to-admin', 'linkPermissionsToAdmin')->name(
                'permissions-admin.link'
            );

            Route::delete('/permission/{permission}/remove', 'delete')->name('permissions.remove');
        });
    });
});


Route::get('/admin/confirm-email/{id}/{email}', [
    EmailVerificationController::class,
    'confirmAdminEmailChanging'
])->middleware(['admin', 'signed'])->name('admin.confirm-email-change');

/*
 * This routes is here because this actions can view admin and employer (owner of vacancy)
 */
Route::controller(ModerateVacancyController::class)->prefix('moderation')
    ->middleware('admin')
    ->group(function () {
        Route::get('/vacancy/{vacancy}/previous-reject', 'latestRejectInfo')
            ->name('admin.vacancies.previous-reject');

        Route::get('/vacancy/{vacancy}/trash-info', 'latestTrashInfo')
            ->name('admin.vacancies.trash-info');
    });
