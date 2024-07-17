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
        $existedVacancy = $this->vacancyService->getVacancy($vacancy);

        $this->authorize('edit', $existedVacancy);

        $vacancyDto = VacancyDto::fromRequest($request);

        $this->vacancyService->update($existedVacancy, $vacancyDto);

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

    public function destroy(Vacancy $vacancy): RedirectResponse
    {
        $this->authorize('delete', $vacancy);
        
        $vacancy->delete();

        if ($vacancy->isPublished()) {
            $vacancy->unpublish();
        }

        return redirect()->route('employer.vacancy.unpublished')
            ->with('vacancy-trashed', trans('alerts.vacancy.trashed'));
    }

    public function restore(Vacancy $vacancy): RedirectResponse
    {
        $vacancy->restore();

        return redirect()->route('employer.vacancy.unpublished')
            ->with('vacancy-restored', trans('alerts.vacancy.restored'));
    }

    public function deleteForever(Vacancy $vacancy): RedirectResponse
    {
        $this->authorize('delete', $vacancy);

        $vacancy->forceDelete();

        return back()->with('vacancy-deleted', trans('alerts.vacancy.deleted'));
    }

    public function publish(Vacancy $vacancy): RedirectResponse
    {
        $this->authorize('publish', $vacancy);

        $vacancy->publish();

        return redirect()->route('vacancies.show', ['vacancy' => $vacancy->id]);
    }

    public function unpublish(Vacancy $vacancy): RedirectResponse
    {
        $this->authorize('publish', $vacancy);

        $vacancy->unpublish();

        return redirect()->route('vacancies.show', ['vacancy' => $vacancy->id]);
    }

}