<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class AdminTechSkillRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'skill' => ['required', 'string', 'unique:tech_skills,skill_name']
        ];
    }
}
