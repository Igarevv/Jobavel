<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Presenters\VacancyCardPresenter;
use App\Http\Requests\Vacancy\VacancyFilterRequest;
use App\Persistence\Filters\Manual\Vacancy\VacancyFilter;
use App\Service\Employer\Vacancy\VacancyService;
use App\Support\SlugVacancy;
use App\View\ViewModels\SkillsViewModel;
use App\View\ViewModels\VacancyViewModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class VacancyController extends Controller
{

    public function __construct(
        protected SkillsViewModel $skillsViewModel,
        protected VacancyService $vacancyService
    ) {
    }

    public function show(SlugVacancy $vacancy, VacancyViewModel $vacancyViewModel): View
    {
        $vacancyModel = $vacancyViewModel->vacancy($vacancy->getIdFromSlug());

        if (Auth::guard('admin')->check()) {
            Auth::shouldUse('admin');
        }

        $this->authorize('viewAny', $vacancyModel);

        $employer = $vacancyViewModel->vacancyEmployerData($vacancyModel);

        $skills = $vacancyModel->techSkillsAsArrayOfBase();

        return view('employer.vacancy.show', [
            'vacancy' => $vacancyModel,
            'employer' => $employer,
            'skillSet' => $skills,
            'skillSetRow' => $this->skillsViewModel->skillsAsRow($skills)
        ]);
    }

    public function all(VacancyFilterRequest $request): View
    {
        if ($request->has('search')) {
            return $this->search($request->get('search'));
        }

        $filter = app()->make(VacancyFilter::class, ['queryParams' => $request->validated()]);

        $vacancies = $this->vacancyService->allPublishedFilteredVacancies($filter, 6);

        $vacancies = (new VacancyCardPresenter($vacancies))->paginatedCollectionToBase();

        return view('employer.vacancy.all', [
            'vacancies' => $vacancies,
            'input' => (object)$request->input(),
            'skills' => $this->skillsViewModel->allSkills()->toArray()
        ]);
    }

    private function search(string $searchable): View
    {
        $vacancies = $this->vacancyService->searchVacancies($searchable, 10);

        $vacancies = (new VacancyCardPresenter($vacancies))->paginatedCollectionToBase();

        return view('employer.vacancy.all', [
            'search' => $searchable,
            'vacancies' => $vacancies,
            'skills' => $this->skillsViewModel->allSkills()->toArray()
        ]);
    }
}
