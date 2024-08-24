<?php

namespace App\Http\Requests\Employee;

use App\DTO\Employee\EmployeePersonalInfoDto;
use App\Rules\TechSkillsExistsRule;
use App\Traits\AfterValidation;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Arr;

class EmployeePersonalInfo extends FormRequest
{

    use AfterValidation;

    public function rules(): array
    {
        return [
            'last-name' => ['required', 'string', 'max:100'],
            'first-name' => ['required', 'string', 'max:100'],
            'position' => ['required', 'string', 'max:255'],
            'salary' => ['nullable', 'numeric', 'between:0,999999'],
            'about-employee' => ['required', 'string', 'max:1000'],
            'experiences' => ['nullable', 'array'],
            'experiences.*' => ['required', 'array'],
            'experiences.*.position' => ['required', 'string', 'max:255'],
            'experiences.*.company' => ['required', 'string', 'max:100'],
            'experiences.*.from' => ['required', 'date'],
            'experiences.*.to' => ['required', 'date', 'after:experiences.*.from'],
            'experiences.*.description' => ['nullable', 'array'],
            'experiences.*.description.*' => ['required', 'string'],
            'skills' => ['nullable', new TechSkillsExistsRule()],
        ];
    }


    public function attributes(): array
    {
        return [
            'last-name' => 'last name',
            'first name' => 'first name',
            'experiences.*' => 'experience item',
            'experiences.*.position' => 'previous position',
            'experiences.*.company' => 'previous company',
            'experiences.*.from' => 'start date',
            'experiences.*.to' => 'end date',
            'experiences.*.description' => 'description',
            'experiences.*.description.*' => 'description',
        ];
    }

    public function makeCastAndMutatorsAfterValidation(array &$data): void
    {
        $this->castSalaryToInt($data);
        $this->overrideDescriptionArrayKeys($data);
        $this->makeExperienceDefaultValue($data);
        $this->castSkillsIdsToInt($data);
        $this->setSkillsAsNullIfNotExists($data);
    }

    public function getDto(): EmployeePersonalInfoDto
    {
        return new EmployeePersonalInfoDto(
            firstName: $this->get('first-name'),
            lastName: $this->get('last-name'),
            currentPosition: $this->get('position'),
            aboutEmployee: $this->get('about-employee'),
            experiences: $this->get('experiences'),
            skills: $this->get('skills'),
            preferredSalary: $this->get('salary')
        );
    }

    private function castSalaryToInt(array &$data): void
    {
        if ($this->has('salary')) {
            $data['salary'] = (int)$this->salary;
        }
    }

    private function overrideDescriptionArrayKeys(array &$data): void
    {
        if ($this->has('experiences')) {
            $data['experiences'] = array_combine(
                range(0, count($this->experiences) - 1),
                array_values($this->experiences)
            );
        }
    }

    private function makeExperienceDefaultValue(array &$data): void
    {
        if (! $this->has('experiences') || ! is_array($this->experiences)) {
            $data['experiences'] = null;
        }
    }

    private function castSkillsIdsToInt(array &$data): void
    {
        if ($this->has('skills')) {
            $data['skills'] = Arr::map($this->skills, function ($skillId) {
                return (int)$skillId;
            });
        }
    }

    private function setSkillsAsNullIfNotExists(array &$data): void
    {
        if (! $this->has('skills') || ! is_array($this->skills)) {
            $data['skills'] = null;
        }
    }

}
