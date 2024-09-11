<?php

namespace App\Http\Controllers\Admin\Users;

use App\Actions\Admin\Users\Employers\GetEmployersPaginatedAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AdminEmployersSearchRequest;
use App\Http\Resources\Admin\AdminTable;
use App\Traits\Sortable\VO\SortedValues;
use Illuminate\View\View;

class EmployersController extends Controller
{

    public function __construct() {}

    public function index(): View
    {
        return view('admin.users.employers');
    }

    public function fetchEmployers(
        AdminEmployersSearchRequest $request,
        GetEmployersPaginatedAction $action
    ): AdminTable {
        $employers = $action->handle(
            searchDto: $request->getDto(),
            sortedValues: SortedValues::fromRequest(
                $request->get('sort'),
                $request->get('direction')
            )
        );

        return new AdminTable($employers);
    }

}
