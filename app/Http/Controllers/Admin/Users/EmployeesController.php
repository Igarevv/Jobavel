<?php

namespace App\Http\Controllers\Admin\Users;

use App\Actions\Admin\Users\Employees\GetEmployeesBySearchAction;
use App\Actions\Admin\Users\Employees\GetEmployeesPaginatedAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AdminEmployeesSearchRequest;
use Illuminate\View\View;

class EmployeesController extends Controller
{
    public function index(GetEmployeesPaginatedAction $action): View
    {
        return view('admin.users.employees', ['employees' => $action->handle()]);
    }

    public function search(AdminEmployeesSearchRequest $request, GetEmployeesBySearchAction $action): View
    {
        $searchDto = $request->getDto();

        return view('admin.users.employees', [
            'employees' => $action->handle($searchDto),
            'input' => $searchDto->fromDto()
        ]);
    }
}
