<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Persistence\Models\Employer;
use App\Service\Employer\Storage\EmployerLogoService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\File;

class FileController extends Controller
{
    public function __construct(
        protected EmployerLogoService $logoStorageService
    ) {
    }

    public function uploadLogo(Request $request): RedirectResponse
    {
        Validator::make($request->all(), [
            'logo' => ['required', File::image()->max(2048)]
        ])->validate();

        $file = $request->file('logo');

        $employer = Employer::findByUuid(session('user.emp_id'));

        if ($this->logoStorageService->upload($file, $employer)) {
            return back()->with('logo-success', 'Your company logo updated successfully');
        }

        return back()->with('logo-error', 'Something went wrong');
    }
}