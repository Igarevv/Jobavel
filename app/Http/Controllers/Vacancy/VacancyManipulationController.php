<?php

declare(strict_types=1);

namespace App\Http\Controllers\Vacancy;

use App\Exceptions\NotEnoughInfoToContinueException;
use App\Exceptions\VacancyStatusException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Vacancy\VacancyCreateRequest;
use App\Http\Requests\Vacancy\VacancyUpdateRequest;
use App\Service\Employer\Vacancy\VacancyService;
use App\Support\SlugVacancy;
use App\View\ViewModels\VacancyViewModel;
use Illuminate\Http\RedirectResponse;

class VacancyManipulationController extends Controller
{

    public function __construct(
        protected VacancyService $vacancyService
    ) {
    }

    public function update(SlugVacancy $vacancy, VacancyUpdateRequest $request, VacancyViewModel $viewModel): RedirectResponse
    {
        $existedVacancy = $viewModel->vacancy($vacancy->getIdFromSlug());

        $this->vacancyService->update($existedVacancy, $request->getDto());

        return redirect()->route('vacancies.show', ['vacancy' => $existedVacancy])
            ->with('edit-success', trans('alerts.vacancy.edited'));
    }

    public function store(VacancyCreateRequest $request): RedirectResponse
    {
        $this->vacancyService->create(session('user.emp_id'), $request->getDto());

        return redirect()
            ->route('employer.vacancy.unpublished')
            ->with('vacancy-added', trans('alerts.vacancy.added'));
    }

    public function destroy(SlugVacancy $vacancy): RedirectResponse
    {
        $vacancyModel = $vacancy->createFromSlug();

        $this->authorize('delete', $vacancyModel);

        $vacancyModel->moveToTrash();

        return redirect()->route('employer.vacancy.unpublished')
            ->with('vacancy-trashed', trans('alerts.vacancy.trashed'));
    }

    public function restore(SlugVacancy $vacancy): RedirectResponse
    {
        $this->vacancyService->restore($vacancy->createFromSlug('id', 'status'));

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

        try {
            $this->vacancyService->publishVacancy($vacancyModel);
        } catch (VacancyStatusException $e) {
            return back()->with('errors-publish', $e->getMessage());
        } catch (NotEnoughInfoToContinueException $e) {
            return back()->with('errors-publish', trans('alerts.employer.empty-description'));
        }

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
