<?php

declare(strict_types=1);

namespace App\Http\Requests\Vacancy;

use App\Enums\Vacancy\EmploymentEnum;
use App\Exceptions\FormDefaultDataModifiedException;
use App\Rules\TechSkillsExistsRule;
use App\Traits\AfterValidation;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class VacancyFilterRequest extends FormRequest
{

    use AfterValidation;

    public function rules(): array
    {
        return [
            'skills' => ['nullable', new TechSkillsExistsRule()],
            'experience' => ['nullable', Rule::in(['0', '1', '3', '5', '10'])],
            'employment' => [
                'nullable',
                Rule::enum(EmploymentEnum::class)->only([
                    EmploymentEnum::EMPLOYMENT_OFFICE,
                    EmploymentEnum::EMPLOYMENT_REMOTE,
                    EmploymentEnum::EMPLOYMENT_PART_TIME,
                    EmploymentEnum::EMPLOYMENT_MIXED
                ])
            ],
            'salary' => ['nullable', 'numeric', 'between:0,999999'],
            'location' => ['nullable', 'string'],
            'consider' => ['nullable', 'boolean'],
            'search' => ['nullable', 'string']
        ];
    }

    protected function failedValidation(Validator $validator): void
    {
        throw new FormDefaultDataModifiedException(
            statusCode: 400,
            fallbackUrl: route('employer.vacancy.published'),
            message: $validator->errors()->first()
        );
    }

    public function makeCastAndMutatorsAfterValidation(array &$data): void
    {
        $this->mapExperienceWithConsiderInArray($data);
        $this->castSalaryToInt($data);
        $this->castSkillsIdsToInt($data);
    }

    protected function prepareForValidation(): void
    {
        if ($this->has('skills') && is_string($this->skills)) {
            $this->merge(['skills' => explode(',', $this->skills)]);
        }
    }

    private function mapExperienceWithConsiderInArray(array &$data): void
    {
        if ($this->has('experience')) {
            $data['experience'] = (int)$this->experience;
        }

        if ($this->has('consider')) {
            $data['consider'] = (bool)$this->consider;
        }

        if ($this->has('experience') && $this->has('consider')) {
            $experience = $data['experience'];

            $consider = $data['consider'];

            unset($data['experience'], $data['consider']);

            $data['experience'] = [
                'years' => $experience,
                'consider' => $consider
            ];
        }
    }

    private function castSalaryToInt(array &$data): void
    {
        if ($this->has('salary')) {
            $data['salary'] = (int)$this->salary;
        }
    }

    private function castSkillsIdsToInt(array &$data): void
    {
        if ($this->has('skills')) {
            $data['skills'] = array_map(fn($skillId) => (int)$skillId, $this->skills);
        }
    }

}