<?php

namespace App\Http\Requests\Admin\Vacancy;

use App\DTO\Admin\AdminSearchDto;
use App\Enums\Admin\AdminVacanciesSearchEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AdminVacanciesSearchRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'search' => ['nullable', 'string'],
            'searchBy' => ['required_with:search', Rule::enum(AdminVacanciesSearchEnum::class)],
        ];
    }

    public function getDto(): AdminSearchDto
    {
        return new AdminSearchDto(
            searchBy: AdminVacanciesSearchEnum::tryFrom($this->get('searchBy')),
            searchable: $this->get('search')
        );
    }
}
