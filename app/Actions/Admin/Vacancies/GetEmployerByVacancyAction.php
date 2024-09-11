<?php

namespace App\Actions\Admin\Vacancies;

use App\Enums\EmployerEnum;
use App\Persistence\Models\Vacancy;
use App\Service\Employer\Storage\EmployerLogoService;

class GetEmployerByVacancyAction
{
    public function __construct(
        private EmployerLogoService $employerLogo
    ) {}

    public function handle(Vacancy $vacancy): object
    {
        $employer = $vacancy->load('employer')->employer;

        return (object) [
            'id' => $employer->employer_id,
            'company' => $employer->company_name,
            'contactEmail' => $employer->contact_email,
            'type' => $employer->company_type,
            'logo' => $this->employerLogo->getImageUrlForEmployer($employer),
            'createdAt' => $employer->created_at->format('Y-m-d H:i').' '.
                $employer->created_at->getTimezone(),
        ];
    }
}
