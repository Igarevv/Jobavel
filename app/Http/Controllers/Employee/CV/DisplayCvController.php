<?php

namespace App\Http\Controllers\Employee\CV;

use App\Actions\Employee\GetEmployeeCvFileAction;
use App\Actions\Employee\GetEmployeeInfoAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Employee\ShowResumeRequest;
use App\Persistence\Models\Employee;
use App\View\ViewModels\SkillsViewModel;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class DisplayCvController extends Controller
{
    public function __construct(
        private GetEmployeeInfoAction $employeeInfoAction,
        private GetEmployeeCvFileAction $employeeCvFileAction,
        private SkillsViewModel $skillsView
    ) {
    }

    public function showResume(ShowResumeRequest $request, Employee $employee): View|RedirectResponse
    {
        if (auth('admin')->check()) {
            auth()->shouldUse('admin');
        }

        if ($request->input('type') === 'manual') {
            return $this->handleManualResume($employee);
        }

        return $this->handleFileResume($employee);
    }

    private function handleManualResume(Employee $employee): View
    {
        if (! $employee->hasMinimallyFilledPersonalInfo()) {
            abort(404);
        }

        $employeePresent = $this->employeeInfoAction->handle($employee);

        return view('employee.cv.manual', [
            'employee' => $employeePresent,
            'skillsInRaw' => $this->getSkillNamesAsRow($employeePresent->skills)
        ]);
    }

    private function handleFileResume(Employee $employee): RedirectResponse
    {
        $filePath = $this->employeeCvFileAction->handle($employee);

        if (! $filePath) {
            abort(404);
        }

        return response()->redirectTo($filePath);
    }

    private function getSkillNamesAsRow(?array $ids): ?string
    {
        return $ids ? $this->skillsView->fetchSkillNamesByIds($ids) : null;
    }

}
