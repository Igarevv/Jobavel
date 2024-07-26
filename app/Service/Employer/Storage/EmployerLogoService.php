<?php

declare(strict_types=1);

namespace App\Service\Employer\Storage;

use App\Contracts\Storage\LogoStorageInterface;
use App\Jobs\CheckEmployerLogoExisting;
use App\Persistence\Models\Employer;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\UploadedFile;

class EmployerLogoService
{

    public function __construct(
        protected LogoStorageInterface $logoStorage,
    ) {
    }

    public function upload(UploadedFile $file, Employer $employer): bool
    {
        if (! $this->logoStorage->upload($file)) {
            return false;
        }

        if ($employer->company_logo && $employer->company_logo !== $this->logoByDefault()) {
            $this->logoStorage->delete($employer->company_logo);
        }

        $employer->update(['company_logo' => $file->hashName()]);

        return true;
    }

    public function fetchEmployerLogoInArray(Collection $employers): array
    {
        return $employers->map(function (Employer $employer) {
            return (object) [
                'url' => $this->getImageUrlByEmployer($employer)
            ];
        })->toArray();
    }

    public function getImageUrlByEmployer(Employer $employer): string
    {
        $logoUrl = $this->logoStorage->get($employer->company_logo);

        CheckEmployerLogoExisting::dispatchAfterResponse(
            $this->logoStorage, $employer
        );

        return $logoUrl;
    }

    protected function logoByDefault()
    {
        return config('app.default_employer_logo');
    }

}