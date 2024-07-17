<?php

declare(strict_types=1);

namespace App\Http\Controllers\Employer;

use App\DTO\VacancyDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\VacancyRequest;
use App\Persistence\Models\Vacancy;
use App\Service\Employer\VacancyService;
use Illuminate\Http\RedirectResponse;

class VacancyManipulationController extends Controller
{

    public function __construct(
        protected VacancyService $vacancyService
    ) {
    }

    public function update(int $vacancy, VacancyRequest $request): RedirectResponse
    {
        $vacancyDto = VacancyDto::fromRequest($request);

        $vacancyDto->connectId($vacancy);

        $this->vacancyService->update($vacancyDto);

        return redirect()->route('vacancies.show', ['vacancy' => $vacancy])
            ->with('edit-success', trans('alerts.vacancy.edited'));
    }

    public function store(VacancyRequest $request): RedirectResponse
    {
        $this->authorize('create', Vacancy::class);

        $vacancyDto = VacancyDto::fromRequest($request);

        $employerId = $request->session()->get('user.emp_id');

        $this->vacancyService->create($employerId, $vacancyDto);

        return redirect()
            ->route('employer.vacancy.unpublished')
            ->with('vacancy-added', trans('alerts.vacancy.added'));
    }

    public function destroy()
    {
    }
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