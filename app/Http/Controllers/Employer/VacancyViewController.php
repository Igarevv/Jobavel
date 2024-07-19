<?php

declare(strict_types=1);

namespace App\Http\Controllers\Employer;

use App\Http\Controllers\Controller;
use App\Persistence\Models\Vacancy;
use App\Service\Employer\Vacancy\TechSkillService;
use App\Service\Employer\Vacancy\VacancyService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class VacancyViewController extends Controller
{

    public function __construct(
        protected VacancyService $vacancyService
    ) {
    }

    /**
     * TODO: сессия пустая
     */
    public function show(int $vacancy): View
    {
        $vacancyModel = $this->vacancyService->getVacancy($vacancy);

        $this->authorize('viewAny', $vacancyModel);

        $employer = $this->vacancyService->getEmployerRelatedToVacancy($vacancyModel, session('user.emp_id'));

        $skills = $vacancyModel->techSkillAsBaseArray();

        $techSkillInRow = implode(' / ', array_map(fn($skill) => $skill->skillName, $skills));

        return view('employer.vacancy.show', [
            'vacancy' => $vacancyModel,
            'employer' => $employer,
            'skillSet' => $skills,
            'skillSetRow' => $techSkillInRow
        ]);
    }

    public function create(TechSkillService $skillService): View
    {
        $this->authorize('create', Vacancy::class);

        $categories = $skillService->getSkillCategories();

        return view('employer.vacancy.create', ['skills' => $categories->toArray()]);
    }

    public function showEdit(int $vacancy, TechSkillService $skillService): View
    {
        $existingVacancy = $this->vacancyService->getVacancy($vacancy);

        $this->authorize('edit', $existingVacancy);

        $categories = $skillService->getSkillCategories();

        $existingSkills = (object) [
            'ids' => $existingVacancy->techSkill->pluck('id')->toArray(),
            'names' => $existingVacancy->techSkill->pluck('skill_name')->toArray(),
        ];

        return view('employer.vacancy.edit', [
            'vacancy' => $existingVacancy,
            'existingSkills' => $existingSkills,
            'skills' => $categories->toArray()
        ]);
    }

    public function unpublished(Request $request): View
    {
        $vacancies = Vacancy::query()->notPublished($request->user()->employer->id)
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


    public function published(TechSkillService $skillService): View
    {
        $vacancies = $this->vacancyService->getPublishedVacancies(
            employerId: session('user.emp_id'),
        );

        return view('employer.vacancy.published', [
            'vacancies' => $vacancies,
            'skills' => $skillService->getSkillCategories()
        ]);
    }

}