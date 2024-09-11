<?php

namespace App\Http\Controllers\Admin\Users;

use App\Actions\Admin\Users\TemporarilyDeleted\GetTemporarilyDeletedUsersAction;
use App\Events\UserAccountRestored;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AdminTemporarilyDeletedSearchRequest;
use App\Http\Resources\Admin\AdminTable;
use App\Persistence\Models\User;
use App\Traits\Sortable\VO\SortedValues;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\URL;
use Illuminate\View\View;

class TemporarilyDeletedUsersController extends Controller
{

    public function index(): View
    {
        return view('admin.users.temporarily-deleted');
    }

    public function sendEmailToRestoreUser(User $identity): RedirectResponse
    {
        event(new UserAccountRestored($identity));

        return back()->with(
            'success',
            'Link to restore user account was sent successfully'
        );
    }

    public function fetchTemporarilyDeletedUsers(
        AdminTemporarilyDeletedSearchRequest $request,
        GetTemporarilyDeletedUsersAction $action
    ): AdminTable {
        $users = $action->handle(
            searchDto: $request->getDto(),
            sortedValues: SortedValues::fromRequest(
                $request->get('sort'),
                $request->get('direction')
            )
        );

        return new AdminTable($users);
    }

    public function restore(User $identity): RedirectResponse
    {
        if ( ! $identity->trashed()) {
            abort(404);
        }

        $identity->restore();

        $signedUrl = URL::signedRoute('verification.verify', [
            'user_id' => $identity->user_id,
            'hash' => sha1($identity->email),
        ]);

        return redirect($signedUrl);
    }

}
