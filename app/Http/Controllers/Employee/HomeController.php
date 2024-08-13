<?php

declare(strict_types=1);

namespace App\Http\Controllers\Employee;

use App\Actions\Employee\GetEmployeeInfoAction;
use App\Actions\Employee\GuessVacancyForEmployeeAction;
use App\Http\Controllers\Controller;
use App\Persistence\Models\TechSkill;
use Illuminate\View\View;

class HomeController extends Controller
{

    public function index(GetEmployeeInfoAction $getEmpAction, GuessVacancyForEmployeeAction $relVacanciesAction): View
    {
        $employee = $getEmpAction->handle(session('user.emp_id'));

        $relatedVacancies = $relVacanciesAction->handle($employee);

        if ($employee->skills) {
            $skillsInRaw = TechSkill::query()->whereIn('id', $employee->skills)->pluck('skill_name');

            $skillsInRaw = $skillsInRaw->implode(', ');
        }

        return view('employee.main', [
            'employee' => $employee,
            'vacancies' => $relatedVacancies,
            'skillsInRaw' => $skillsInRaw ?? null
        ]);
    }

}