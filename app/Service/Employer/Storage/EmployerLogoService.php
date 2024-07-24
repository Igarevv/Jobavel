<?php

declare(strict_types=1);

namespace App\Service\Employer\Storage;

use App\Contracts\Storage\LogoStorageInterface;
use App\Jobs\CheckEmployerLogoExisting;
use App\Persistence\Models\Employer;
use App\Persistence\Repositories\User\EmployerAccountRepository;
use App\Service\Cache\Cache;
use Illuminate\Http\UploadedFile;

class EmployerLogoService
{

    public function __construct(
        protected LogoStorageInterface $logoStorage,
        protected Cache $cache,
        protected EmployerAccountRepository $employerAccountRepository
    ) {
    }

    public function upload(UploadedFile $file, string $userId): bool
    {
        $newFileName = $file->hashName();

        $employer = $this->employerAccountRepository->getById($userId, ['id', 'company_logo']);

        if (! $this->logoStorage->upload($file)) {
            return false;
        }

        if ($employer->company_logo && $employer->company_logo !== $this->logoByDefault()) {
            $this->logoStorage->delete($employer->company_logo);
        }

        $this->employerAccountRepository->update($employer, ['logo' => $newFileName]);

        return true;
    }

    public function getImageUrlByImageId(string $employerId, string $imageId): string
    {
        $logoUrl = $this->logoStorage->get($imageId);

        $employer = $this->employerAccountRepository->getById($employerId, ['id']);

        CheckEmployerLogoExisting::dispatchAfterResponse(
            $this->logoStorage, $employer
        );

        return $logoUrl;
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