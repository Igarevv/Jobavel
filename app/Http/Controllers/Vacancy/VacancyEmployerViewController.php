<?php

declare(strict_types=1);

namespace App\Http\Controllers\Vacancy;

use App\Http\Controllers\Controller;
use App\Http\Presenters\VacancyCardPresenter;
use App\Http\Requests\Vacancy\VacancyFilterRequest as FilterRequest;
use App\Persistence\Filters\Manual\Vacancy\VacancyFilter;
use App\Persistence\Models\Vacancy;
use App\Service\Employer\Vacancy\VacancyService;
use App\Support\SlugVacancy;
use App\View\ViewModels\SkillsViewModel;
use App\View\ViewModels\VacancyViewModel;
use Illuminate\Http\Request;
use Illuminate\View\View;

class VacancyEmployerViewController extends Controller
{

    public function __construct(
        protected SkillsViewModel $skillsViewModel
    ) {}

    public function create(): View
    {
        $this->authorize('create', Vacancy::class);

        $categories = $this->skillsViewModel->allSkills();

        return view('employer.vacancy.create', ['skills' => $categories->toArray()]);
    }

    public function showEdit(SlugVacancy $vacancy, VacancyViewModel $vacancyViewModel): View
    {
        $existingVacancy = $vacancyViewModel->vacancy($vacancy->getIdFromSlug());

        $this->authorize('edit', $existingVacancy);

        return view('employer.vacancy.edit', [
            'vacancy' => $existingVacancy,
            'existingSkills' => $this->skillsViewModel->pluckExistingSkillsFromVacancy($existingVacancy),
            'skills' => $this->skillsViewModel->allSkills()->toArray(),
        ]);
    }

    public function viewTrashed(Request $request): View
    {
        $vacancies = Vacancy::onlyTrashed()
            ->where('employer_id', $request->user()->employer->id)
            ->paginate(5, ['id', 'title', 'salary', 'created_at', 'deleted_at', 'slug']);

        return view('employer.vacancy.trashed', ['vacancies' => $vacancies]);
    }

    public function showTrashedPreview(SlugVacancy $vacancy, VacancyViewModel $vacancyViewModel): View
    {
        $vacancyModel = $vacancy->createFromSlug();

        $this->authorize('view', $vacancyModel);

        if ( ! $vacancyModel->trashed()) {
            abort(404);
        }
        // was trashed by admin не работает
        $employer = $vacancyViewModel->vacancyEmployerData($vacancyModel);

        $skills = $vacancyModel->techSkillsAsArrayOfBase();

        return view('employer.vacancy.trashed-preview', [
            'vacancy' => $vacancyModel,
            'employer' => $employer,
            'skillSet' => $skills,
            'skillSetRow' => $this->skillsViewModel->skillsAsRow($skills),
        ]);
    }

    public function publishedForEmployer(FilterRequest $request, VacancyService $vacancyService): View
    {
        $filter = app()->make(VacancyFilter::class, ['queryParams' => $request->validated()]);

        $vacancies = $vacancyService->publishedFilteredVacanciesForEmployer(
            filter: $filter,
            employerId: session('user.emp_id'),
        );

        $vacancies = (new VacancyCardPresenter($vacancies))->paginatedCollectionToBase();

        return view('employer.vacancy.published', [
            'vacancies' => $vacancies,
            'skills' => $this->skillsViewModel->allSkills()->toArray(),
        ]);
    }

    public function unpublished(Request $request): View
    {
        $vacancies = Vacancy::query()->allExceptPublishedAndTrashed($request->user()->employer)
            ->paginate(5, [
                'id',
                'title',
                'salary',
                'created_at',
                'updated_at',
                'slug',
                'status',
            ]);

        return view(
            'employer.vacancy.unpublished',
            ['vacancies' => $vacancies]
        );
    }

    public function applied(Request $request, VacancyViewModel $vacancyViewModel): View
    {
        $vacancies = $vacancyViewModel->getAllVacanciesRelatedToEmployer(
            employer: $request->user()->employer,
            columns: ['id', 'title', 'slug', 'created_at']
        );

        return view('employer.vacancy.applied', ['vacancies' => $vacancies]);
    }

}
