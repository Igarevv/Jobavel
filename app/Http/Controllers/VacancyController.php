<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Presenters\VacancyCardPresenter;
use App\Http\Requests\VacancyFilterRequest;
use App\Persistence\Filters\Manual\Vacancy\VacancyFilter;
use App\Service\Employer\Vacancy\VacancyService;
use App\View\ViewModels\SkillsViewModel;
use App\View\ViewModels\VacancyViewModel;
use Illuminate\View\View;

class VacancyController extends Controller
{

    public function __construct(
        protected SkillsViewModel $skillsViewModel
    ) {
    }

    public function show(int $vacancy, VacancyViewModel $vacancyViewModel): View
    {
        $vacancyModel = $vacancyViewModel->vacancy($vacancy);

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

    public function all(VacancyFilterRequest $request, VacancyService $vacancyService): View
    {
        $filter = app()->make(VacancyFilter::class, ['queryParams' => $request->validated()]);

        $vacancies = $vacancyService->allPublishedFilteredVacancies($filter, 6);

        $vacancies = (new VacancyCardPresenter($vacancies))->paginatedCollectionToBase();

        $skills = $this->skillsViewModel->allSkills();

        return view('employer.vacancy.all', [
            'vacancies' => $vacancies,
            'skills' => $skills->toArray()
        ]);
    }

}