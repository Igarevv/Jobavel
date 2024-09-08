<?php

namespace App\Http\Controllers\Admin\Users;

use App\Actions\Admin\Users\Employees\GetEmployeesBySearchAction;
use App\Actions\Admin\Users\Employees\GetEmployeesPaginatedAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AdminEmployeesSearchRequest;
use App\Http\Resources\Admin\AdminTable;
use App\Traits\Sortable\VO\SortedValues;
use Illuminate\Http\Request;
use Illuminate\View\View;

class EmployeesController extends Controller
{
    public function index(): View
    {
        return view('admin.users.employees');
    }

    public function fetchEmployees(Request $request, GetEmployeesPaginatedAction $action): AdminTable
    {
        $employers = $action->handle(
            SortedValues::fromRequest($request->get('sort'), $request->get('direction'))
        );

        return new AdminTable($employers);
    }

    public function search(AdminEmployeesSearchRequest $request, GetEmployeesBySearchAction $action): AdminTable
    {
        return new AdminTable($action->handle($request->getDto()));
    }
}
