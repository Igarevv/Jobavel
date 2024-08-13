<?php

namespace App\Http\Requests\Employer;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\File;

class UploadLogoRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'logo' => ['required', File::image()->max(2048)]
        ];
    }
}
