<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Contracts\Request\AfterValidationInterface;
use App\Enums\Vacancy\EmploymentEnum;
use App\Enums\Vacancy\ExperienceEnum;
use App\Rules\TechSkillsExistsRule;
use App\Traits\AfterValidation;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class VacancyFilterRequest extends FormRequest implements AfterValidationInterface
{

    use AfterValidation;

    public function rules(): array
    {
        return [
            'skills' => ['nullable', new TechSkillsExistsRule()],
            'experience' => ['nullable', Rule::in(['1', '3', '5', '10'])],
            'employment' => [
                'nullable', Rule::enum(EmploymentEnum::class)->only([
                    EmploymentEnum::EMPLOYMENT_OFFICE,
                    EmploymentEnum::EMPLOYMENT_REMOTE,
                    EmploymentEnum::EMPLOYMENT_PART_TIME,
                    EmploymentEnum::EMPLOYMENT_MIXED
                ])
            ],
            'salary' => ['nullable', 'numeric', 'min:1'],
            'location' => ['nullable', 'string']
        ];
    }

    private function mapExperienceToEnum(array &$data): void
    {
        if ($this->has('experience')) {
            $data['experience'] = ExperienceEnum::experienceToString((float) $this->experience);
        }
    }

    private function castSalaryToInt(array &$data): void
    {
        if ($this->has('salary')) {
            $data['salary'] = (int) $this->salary;
        }
    }

    public function makeCastAndMutatorsAfterValidation(array &$data): void
    {
        $this->mapExperienceToEnum($data);
        $this->castSalaryToInt($data);
    }
}