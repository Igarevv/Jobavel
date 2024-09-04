<?php

namespace App\Http\Requests\Vacancy;

use App\Persistence\Models\Vacancy;

class VacancyCreateRequest extends VacancyRequest
{
    public function authorize(): bool
    {
        return $this->user()?->can('create', Vacancy::class);
    }
}
