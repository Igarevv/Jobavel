<?php

declare(strict_types=1);

namespace App\Http\Requests\Vacancy;

use App\Persistence\Models\Vacancy;
use App\Traits\AfterValidation;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class ApplyRequest extends FormRequest
{
    use AfterValidation;

    public function authorize(): bool
    {
        return $this->user()?->can('apply', Vacancy::class);
    }

    public function rules(): array
    {
        return [
            'cvType' => ['required', 'in:0,1'],
            'useCurrentEmail' => ['nullable', 'boolean'],
            'contactEmail' => [
                Rule::requiredIf(function () {
                    return $this->input('useCurrentEmail') === null;
                }),
            ],
        ];
    }

    public function prepareForValidation(): void
    {
        $employee = $this->user()?->employee;

        if ((int)$this->cvType === 0 && ($employee && ! $employee->hasMinimallyFilledPersonalInfo())) {
            throw ValidationException::withMessages([
                'cvType' => trans('alerts.employee-account.no-personal-info'),
            ]);
        }

        if ((int)$this->cvType === 1 && ($employee && ! $employee->resume_file)) {
            throw ValidationException::withMessages([
                'no-cv' => trans('alerts.employee-account.no-cv'),
            ]);
        }
    }

    public function makeCastAndMutatorsAfterValidation(array &$data): void
    {
        $data['cvType'] = (bool)$this->cvType;

        if (! isset($data['useCurrentEmail'])) {
            $data['useCurrentEmail'] = false;
        } else {
            $data['useCurrentEmail'] = (bool)$this->useCurrentEmail;
        }
    }

    public function attributes(): array
    {
        return [
            'contactEmail' => 'contact email',
        ];
    }

    public function messages(): array
    {
        return [
            'contactEmail.required_unless' => 'Contact email is required, when you do not want to use your account email as contact',
        ];
    }
}
