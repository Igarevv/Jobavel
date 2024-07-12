<?php

declare(strict_types=1);

namespace App\Service\Storage;

use App\Contracts\Storage\LogoStorageInterface;
use App\Persistence\Models\Employer;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Cache;

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

            if ($oldImage && $oldImage !== config('app.default_employer_logo')) {
                $this->logoStorage->delete($oldImage);
            }

            Cache::forget('logo-url'.$oldImage);

            Cache::put('logo-url'.$newFileName, $this->logoStorage->get($newFileName), now()->addHour());

            return true;
        }

        return false;
    }

    public function getImageUrlByImageId(?string $imageId, ?string $default = null): false|string
    {
        $logoUrl = Cache::get('logo-url-'.$imageId);

        if ($logoUrl !== null) {
            return $logoUrl;
        }

        if ($imageId !== null) {
            $logoUrl = $this->logoStorage->get($imageId);

            if (! $logoUrl) {
                $logoUrl = $this->logoStorage->get($default ?? $this->logoByDefault());
            }
        } else {
            $logoUrl = $this->logoStorage->get($default ?? $this->logoByDefault());
        }

        Cache::put('logo-url-'.$imageId, $logoUrl, now()->addHour());

        return $logoUrl;
    }

    protected function logoByDefault()
    {
        return config('app.default_employer_logos');
    }

}