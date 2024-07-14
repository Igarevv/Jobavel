<?php

namespace App\Http\Requests;

use App\Rules\NullableDynamicFieldRule;
use App\Rules\TechSkillsExistsRule;
use Illuminate\Foundation\Http\FormRequest;

class CreateVacancyRequest extends FormRequest
{

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->can('vacancy-create');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
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
        ];

        if (array_key_exists(1, $this->offers)) {
            foreach ($this->offers as $key => $offer) {
                $rules['offers.'.$key] = 'string';
            }
        }

        return $rules;
    }

    public function validated($key = null, $default = null)
    {
        $data = parent::validated($key, $default);

        if ($this->offers[0] === null) {
            $data['offers'] = null;
        }

        return $data;
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

}
