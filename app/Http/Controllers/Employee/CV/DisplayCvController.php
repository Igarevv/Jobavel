<?php

namespace App\Http\Controllers\Employee\CV;

use App\Actions\Employee\GetEmployeeCvFileAction;
use App\Actions\Employee\GetEmployeeInfoAction;
use App\Http\Controllers\Controller;
use App\Persistence\Models\Employee;
use App\View\ViewModels\SkillsViewModel;
use Illuminate\Http\Request;

class DisplayCvController extends Controller
{
    public function __construct(
        private GetEmployeeInfoAction $employeeInfoAction,
        private GetEmployeeCvFileAction $employeeCvFileAction,
        private SkillsViewModel $skillsView
    ) {
    }

    public function showResume(Request $request, Employee $employee)
    {
        if (auth('admin')->check()) {
            auth()->shouldUse('admin');
        }

        $this->authorize('view', [$employee, $request->user()?->employer]);

        $this->validate($request, ['type' => 'in:file,manual']);

        if ($request->input('type') === 'manual') {
            $employeePresent = $this->employeeInfoAction->handle($employee);

            return view('employee.cv.manual', [
                'employee' => $employeePresent,
                'skillsInRaw' => $this->getSkillNamesAsRow($employeePresent->skills)
            ]);
        }

        return response()->redirectTo($this->employeeCvFileAction->handle($employee));
    }

    private function getSkillNamesAsRow(?array $ids): ?string
    {
        return $ids ? $this->skillsView->fetchSkillNamesByIds($ids) : null;
    }

}
