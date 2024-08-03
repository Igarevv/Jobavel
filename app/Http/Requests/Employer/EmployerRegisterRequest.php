<?php

namespace App\Http\Requests\Employer;

use App\Enums\EmployerEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class EmployerRegisterRequest extends FormRequest
{

    protected $redirect = '/employer/register';

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        if (! $this->isMethod('POST')) {
            return [];
        }

        return [
            'company' => 'required|max:256|unique:employers,company_name',
            'email' => 'required|email|unique:users,email|unique:employers,contact_email',
            'password' => ['required', 'confirmed', Password::defaults()],
            'type' => [
                'required',
                Rule::enum(EmployerEnum::class)->only([
                    EmployerEnum::COMPANY_TYPE_OUTSTAFF,
                    EmployerEnum::COMPANY_TYPE_AGENCY,
                    EmployerEnum::COMPANY_TYPE_OUTSOURCE,
                    EmployerEnum::COMPANY_TYPE_PRODUCT
                ])
            ]
        ];
    }

    public function messages(): array
    {
        return [
            'company.unique' => 'Company name ":input" has already been taken',
            'email' => 'Company with that email is already exists',
        ];
    }

}
