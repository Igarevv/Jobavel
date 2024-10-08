<?php

namespace App\Http\Requests\Employee;

use Illuminate\Foundation\Http\FormRequest;

class ShowResumeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->can('view', [$this->route('employee'), $this->user()?->employer]);
    }

    public function rules(): array
    {
        return [
            'type' => 'in:file,manual'
        ];
    }
}
