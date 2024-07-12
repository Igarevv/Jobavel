<?php

declare(strict_types=1);

namespace App\Http\Controllers\Employer;

use App\DTO\VacancyDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateVacancyRequest;
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

    public function show(Vacancy $vacancy): View
    {
        $vacancyData = $this->vacancyService->getVacancy($vacancy);

        $employer = $this->vacancyService->getEmployerRelatedToVacancy($vacancy);

        return view('employer.vacancy.show', [
            'vacancy' => $vacancyData,
            'employer' => $employer,
        ]);
    }

    public function published()
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
    }

    public function unpublished(Request $request): View
    {
        $employerId = $request->user()->getUserIdByRole();

        $vacancies = Vacancy::where('employer_id', $employerId)
            ->notPublished()
            ->get(['id', 'title', 'salary', 'created_at']);

        return view('employer.vacancy.unpublished',
            ['vacancies' => $vacancies]);
    }

    public function create(): View
    {
        $categories = $this->vacancyService->getSkillCategories();

        $categories = $categories->chunk(ceil($categories->count() / 3));

        return view('employer.vacancy.create', ['skills' => $categories]);
    }

    public function store(CreateVacancyRequest $request): RedirectResponse
    {
        $vacancyDto = VacancyDto::fromRequest($request);

        $employerId = $request->session()->get('user.emp_id');

        $this->vacancyService->create($employerId, $vacancyDto);

        return redirect()
            ->route('employer.vacancy.unpublished')
            ->with('vacancy-added', trans('vacancy.added'));
    }

}
