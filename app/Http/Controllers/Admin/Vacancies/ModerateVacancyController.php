<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin\Vacancies;

use App\Actions\Admin\Vacancies\GetVacanciesToModerateAction as Action;
use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\AdminTable;
use App\Persistence\Models\Admin;
use App\Support\SlugVacancy as Vacancy;
use App\Traits\Sortable\VO\SortedValues;
use App\View\ViewModels\SkillsViewModel as SKillsVM;
use App\View\ViewModels\VacancyViewModel as VacancyVM;
use Illuminate\Http\Request;
use Illuminate\View\View;

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
        $vacancyModel = $vacancyVm->vacancy($vacancy->getIdFromSlug());

        $this->authorize('viewModerate', [Admin::class, $vacancyModel]);

        $employer = $vacancyVm->vacancyEmployerData($vacancyModel);

        $skills = $vacancyModel->techSkillsAsArrayOfBase();

        return view('employer.vacancy.show', [
            'vacancy' => $vacancyModel,
            'employer' => $employer,
            'skillSet' => $skills,
            'skillSetRow' => $skillsVm->skillsAsRow($skills)
        ]);
    }
}
