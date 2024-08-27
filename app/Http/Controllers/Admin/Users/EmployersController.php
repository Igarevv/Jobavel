<?php

namespace App\Http\Controllers\Admin\Users;

use App\Actions\Admin\Users\GetEmployersPaginatedAction;
use App\Http\Controllers\Controller;
use Illuminate\View\View;

class EmployersController extends Controller
{
    public function index(GetEmployersPaginatedAction $action): View
    {
        return view('admin.users.employers', ['employers' => $action->handle()]);
    }
}
