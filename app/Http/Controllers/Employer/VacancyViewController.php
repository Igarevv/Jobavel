<?php

declare(strict_types=1);

namespace App\Http\Controllers\Employer;

use App\Http\Controllers\Controller;
use App\Persistence\Models\Vacancy;
use App\Service\Employer\VacancyService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class VacancyViewController extends Controller
{

    public function __construct(
        protected VacancyService $vacancyService
    ) {
    }

    public function show(int $vacancy): View
    {
        $vacancyModel = $this->vacancyService->getVacancy($vacancy);

        $this->authorize('view', $vacancyModel);

        $employer = $this->vacancyService->getEmployerRelatedToVacancy($vacancyModel, session('user.emp_id'));

        return view('employer.vacancy.show', [
            'vacancy' => $vacancyModel,
            'employer' => $employer,
            'skillSet' => $vacancyModel->techSkillAsBaseArray()
        ]);
    }

    public function showEdit(Vacancy $vacancy): View
    {
        $this->authorize('view', $vacancy);

        $categories = $this->vacancyService->getSkillCategories();

        $existingSkills = (object) [
            'ids' => $vacancy->techSkill->pluck('id')->toArray(),
            'names' => $vacancy->techSkill->pluck('skill_name')->toArray(),
        ];

        return view('employer.vacancy.edit', [
            'vacancy' => $vacancy,
            'existingSkills' => $existingSkills,
            'skills' => $categories->toArray()
        ]);
    }

    public function unpublished(Request $request): View
    {
        $vacancies = Vacancy::where('employer_id', $request->user()->employer->id)
            ->notPublished()
            ->get(['id', 'title', 'salary', 'created_at', 'updated_at']);

        return view('employer.vacancy.unpublished',
            ['vacancies' => $vacancies]);
    }

    public function create(): View
    {
        $this->authorize('create', Vacancy::class);

        $categories = $this->vacancyService->getSkillCategories();

        return view('employer.vacancy.create', ['skills' => $categories->toArray()]);
    }

}