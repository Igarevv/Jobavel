<?php

namespace App\Http\Controllers\Admin\Users;

use App\Actions\Admin\Users\Employers\GetEmployersBySearchAction;
use App\Actions\Admin\Users\Employers\GetEmployersPaginatedAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AdminEmployersSearchRequest;
use App\Http\Resources\Admin\AdminTable;
use Illuminate\View\View;

class EmployersController extends Controller
{
    public function __construct()
    {
    }

    public function index(GetEmployersPaginatedAction $action): View
    {
        return view('admin.users.employers', ['employers' => $action->handle()]);
    }

    public function fetchEmployers(GetEmployersPaginatedAction $action): AdminTable
    {
        $employers = $action->handle();

        return new AdminTable($employers);
    }

    public function search(AdminEmployersSearchRequest $request, GetEmployersBySearchAction $action): AdminTable
    {
        $searchDto = $request->getDto();

        $employers = $action->handle($searchDto);

        return new AdminTable($employers);
    }
}
