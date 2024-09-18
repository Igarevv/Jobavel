<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin\Users;

use App\Actions\Admin\Users\Banned\GetBannedUsersPaginatedAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Users\AdminBannedSearchRequest as SearchRequest;
use App\Http\Resources\Admin\AdminTable;
use App\Traits\Sortable\VO\SortedValues;
use Illuminate\View\View;

class AdminBannedUsersController extends Controller
{
    public function index(): View
    {
        return view('admin.users.banned');
    }

    public function fetchBannedUsers(SearchRequest $request, GetBannedUsersPaginatedAction $action): AdminTable
    {
        $bannedUsers = $action->handle(
            dto: $request->getDto(),
            sortedValues: SortedValues::fromRequest(
                fieldName: $request->get('sort'),
                direction: $request->get('direction')
            )
        );

        return new AdminTable($bannedUsers);
    }
}
