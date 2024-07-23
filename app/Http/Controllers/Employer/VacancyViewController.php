<?php

declare(strict_types=1);

namespace App\Http\Controllers\Employer;

use App\Http\Controllers\Controller;
use App\Http\Requests\VacancyFilterRequest;
use App\Persistence\Filters\Manual\Vacancy\VacancyFilter;
use App\Persistence\Models\Vacancy;
use App\View\ViewModels\SkillsViewModel;
use App\View\ViewModels\VacancyViewModel;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\View\View;

class VacancyViewController extends Controller
{

    public function __construct(
        protected VacancyViewModel $viewModel
    ) {
    }

    public function show(int $vacancy, SkillsViewModel $viewModel): View
    {
        $vacancyModel = $this->viewModel->vacancy($vacancy);

        $this->authorize('viewAny', $vacancyModel);

        $employer = $this->viewModel->vacancyEmployerData($vacancyModel);

        $skills = collect($vacancyModel->techSkillAsBaseArray());

        return view('employer.vacancy.show', [
            'vacancy' => $vacancyModel,
            'employer' => $employer,
            'skillSet' => $skills,
            'skillSetRow' => $viewModel->skillsAsRow($skills)
        ]);
    }

    public function create(SkillsViewModel $skillService): View
    {
        $this->authorize('create', Vacancy::class);

        $categories = $skillService->allSkills();

        return view('employer.vacancy.create', ['skills' => $categories->toArray()]);
    }

    public function showEdit(int $vacancy, SkillsViewModel $viewModel): View
    {
        $existingVacancy = $this->viewModel->vacancy($vacancy);

        $this->authorize('edit', $existingVacancy);

        return view('employer.vacancy.edit', [
            'vacancy' => $existingVacancy,
            'existingSkills' => $viewModel->pluckExistingSkillsFromVacancy($existingVacancy),
            'skills' => $viewModel->allSkills()->toArray()
        ]);
    }

    public function unpublished(Request $request): View
    {
        $vacancies = Vacancy::query()->notPublished()
            ->where('employer_id', $request->user()->employer->id)
            ->paginate(5, ['id', 'title', 'salary', 'created_at', 'updated_at']);

        return view('employer.vacancy.unpublished',
            ['vacancies' => $vacancies]);
    }

    public function viewTrashed(Request $request): View
    {
        $vacancies = Vacancy::onlyTrashed()
            ->where('employer_id', $request->user()->employer->id)
            ->paginate(5, ['id', 'title', 'salary', 'created_at', 'deleted_at']);

        return view('employer.vacancy.trashed', ['vacancies' => $vacancies]);
    }


    public function published(VacancyFilterRequest $request, SkillsViewModel $skillService, Application $app): View
    {
        $filter = $app->make(VacancyFilter::class, ['queryParams' => $request->validated()]);

        $vacancies = $this->viewModel->publishedManualFilteredVacancies(
            filter: $filter,
            employerId: session('user.emp_id'),
        );

        return view('employer.vacancy.published', [
            'vacancies' => $vacancies,
            'skills' => $skillService->allSkills()->toArray()
        ]);
    }

}