<?php

declare(strict_types=1);

namespace App\Http\Controllers\Vacancy;

use App\DTO\Vacancy\VacancyDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\Vacancy\VacancyRequest;
use App\Persistence\Models\Vacancy;
use App\Service\Employer\Vacancy\VacancyService;
use App\Support\SlugVacancy;
use App\View\ViewModels\VacancyViewModel;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Str;

class VacancyManipulationController extends Controller
{

    public function __construct(
        protected VacancyService $vacancyService
    ) {
    }

    public function update(SlugVacancy $vacancy, VacancyRequest $request, VacancyViewModel $viewModel): RedirectResponse
    {
        $existedVacancy = $viewModel->vacancy($vacancy->clearSlug());

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

        $this->vacancyService->create(session('user.emp_id'), $vacancyDto);

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

        return redirect()->route('employer.vacancy.trashed')->with('vacancy-deleted', trans('alerts.vacancy.deleted'));
    }

    public function publish(Vacancy $vacancy): RedirectResponse
    {
        $this->authorize('publish', $vacancy);

        if (Str::of($vacancy->employer->company_description)->isEmpty()) {
            return back()->with('errors', trans('alerts.employer.empty-description'));
        }

        $vacancy->publish();

        return redirect()->route('employer.vacancy.published');
    }

    public function unpublish(Vacancy $vacancy): RedirectResponse
    {
        $this->authorize('publish', $vacancy);

        $vacancy->unpublish();

        return redirect()->route('employer.vacancy.unpublished', ['vacancy' => $vacancy->slug]);
    }

}