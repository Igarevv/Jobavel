<?php

namespace App\Http\Controllers\Admin\Users;

use App\Actions\Admin\Users\Employees\GetEmployeesPaginatedAction;
use App\Exceptions\BanException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Users\AdminEmployeesSearchRequest;
use App\Http\Requests\Admin\Vacancy\AdminBanUserRequest;
use App\Http\Resources\Admin\AdminTable;
use App\Service\Admin\AdminActions\AdminBanService;
use App\Traits\Sortable\VO\SortedValues;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class EmployeesController extends Controller
{

    public function index(): View
    {
        return view('admin.users.employees');
    }

    public function fetchEmployees(AdminEmployeesSearchRequest $request, GetEmployeesPaginatedAction $action): AdminTable
    {
        $employers = $action->handle(
            searchDto: $request->getDto(),
            sortedValues: SortedValues::fromRequest(
                $request->get('sort'),
                $request->get('direction')
            )
        );

        return new AdminTable($employers);
    }

    public function banEmployee(AdminBanUserRequest $request, AdminBanService $service): RedirectResponse
    {
        try {
            $dto = $request->getDto();

            $result = $service->ban($dto);
        } catch (BanException $e) {
            return redirect()->route('admin.users.banned')
                ->with('error', $e->getMessage());
        }

        $message = $result === AdminBanService::BANNED_PERMANENTLY
            ? sprintf(trans('alerts.admin.ban-perm'), $dto->getActionableModelId())
            : sprintf(trans('alerts.admin.ban-temp'), $dto->getActionableModelId(), $dto->getBanDurationEnum()->toString());

        return redirect()->route('admin.users.banned')->with('success-ban', $message);
    }

}
