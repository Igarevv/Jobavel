<?php

declare(strict_types=1);

namespace App\Persistence\Repositories\File;

use App\Contracts\Storage\LogoStorageInterface;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class LocalFileStorage implements LogoStorageInterface
{

    private string $disk = 'public_logo';

    public function upload(UploadedFile $file): false|string
    {
        return Storage::putFile('public/logo', $file);
    }

    public function get(string $imageId): string|false
    {
        return Storage::disk($this->disk)->url(basename($imageId));
    }

    public function delete(string $imageId): bool
    {
        return Storage::disk($this->disk)->delete(basename($imageId));
    }

    public function isExists(string $imageId): bool
    {
        return Storage::disk($this->disk)->exists(basename($imageId));
    }

}
