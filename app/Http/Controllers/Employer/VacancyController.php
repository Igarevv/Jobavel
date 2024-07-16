<?php

declare(strict_types=1);

namespace App\Http\Controllers\Employer;

use App\DTO\VacancyDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\VacancyRequest;
use App\Persistence\Models\Vacancy;
use App\Service\Employer\VacancyService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class VacancyController extends Controller
{

    public function __construct(
        protected VacancyService $vacancyService
    ) {
    }

    public function show(int $vacancy): View
    {
        $vacancyModel = $this->vacancyService->getVacancy($vacancy);

        $this->authorize('view', $vacancyModel);

        $employer = $this->vacancyService->getEmployerRelatedToVacancy($vacancyModel);

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

    public function edit(VacancyRequest $request)
    {
        dd($request->validated());
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

    public function unpublished(Request $request): View
    {
        $vacancies = Vacancy::where('employer_id', $request->user()->employer->id)
            ->notPublished()
            ->get(['id', 'title', 'salary', 'created_at']);

        return view('employer.vacancy.unpublished',
            ['vacancies' => $vacancies]);
    }

    public function create(): View
    {
        $this->authorize('create', Vacancy::class);

        $categories = $this->vacancyService->getSkillCategories();

        return view('employer.vacancy.create', ['skills' => $categories->toArray()]);
    }

    public function store(VacancyRequest $request): RedirectResponse
    {
        $this->authorize('create', Vacancy::class);

        $vacancyDto = VacancyDto::fromRequest($request);

        $employerId = $request->session()->get('user.emp_id');

        $this->vacancyService->create($employerId, $vacancyDto);

        return redirect()
            ->route('employer.vacancy.unpublished')
            ->with('vacancy-added', trans('vacancy.added'));
    }

}
