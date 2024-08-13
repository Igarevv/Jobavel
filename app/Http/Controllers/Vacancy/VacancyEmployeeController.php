<?php

declare(strict_types=1);

namespace App\Http\Controllers\Vacancy;

use App\Actions\Employee\GetAppliedVacanciesAction;
use App\Actions\Vacancy\GetVacancyEmployeesAction;
use App\DTO\Vacancy\AppliedVacancyDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\Vacancy\ApplyRequest;
use App\Persistence\Models\Employee;
use App\Service\Employer\Vacancy\EmployeeVacancyService;
use App\Support\SlugVacancy;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class VacancyEmployeeController extends Controller
{
    public function __construct(
        private EmployeeVacancyService $employeeVacancyService
    ) {
    }

    public function appliedVacancies(GetAppliedVacanciesAction $appliedVacancies): View
    {
        $vacancies = $appliedVacancies->handle(session('user.emp_id'));

        return view('employee.vacancy.applied', ['vacancies' => $vacancies]);
    }

    public function apply(SlugVacancy $vacancy, ApplyRequest $request): RedirectResponse
    {
        $employee = Employee::findByUuid(session('user.emp_id'));

        $appliedVacancyDto = AppliedVacancyDto::fromRequestWithEntities(
            request: $request,
            vacancy: $vacancy->createFromSlug('id'),
            employee: $employee
        );

        $result = $this->employeeVacancyService->applyEmployeeToVacancy($appliedVacancyDto);

        if (! $result) {
            return redirect()->route('vacancies.show', ['vacancy' => $vacancy->getOriginalSlug()]);
        }

        return redirect()->route('employee.vacancy.applied');
    }

    public function withDrawVacancy(SlugVacancy $vacancy): RedirectResponse
    {
        $employee = Employee::findByUuid(session('user.emp_id'));

        $result = $this->employeeVacancyService->withDrawEmployeeFromVacancy(
            vacancy: $vacancy->createFromSlug('id'),
            employee: $employee
        );

        if ($result) {
            return back()->with('vacancy-withdraw', 'You successfully withdraw the vacancy');
        }

        return back()->with('error', 'Something went wrong when withdrawing vacancy, try again or contact support');
    }

    public function appliedEmployees(SlugVacancy $vacancy, GetVacancyEmployeesAction $employeesForVacancy): JsonResponse
    {
        $employees = $employeesForVacancy->handle($vacancy->createFromSlug());

        return response()->json([
            'data' => $employees->items(),
            'current_page' => $employees->currentPage(),
            'last_page' => $employees->lastPage(),
            'next_page_url' => $employees->nextPageUrl(),
            'prev_page_url' => $employees->previousPageUrl(),
        ]);
    }

    public function changeAttachedDataForVacancy(ApplyRequest $request): RedirectResponse
    {
        $updateVacancyDto = AppliedVacancyDto::fromRequestWithEntities(
            request: $request,
            vacancy: (new SlugVacancy($request->validated('vacancySlug')))->createFromSlug('id'),
            employee: Employee::findByUuid(session('user.emp_id'))
        );

        $changes = $this->employeeVacancyService->updateAttachedDataForVacancy($updateVacancyDto);

        return $changes >= 1
            ? back()->with('update-success', 'Your CV or email was successfully changed')
            : back()->with('nothing-updated', 'Nothing was changed');
    }

}