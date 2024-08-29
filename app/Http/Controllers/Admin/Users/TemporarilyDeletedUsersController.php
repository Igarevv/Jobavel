<?php

namespace App\Http\Controllers\Admin\Users;

use App\Actions\Admin\Users\TemporarilyDeleted\GetTemporarilyDeletedUserBySearchAction as SearchAction;
use App\Actions\Admin\Users\TemporarilyDeleted\GetTemporarilyDeletedUsersAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AdminTemporarilyDeletedSearchRequest;
use Illuminate\View\View;

class TemporarilyDeletedUsersController extends Controller
{
    public function index(GetTemporarilyDeletedUsersAction $action): View
    {
        return view('admin.users.temporarily-deleted', ['users' => $action->handle()]);
    }

    public function restore()
    {
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
