<?php

namespace App\Http\Requests\Vacancy;

use App\Persistence\Models\Vacancy;

class VacancyUpdateRequest extends VacancyRequest
{
    public function authorize(): bool
    {
        return $this->user()?->can('edit', Vacancy::findOrFail(
            id: $this->route('vacancy')?->getIdFromSlug(),
            columns: ['id', 'employer_id']
        ));
    }
}
