<?php

namespace App\Http\Requests\Admin;

use App\DTO\Admin\AdminSearchDto;
use App\Enums\Admin\AdminEmployersSearchEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Validator;

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
        if ((int)$this->get('searchBy') === AdminEmployersSearchEnum::ID->value) {
            return Str::isUuid($this->get('search'));
        }

        return true;
    }
}
