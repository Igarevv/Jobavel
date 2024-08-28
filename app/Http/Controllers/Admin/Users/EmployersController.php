<?php

namespace App\Http\Controllers\Admin\Users;

use App\Actions\Admin\Users\Employers\GetEmployersBySearchAction;
use App\Actions\Admin\Users\Employers\GetEmployersPaginatedAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AdminEmployersSearchRequest;
use Illuminate\View\View;

class EmployersController extends Controller
{
    public function index(GetEmployersPaginatedAction $action): View
    {
        return view('admin.users.employers', ['employers' => $action->handle()]);
    }

    public function search(AdminEmployersSearchRequest $request, GetEmployersBySearchAction $action): View
    {
        $searchDto = $request->getDto();

        return view('admin.users.employers', [
            'employers' => $action->handle($searchDto),
            'input' => $searchDto->fromDto()
        ]);
    }
}
