<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin\Vacancies;

use App\Actions\Admin\Vacancies\GetPreviousRejectVacancyInfoAction as PreviousRejectAction;
use App\Actions\Admin\Vacancies\GetPreviousTrashInfoAction as PreviousTrashAction;
use App\Actions\Admin\Vacancies\GetVacanciesToModerateAction as Action;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Vacancy\AdminRejectVacancyRequest as RejectRequest;
use App\Http\Resources\Admin\AdminTable;
use App\Persistence\Models\Admin;
use App\Service\Admin\AdminActions\AdminVacancyService;
use App\Support\SlugVacancy;
use App\Support\SlugVacancy as Vacancy;
use App\Traits\Sortable\VO\SortedValues;
use App\View\ViewModels\SkillsViewModel as SKillsVM;
use App\View\ViewModels\VacancyViewModel as VacancyVM;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use InvalidArgumentException;

class ModerateVacancyController extends Controller
{
    public function index(): View
    {
        return view('admin.vacancy.moderate-list');
    }

    public function fetchVacanciesToModerate(Request $request, Action $action): AdminTable
    {
        $vacancies = $action->handle(SortedValues::fromRequest(
            fieldName: $request->get('sort'),
            direction: $request->get('direction')
        ));

        return new AdminTable($vacancies);
    }

    public function vacancyModerateView(Vacancy $vacancy, VacancyVM $vacancyVm, SKillsVM $skillsVm): View
    {
        $vacancyModel = $vacancyVm->vacancy($vacancy->getIdFromSlug(), withTrashed: true);

        $this->authorize('moderate', [Admin::class, $vacancyModel]);

        $employer = $vacancyVm->vacancyEmployerData($vacancyModel);

        $skills = $vacancyModel->techSkillsAsArrayOfBase();

        return view('admin.vacancy.moderate-view', [
            'vacancy' => $vacancyModel,
            'employer' => $employer,
            'skillSet' => $skills,
            'skillSetRow' => $skillsVm->skillsAsRow($skills),
        ]);
    }

    public function approve(SlugVacancy $vacancy, AdminVacancyService $service): RedirectResponse
    {
        $vacancyModel = $vacancy->createFromSlug('id', 'status', 'deleted_at');

        $this->authorize('moderate', [Admin::class, $vacancyModel]);

        try {
            $service->approve($vacancyModel);
        } catch (InvalidArgumentException $e) {
            return redirect()->route('admin.vacancies.moderate')->with('error-approve', $e->getMessage());
        }

        return redirect()->route('admin.vacancies.moderate')
            ->with('vacancy-approved', 'Vacancy was successfully approved');
    }

    public function reject(RejectRequest $request, AdminVacancyService $service): RedirectResponse
    {
        $dto = $request->getDto();

        $this->authorize('moderate', [Admin::class, $dto->getActionableModel()]);

        try {
            $service->reject($dto);
        } catch (InvalidArgumentException $e) {
            return redirect()->route('admin.vacancies.moderate')->with('error-reject', $e->getMessage());
        }

        return redirect()->route('admin.vacancies.moderate')
            ->with('success-reject', 'Vacancy was successfully rejected');
    }

    public function latestRejectInfo(SlugVacancy $vacancy, PreviousRejectAction $action): JsonResponse
    {
        $vacancyModel = $vacancy->createFromSlug('id', 'status', 'employer_id');

        if (auth('admin')->check()) {
            auth()->shouldUse('admin');
        }

        $this->authorize('viewActionsInfo', [Admin::class, $vacancyModel]);

        return response()->json($action->handle($vacancyModel));
    }

    public function latestTrashInfo(SlugVacancy $vacancy, PreviousTrashAction $action): JsonResponse
    {
        $vacancyModel = $vacancy->createFromSlug('id', 'status', 'employer_id');

        if (auth('admin')->check()) {
            auth()->shouldUse('admin');
        }

        $this->authorize('viewActionsInfo', [Admin::class, $vacancyModel]);

        return response()->json($action->handle($vacancyModel));
    }
}
