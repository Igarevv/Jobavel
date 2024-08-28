<?php

namespace App\Http\Requests\Admin;

use App\DTO\Admin\AdminSearchDto;
use App\Enums\Admin\AdminEmployersSearchEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AdminEmployersSearchRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'searchBy' => ['required', Rule::enum(AdminEmployersSearchEnum::class)],
            'search' => ['nullable', 'string']
        ];
    }

    public function getDto(): AdminSearchDto
    {
        return new AdminSearchDto(
            searchBy: AdminEmployersSearchEnum::tryFrom($this->get('searchBy')),
            searchable: $this->get('search')
        );
    }
}
