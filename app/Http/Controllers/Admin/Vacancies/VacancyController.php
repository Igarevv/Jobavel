<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin\Vacancies;

use App\Actions\Admin\Vacancies\GetEmployerByVacancyAction;
use App\Actions\Admin\Vacancies\GetVacanciesPaginatedAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AdminVacanciesSearchRequest;
use App\Http\Resources\Admin\AdminTable;
use App\Http\Resources\Admin\EmployerVacancies;
use App\Persistence\Models\Employer;
use App\Service\Employer\Storage\EmployerLogoService;
use App\Support\SlugVacancy;
use App\Traits\Sortable\VO\SortedValues;
use App\View\ViewModels\VacancyViewModel;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;

class VacancyController extends Controller
{
    public function index(): View
    {
        return view('admin.vacancies');
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
}
