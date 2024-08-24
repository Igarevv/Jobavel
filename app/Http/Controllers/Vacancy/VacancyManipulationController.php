<?php

declare(strict_types=1);

namespace App\Http\Controllers\Vacancy;

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
        $existedVacancy = $viewModel->vacancy($vacancy->getIdFromSlug());

        $this->authorize('edit', $existedVacancy);

        $this->vacancyService->update($existedVacancy, $request->getDto());

        return redirect()->route('vacancies.show', ['vacancy' => $vacancy])
            ->with('edit-success', trans('alerts.vacancy.edited'));
    }

    public function store(VacancyRequest $request): RedirectResponse
    {
        $this->authorize('create', Vacancy::class);

        $this->vacancyService->create(session('user.emp_id'), $request->getDto());

        return redirect()
            ->route('employer.vacancy.unpublished')
            ->with('vacancy-added', trans('alerts.vacancy.added'));
    }

    public function destroy(SlugVacancy $vacancy): RedirectResponse
    {
        $vacancyModel = $vacancy->createFromSlug();

        $this->authorize('delete', $vacancyModel);

        $vacancyModel->delete();

        if ($vacancyModel->isPublished()) {
            $vacancyModel->unpublish();
        }

        return redirect()->route('employer.vacancy.unpublished')
            ->with('vacancy-trashed', trans('alerts.vacancy.trashed'));
    }

    public function restore(SlugVacancy $vacancy): RedirectResponse
    {
        $vacancy->createFromSlug()->restore();

        return redirect()->route('employer.vacancy.unpublished')
            ->with('vacancy-restored', trans('alerts.vacancy.restored'));
    }

    public function deleteForever(SlugVacancy $vacancy): RedirectResponse
    {
        $vacancyModel = $vacancy->createFromSlug();

        $this->authorize('delete', $vacancyModel);

        $vacancyModel->forceDelete();

        return redirect()->route('employer.vacancy.trashed')->with('vacancy-deleted', trans('alerts.vacancy.deleted'));
    }

    public function publish(SlugVacancy $vacancy): RedirectResponse
    {
        $vacancyModel = $vacancy->createFromSlug();

        $this->authorize('publish', $vacancyModel);

        if (Str::of($vacancyModel->employer->company_description)->isEmpty()) {
            return back()->with('errors', trans('alerts.employer.empty-description'));
        }

        $vacancyModel->publish();

        return redirect()->route('employer.vacancy.published');
    }

    public function unpublish(SlugVacancy $vacancy): RedirectResponse
    {
        $vacancyModel = $vacancy->createFromSlug();

        $this->authorize('publish', $vacancyModel);

        $vacancyModel->unpublish();

        return redirect()->route('employer.vacancy.unpublished', ['vacancy' => $vacancyModel->slug]);
    }

}