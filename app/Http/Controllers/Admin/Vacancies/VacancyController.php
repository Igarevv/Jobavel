<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin\Vacancies;

use App\Actions\Admin\Vacancies\GetEmployerByVacancyAction;
use App\Actions\Admin\Vacancies\GetVacanciesPaginatedAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Vacancy\AdminDeleteVacancyRequest;
use App\Http\Requests\Admin\Vacancy\AdminVacanciesSearchRequest;
use App\Http\Resources\Admin\AdminTable;
use App\Http\Resources\Admin\EmployerVacancies;
use App\Persistence\Models\Admin;
use App\Persistence\Models\Employer;
use App\Service\Admin\AdminActions\AdminVacancyService;
use App\Support\SlugVacancy;
use App\Traits\Sortable\VO\SortedValues;
use App\View\ViewModels\VacancyViewModel;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use InvalidArgumentException;

class VacancyController extends Controller
{
    public function index(): View
    {
        return view('admin.vacancy.list');
    }

    public function fetchVacancies(AdminVacanciesSearchRequest $request, GetVacanciesPaginatedAction $action): AdminTable
    {
        $vacancies = $action->handle(
            searchDto: $request->getDto(),
            sortedValues: SortedValues::fromRequest($request->get('sort'), $request->get('direction'))
        );

        return new AdminTable($vacancies);
    }

    public function employerVacancies(Employer $employer, VacancyViewModel $vacancyViewModel): EmployerVacancies
    {
        $vacancies = $vacancyViewModel->getAllVacanciesRelatedToEmployer($employer, [
            'id',
            'slug',
            'status',
            'title',
            'location',
            'employment_type',
            'published_at',
            'response_number',
            'created_at',
        ]);

        return new EmployerVacancies($vacancies);
    }

    public function vacancyOwner(SlugVacancy $vacancy, GetEmployerByVacancyAction $action): JsonResponse
    {
        return response()->json(
            $action->handle($vacancy->createFromSlug('id', 'slug', 'employer_id'))
        );
    }

    public function deleteVacancyByAdmin(AdminDeleteVacancyRequest $request, AdminVacancyService $vacancyService): RedirectResponse
    {
        $dto = $request->getDto();

        $this->authorize('moderate', [Admin::class, $dto->getActionableModel()]);

        try {
            $vacancyService->delete($dto);
        } catch (InvalidArgumentException $e) {
            return back()->with('error', $e->getMessage());
        }

        return redirect()->route('admin.vacancies.index')
            ->with('vacancy-deleted', trans('alerts.admin.vacancy-deleted'));
    }
}
