<?php

namespace App\Http\Requests;

use App\Rules\TechSkillsExistsRule;
use Illuminate\Foundation\Http\FormRequest;

class CreateVacancyRequest extends FormRequest
{

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'skillset' => ['required', new TechSkillsExistsRule()],
            'jobTitle' => ['required', 'string', 'max:255'],
            'salary' => ['numeric', 'between:1,999999'],
            'description' => ['required', 'string'],
            'responsibilities.*' => ['required', 'string'],
            'requirements.*' => ['required', 'string'],
        ];
    }

}
