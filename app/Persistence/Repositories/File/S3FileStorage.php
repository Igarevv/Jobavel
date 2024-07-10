<?php

declare(strict_types=1);

namespace App\Persistence\Repositories\File;

use App\Contracts\Storage\LogoStorageInterface;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class S3FileStorage implements LogoStorageInterface
{

    private string $disk = 's3_logo';

    public function upload(UploadedFile $file): bool|string
    {
        $path = 'employer-logo/'.$file->hashName();

        return Storage::disk($this->disk)->put($path, $file);
    }

    public function get(string $imageId): string|false
    {
        $path = 'employer-logo/'.$imageId;

        if (! Storage::disk($this->disk)->exists($path)) {
            return false;
        }

        return Storage::disk($this->disk)->url($path);
    }

    public function delete(string $imageId): bool
    {
        // TODO: Implement delete() method.
    }
}