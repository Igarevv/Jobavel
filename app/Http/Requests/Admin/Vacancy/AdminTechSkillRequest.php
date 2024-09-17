<?php

namespace App\Http\Requests\Admin\Vacancy;

use App\Persistence\Models\TechSkill;
use Illuminate\Foundation\Http\FormRequest;

class AdminTechSkillRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user('admin')?->can('manage', TechSkill::class) !== null;
    }

    public function rules(): array
    {
        return [
            'skill' => ['required', 'string', 'unique:tech_skills,skill_name'],
        ];
    }
}
