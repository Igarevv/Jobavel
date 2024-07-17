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

        $this->authorize('viewAny', $vacancyModel);

        $employer = $this->vacancyService->getEmployerRelatedToVacancy($vacancyModel, session('user.emp_id'));

        return view('employer.vacancy.show', [
            'vacancy' => $vacancyModel,
            'employer' => $employer,
            'skillSet' => $vacancyModel->techSkillAsBaseArray()
        ]);
    }

    public function create(): View
    {
        $this->authorize('create', Vacancy::class);

        $categories = $this->vacancyService->getSkillCategories();

        return view('employer.vacancy.create', ['skills' => $categories->toArray()]);
    }

    public function showEdit(int $vacancy): View
    {
        $existingVacancy = $this->vacancyService->getVacancy($vacancy);

        $this->authorize('edit', $existingVacancy);

        $categories = $this->vacancyService->getSkillCategories();

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
        $vacancies = Vacancy::query()->where('employer_id', $request->user()->employer->id)
            ->notPublished()
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


    /*public function published()
    {
        $jobInfo = (object) [
            'position' => 'Backend Laravel Developer',
            'company' => 'Google Inc.',
            'address' => 'New York',
            'salary' => '$2500',
            'image' => 'Adidas_Logo.jpg',
            'skills' => [
                'Laravel',
                'PHP',
                'PostgreSql',
                'Docker',
                'Git',
            ],
        ];
        return view('employer.vacancy.published', ['jobInfo' => $jobInfo]);
    }*/
}