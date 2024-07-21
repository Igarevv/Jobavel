<?php

declare(strict_types=1);

namespace App\Service\Employer\Storage;

use App\Contracts\Storage\LogoStorageInterface;
use App\Persistence\Models\Employer;
use App\Service\Cache\Cache;
use Illuminate\Http\UploadedFile;

class EmployerLogoService
{

    public function __construct(
        protected LogoStorageInterface $logoStorage,
        protected Cache $cache
    ) {
    }

    public function upload(UploadedFile $file, string $userId): bool
    {
        $newFileName = $file->hashName();

        $employer = Employer::findByUuid($userId);

        if (! $this->logoStorage->upload($file)) {
            return false;
        }

        $this->cache->repository()->forget('logo-url-'.$employer->company_logo);

        if ($employer->company_logo && $employer->company_logo !== $this->logoByDefault()) {
            $this->logoStorage->delete($employer->company_logo);
        }

        $employer->company_logo = $newFileName;

        $employer->save();

        $this->cache->repository()->put('logo-url-'.$newFileName, $this->logoStorage->get($newFileName),
            now()->addHour());

        return true;
    }

    public function getImageUrlByImageId(?string $imageId, ?string $default = null): false|string
    {
        $logoUrl = $this->cache->repository()->get('logo-url-'.$imageId);

        if ($logoUrl !== null) {
            return $logoUrl;
        }

        if ($imageId !== null) {
            $logoUrl = $this->logoStorage->get($imageId);

            if (! $logoUrl) {
                $logoUrl = $this->logoStorage->get($default ?: $this->logoByDefault());
            }
        } else {
            $logoUrl = $this->logoStorage->get($default ?: $this->logoByDefault());
        }

        $this->cache->repository()->put('logo-url-'.$imageId, $logoUrl, now()->addHour());

        return $logoUrl;
    }

    protected function logoByDefault()
    {
        return config('app.default_employer_logo');
    }

}