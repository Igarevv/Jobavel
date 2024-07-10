<?php

declare(strict_types=1);

namespace App\Service\Storage;

use App\Contracts\Storage\LogoStorageInterface;
use App\Persistence\Models\Employer;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\UploadedFile;

class LogoStorageService
{

    public function __construct(
        protected LogoStorageInterface $logoStorage
    ) {
    }

    public function upload(UploadedFile $file, string $userId): bool
    {
        $newFileName = $file->hashName();

        $employer = Employer::findByUuid($userId);

        if (! $employer) {
            throw new ModelNotFoundException('Try to get employer to upload file: '.$userId);
        }

        $oldImage = $employer->company_logo;

        $employer->company_logo = $newFileName;

        $result = $this->logoStorage->upload($file);

        if ($result) {
            $employer->save();

            if ($oldImage !== config('app.default_employer_logo')) {
                $this->logoStorage->delete($oldImage);
            }

            return true;
        }

        return false;
    }

    public function getImageUrlByUserId(string $userId, string $default): false|string
    {
        $employerLogoId = Employer::byUuid($userId)->value('company_logo');

        if (! $employerLogoId) {
            return $this->logoStorage->get($default);
        }

        $logoUrl = $this->logoStorage->get($employerLogoId);

        if (! $logoUrl) {
            return $this->logoStorage->get($default);
        }

        return $logoUrl;
    }

    public function getImageUrlByImageId(string $imageId, string $default): false|string
    {
        $logoUrl = $this->logoStorage->get($imageId);

        if (! $logoUrl) {
            return $this->logoStorage->get($default);
        }

        return $logoUrl;
    }

}