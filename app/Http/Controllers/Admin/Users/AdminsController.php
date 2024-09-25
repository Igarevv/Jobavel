<?php

namespace App\Http\Controllers\Admin\Users;

use App\Actions\Admin\Users\Admins\GetAdminsActionsPaginatedAction as AdminsActions;
use App\Actions\Admin\Users\Admins\GetAdminsPaginatedAction;
use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\AdminTable;
use App\Persistence\Models\Admin;
use App\Traits\Sortable\VO\SortedValues;
use Illuminate\Http\RedirectResponse;
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

    public function fetchActionsMadeByAdmin(Admin $admin, AdminsActions $action): AdminTable
    {
        return new AdminTable($action->handle($admin));
    }

    public function deactivateAdmin(Admin $identity): RedirectResponse
    {
        if (auth('admin')->id() !== $identity->id) {
            $identity->deactivate();

            return back()->with('deactivated', 'Admin was successfully deactivated.');
        }

        return back();
    }

    public function activateAdmin(Admin $identity): RedirectResponse
    {
        if (auth('admin')->id() !== $identity->id) {
            $identity->activate();

            return back()->with('activated', 'Admin was successfully activated.');
        }

        return back();
    }
}
