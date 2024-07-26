<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\View\ViewModels\SkillsViewModel;
use App\View\ViewModels\VacancyViewModel;
use Illuminate\View\View;

class VacancyController extends Controller
{

    public function __construct(
        protected SkillsViewModel $skillsViewModel
    ) {
    }

    public function show(int $vacancy, VacancyViewModel $vacancyViewModel): View
    {
        $vacancyModel = $vacancyViewModel->vacancy($vacancy);

        $this->authorize('viewAny', $vacancyModel);

        $employer = $vacancyViewModel->vacancyEmployerData($vacancyModel);

        $skills = $vacancyModel->techSkillsAsArrayOfBase();

        return view('employer.vacancy.show', [
            'vacancy' => $vacancyModel,
            'employer' => $employer,
            'skillSet' => $skills,
            'skillSetRow' => $this->skillsViewModel->skillsAsRow($skills)
        ]);
    }

}