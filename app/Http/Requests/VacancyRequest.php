<?php

namespace App\Http\Requests;

use App\Contracts\Request\AfterValidationInterface;
use App\Enums\Vacancy\EmploymentEnum;
use App\Enums\Vacancy\ExperienceEnum;
use App\Rules\TechSkillsExistsRule;
use App\Traits\AfterValidation;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Arr;
use Illuminate\Validation\Rule;

class VacancyRequest extends FormRequest implements AfterValidationInterface
{

    use AfterValidation;

    public function authorize(): bool
    {
        return $this->user()->can('vacancy-create');
    }

    public function rules(): array
    {
        $rules = [
            'skillset' => ['required', new TechSkillsExistsRule()],
            'title' => ['required', 'string', 'max:255'],
            'salary' => ['numeric', 'between:0,999999'],
            'description' => ['required', 'string'],
            'location' => ['required', 'string'],
            'responsibilities.*' => ['required', 'string'],
            'requirements.*' => ['required', 'string'],
            'offers.*' => ['nullable', 'string'],
            'experience' => ['required', 'numeric'],
            'employment' => [
                'required', Rule::enum(EmploymentEnum::class)->only([
                    EmploymentEnum::EMPLOYMENT_OFFICE,
                    EmploymentEnum::EMPLOYMENT_REMOTE,
                    EmploymentEnum::EMPLOYMENT_PART_TIME,
                    EmploymentEnum::EMPLOYMENT_MIXED
                ])
            ],
            'consider' => ['nullable', 'boolean']
        ];

        if (array_key_exists(1, $this->offers)) {
            foreach ($this->offers as $key => $offer) {
                $rules['offers.'.$key] = 'string';
            }
        }

        return $rules;
    }

    public function makeCastAndMutatorsAfterValidation(array &$data): void
    {
        $this->castFirstOfferToNullIfItIsEmpty($data);
        $this->castConsiderToBool($data);
        $this->castSkillsIdsToInt($data);
        $this->mapExperienceToString($data);
    }

    public function attributes(): array
    {
        return [
            'responsibilities.*' => 'responsibility',
            'requirements.*' => 'requirement',
            'offers' => 'offer',
        ];
    }

    public function messages(): array
    {
        return [
            'offers.*' => 'This field required when other fields is provided',
        ];
    }

    private function castConsiderToBool(array &$data): void
    {
        if ($this->has('consider')) {
            $data['consider'] = (bool) $this->consider;
        }
    }

    private function castSkillsIdsToInt(array &$data): void
    {
        if ($this->has('skillset')) {
            $data['skillset'] = Arr::map($this->skillset, function ($skillId) {
                return (int) $skillId;
            });
        }
    }

    private function mapExperienceToString(array &$data): void
    {
        if ($this->has('experience')) {
            $data['experience'] = ExperienceEnum::experienceToString((float) $this->experience);
        }
    }

    private function castFirstOfferToNullIfItIsEmpty(array &$data): void
    {
        if ($this->offers[0] === null) {
            $data['offers'] = null;
        }
    }

}
