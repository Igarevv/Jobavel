<?php

namespace App\Http\Controllers\Employee;

use App\Actions\Employee\GetEmployeeCvFileAction;
use App\Actions\Employee\GetEmployeeInfoAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Employee\UploadCvRequest;
use App\Persistence\Models\Employee;
use App\Persistence\Models\TechSkill;
use App\Persistence\Models\Vacancy;
use App\Service\Employer\Storage\EmployeeCvService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CvController extends Controller
{
    public function __construct(
        private EmployeeCvService $cvService
    ) {
    }

    public function create(Request $request): View
    {
        if (! $request->user()->can('apply', Vacancy::class)) {
            abort(404);
        }

        return view('employee.cv.create', [
            'filename' => $request->user()->employee->cvFileName()
        ]);
    }

    public function store(UploadCvRequest $request): RedirectResponse
    {
        if (! $request->user()->can('apply', Vacancy::class)) {
            return redirect()->route('login.show');
        }

        $employee = Employee::findByUuid(session('user.emp_id'), ['id']);

        if ($this->cvService->upload($request->file('cv'), $employee)) {
            return back()->with('upload-success', trans('alerts.employee-account.cv-uploaded'));
        }

        return back()->with('upload-failed', 'Something went wrong, when upload your CV. Contact to support');
    }

    public function index(GetEmployeeCvFileAction $employeeCvFile): RedirectResponse|View
    {
        $path = $employeeCvFile->handle(Employee::findByUuid(session('user.emp_id'), ['resume_file']));

        if (! $path) {
            return redirect()->route('employee.cv.create')->with(
                'cv-not-found',
                trans('alerts.employee-account.no-cv')
            );
        }

        return view('pdf', ['path' => $path]);
    }


    public function destroy(): RedirectResponse
    {
        $result = $this->cvService->delete(Employee::findByUuid(session('user.emp_id'), ['id', 'resume_file']));

        if ($result) {
            return back()->with('cv-deleted', 'Your CV was successfully deleted');
        }

        return back()->with('cv-not-deleted', 'Failed, please try again or contact support');
    }

    public function showResume(Request $request, Employee $employee, GetEmployeeCvFileAction $cvFileAction): View
    {
        $this->authorize('view', [$employee, $request->user()?->employer]);

        $this->validate($request, ['type' => 'in:file,manual']);

        if ($request->input('type') === 'manual') {
            $employeePresent = (new GetEmployeeInfoAction())->handle($employee);

            $skillsInRaw = TechSkill::query()
                ->whereIn('id', $employeePresent->skills)
                ->pluck('skill_name');

            return view('employee.cv.manual', [
                'employee' => $employeePresent,
                'skillsInRaw' => $skillsInRaw->implode(', ')
            ]);
        }

        return view('pdf', ['path' => $cvFileAction->handle($employee)]);
    }
}
