<?php

declare(strict_types=1);

namespace App\Http\Requests\Employee;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\File;

class UploadCvRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'cv' => ['required', File::types(['pdf', 'docx'])->max(4096)]
        ];
    }
}