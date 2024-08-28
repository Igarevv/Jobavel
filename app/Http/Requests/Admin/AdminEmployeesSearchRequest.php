<?php

namespace App\Http\Requests\Admin;

use App\DTO\Admin\AdminSearchDto;
use App\Enums\Admin\AdminEmployeesSearchEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AdminEmployeesSearchRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'searchBy' => ['required', Rule::enum(AdminEmployeesSearchEnum::class)],
            'search' => ['nullable', 'string']
        ];
    }

    public function getDto(): AdminSearchDto
    {
        return new AdminSearchDto(
            searchBy: AdminEmployeesSearchEnum::tryFrom($this->get('searchBy')),
            searchable: $this->get('search')
        );
    }
}
