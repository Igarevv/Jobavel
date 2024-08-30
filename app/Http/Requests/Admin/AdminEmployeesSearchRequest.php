<?php

namespace App\Http\Requests\Admin;

use App\DTO\Admin\AdminSearchDto;
use App\Enums\Admin\AdminEmployeesSearchEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Validator;

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

    public function withValidator(Validator $validator): void
    {
        $validator->after(function (Validator $validator) {
            if (! $this->ensureSearchByUserIdHasValidSearchable()) {
                $validator->errors()->add(
                    'search',
                    'If search performed by user id, then the search string must be a valid id'
                );
            }
        });
    }

    protected function ensureSearchByUserIdHasValidSearchable(): bool
    {
        if ((int)$this->get('searchBy') === AdminEmployeesSearchEnum::ID->value) {
            return Str::isUuid($this->get('search'));
        }

        return true;
    }
}
