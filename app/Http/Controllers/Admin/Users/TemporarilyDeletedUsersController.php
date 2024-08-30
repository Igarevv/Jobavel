<?php

namespace App\Http\Controllers\Admin\Users;

use App\Actions\Admin\Users\TemporarilyDeleted\GetTemporarilyDeletedUserBySearchAction as SearchAction;
use App\Actions\Admin\Users\TemporarilyDeleted\GetTemporarilyDeletedUsersAction;
use App\Events\UserAccountRestored;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AdminTemporarilyDeletedSearchRequest;
use App\Persistence\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\URL;
use Illuminate\View\View;

class TemporarilyDeletedUsersController extends Controller
{
    public function index(GetTemporarilyDeletedUsersAction $action): View
    {
        return view('admin.users.temporarily-deleted', ['users' => $action->handle()]);
    }

    public function sendEmailToRestoreUser(User $identity): RedirectResponse
    {
        event(new UserAccountRestored($identity));

        return back()->with('success', 'Link to restore user account was sent successfully');
    }

    public function restore(User $identity): RedirectResponse
    {
        if (! $identity->trashed()) {
            abort(404);
        }

        $identity->restore();

        $signedUrl = URL::signedRoute('verification.verify', [
            'user_id' => $identity->user_id,
            'hash' => sha1($identity->email),
        ]);

        return redirect($signedUrl);
    }

    public function search(AdminTemporarilyDeletedSearchRequest $request, SearchAction $action): View
    {
        $searchDto = $request->getDto();

        return view('admin.users.temporarily-deleted', [
            'users' => $action->handle($searchDto),
            'input' => $searchDto->fromDto()
        ]);
    }
}
