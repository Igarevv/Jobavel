<?php

namespace App\Http\Controllers\Employee\СV;

use App\Actions\Employee\GetEmployeeCvFileAction;
use App\Actions\Employee\GetEmployeeInfoAction;
use App\Http\Controllers\Controller;
use App\Persistence\Models\Employee;
use App\Persistence\Models\TechSkill;
use App\View\ViewModels\SkillsViewModel;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class DisplayCvController extends Controller
{
    public function __construct(
        private GetEmployeeInfoAction $employeeInfoAction,
        private GetEmployeeCvFileAction $employeeCvFileAction,
        private SkillsViewModel $skillsView
    ) {}

    public function showResume(Request $request, Employee $employee): BinaryFileResponse|View
    {
        $this->authorize('view', [$employee, $request->user()?->employer]);

        $this->validate($request, ['type' => 'in:file,manual']);

        if ($request->input('type') === 'manual') {
            $employeePresent = $this->employeeInfoAction->handle($employee);

            return view('employee.cv.manual', [
                'employee' => $employeePresent,
                'skillsInRaw' => $this->getSkillNamesAsRow($employeePresent->skills)
            ]);
        }

        return response()->file($this->employeeCvFileAction->handle($employee));
    }

    private function getSkillNamesAsRow(?array $ids): ?string
    {
        return $ids ? $this->skillsView->fetchSkillNamesByIds($ids) : null;
    }

}
