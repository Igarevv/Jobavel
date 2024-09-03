<?php

declare(strict_types=1);

namespace App\Persistence\Repositories\File\CV;

use App\Contracts\Storage\CvStorageInterface;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class LocalCvStorage implements CvStorageInterface
{

    protected string $disk = 'cv';

    public function upload(UploadedFile $file): false|string
    {
        return Storage::putFile('cv', $file);
    }

    public function get(string $fileId): string|false
    {
        return storage_path('app/cv/'.basename($fileId));
    }

    public function delete(string $fileId): bool
    {
        return Storage::disk($this->disk)->delete(basename($fileId));
    }

    public function isExists(string $fileId): bool
    {
        return Storage::disk($this->disk)->exists(basename($fileId));
    }

}
