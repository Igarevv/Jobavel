<?php

namespace App\Http\Controllers\Admin\Users;

use App\Actions\Admin\Users\Admins\GetAdminsPaginatedAction;
use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\AdminTable;
use App\Traits\Sortable\VO\SortedValues;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminsController extends Controller
{
    public function index(): View
    {
        return view('admin.users.admins');
    }

    public function fetchAdmins(Request $request, GetAdminsPaginatedAction $action): AdminTable
    {
        $admins = $action->handle(
            SortedValues::fromRequest($request->get('sort'), $request->get('direction'))
        );

        return new AdminTable($admins);
    }
}
