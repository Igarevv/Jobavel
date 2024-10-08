<?php

namespace App\Http\Controllers\Employee\CV;

use App\Http\Controllers\Controller;
use App\Http\Requests\Employee\UploadCvRequest;
use App\Persistence\Models\Employee;
use App\Persistence\Models\Vacancy;
use App\Service\Employer\Storage\EmployeeCvService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ManipulateCvController extends Controller
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

        $employee = Employee::findByUuid(session('user.emp_id'), ['id', 'resume_file']);

        if ($this->cvService->upload($request->file('cv'), $employee)) {
            return back()->with('upload-success', trans('alerts.employee-account.cv-uploaded'));
        }

        return back()->with('upload-failed', 'Something went wrong, when upload your CV. Contact to support');
    }

    public function destroy(): RedirectResponse
    {
        $result = $this->cvService->delete(Employee::findByUuid(session('user.emp_id'), ['id', 'resume_file']));

        if ($result) {
            return back()->with('cv-deleted', 'Your CV was successfully deleted');
        }

        return back()->with('cv-not-deleted', 'Failed, please try again or contact support');
    }

}
