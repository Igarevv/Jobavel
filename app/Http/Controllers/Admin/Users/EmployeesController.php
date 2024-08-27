<?php

namespace App\Http\Controllers\Admin\Users;

use App\Actions\Admin\Users\GetEmployeesPaginatedAction;
use App\Http\Controllers\Controller;
use Illuminate\View\View;

class EmployeesController extends Controller
{
    public function index(GetEmployeesPaginatedAction $action): View
    {
        return view('admin.users.employees', ['employees' => $action->handle()]);
    }
}
