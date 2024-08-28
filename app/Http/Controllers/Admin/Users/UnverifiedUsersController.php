<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin\Users;

use App\Actions\Admin\Users\Unverified\GetUnverifiedUsersPaginatedAction;
use App\Actions\Admin\Users\Unverified\SendEmailToAllUnverifiedUsersAction;
use App\Events\UserDeletedTemporarily;
use App\Exceptions\TooManyEmailsForUnverifiedUsersPerDay;
use App\Http\Controllers\Controller;
use App\Persistence\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Pagination\Paginator;
use Illuminate\View\View;

class UnverifiedUsersController extends Controller
{
    public function index(GetUnverifiedUsersPaginatedAction $getUnverifiedUsers): View
    {
        Paginator::useTailwind();

        return view('admin.users.unverified', ['users' => $getUnverifiedUsers->handle()]);
    }

    public function sendEmailToVerifyUsers(SendEmailToAllUnverifiedUsersAction $action): RedirectResponse
    {
        try {
            $action->handle();
        } catch (TooManyEmailsForUnverifiedUsersPerDay|ModelNotFoundException $e) {
            return back()->with('errors', $e->getMessage());
        }

        return back()->with('emails-sent', 'Start sending emails to unverified users...');
    }

    public function delete(User $identity): RedirectResponse
    {
        $identity->delete();

        event(new UserDeletedTemporarily($identity->email));

        return back()->with('user-deleted', 'User was successfully move to trashed users list.');
    }
}