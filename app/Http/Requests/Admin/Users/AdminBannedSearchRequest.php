<?php

namespace App\Http\Requests\Admin\Users;

use App\DTO\Admin\AdminSearchDto;
use App\Enums\Admin\AdminBannedSearchEnum;
use App\Enums\Admin\AdminEmployersSearchEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Validator;

class AdminBannedSearchRequest extends FormRequest
{

    public function rules(): array
    {
        return [
            'searchBy' => [
                'required_with:search',
                Rule::enum(AdminBannedSearchEnum::class),
            ],
            'search' => ['nullable', 'string'],
        ];
    }

    public function getDto(): AdminSearchDto
    {
        return new AdminSearchDto(
            searchBy: AdminBannedSearchEnum::tryFrom($this->get('searchBy')),
            searchable: $this->get('search')
        );
    }

    public function withValidator(Validator $validator): void
    {
        $validator->after(function (Validator $validator) {
            if ($this->get('searchBy') !== null && (int)($this->get(
                        'searchBy'
                    ) === AdminEmployersSearchEnum::ID->value) && ! Str::isUuid(
                    $this->get('search')
                )) {
                $validator->errors()->add(
                    'search',
                    'If search is performed by user ID, the search string must be a valid UUID.'
                );
            }
        });
    }

}
