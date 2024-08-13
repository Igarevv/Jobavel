<?php

declare(strict_types=1);

namespace App\Http\Controllers\Employer;

use App\Http\Controllers\Controller;
use App\Http\Requests\Employer\UploadLogoRequest;
use App\Persistence\Models\Employer;
use App\Service\Employer\Storage\EmployerLogoService;
use Illuminate\Http\RedirectResponse;

class LogoController extends Controller
{
    public function __construct(
        protected EmployerLogoService $logoStorageService
    ) {
    }

    public function uploadLogo(UploadLogoRequest $request): RedirectResponse
    {
        $employer = Employer::findByUuid(session('user.emp_id'));

        if ($this->logoStorageService->upload($request->file('logo'), $employer)) {
            return back()->with('logo-success', 'Your company logo updated successfully');
        }

        return back()->with('logo-error', 'Something went wrong');
    }
}