<?php

declare(strict_types=1);

namespace App\Http\Controllers\Employer;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateVacancyRequest;
use App\Persistence\Models\TechSkill;
use App\Persistence\Models\Vacancy;
use App\Service\Employer\VacancyService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class VacancyController extends Controller
{

    public function __construct(
        protected VacancyService $vacancyService
    ) {}

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
            ->where('is_published', false)
            ->get(['id', 'title', 'salary', 'created_at']);

        return view('employer.vacancy.unpublished',
            ['vacancies' => $vacancies]);
    }

    public function create(): View
    {
        $categories = TechSkill::query()->orderBy('skill_name')
            ->toBase()
            ->get();
        return view('employer.vacancy.create', ['skills' => $categories]);
    }

    public function store(CreateVacancyRequest $request): RedirectResponse
    {
        $vacancyData = $request->validated();

        $vacancyData['employer_id'] = $request->session()->get('user.emp_id');

        $this->vacancyService->create($vacancyData);
        /*return redirect()
            ->route('employer.vacancy.table')
            ->with('vacancy-added', trans('vacancy.added'));*/
    }

}
