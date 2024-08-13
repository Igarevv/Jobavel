<?php

declare(strict_types=1);

namespace App\Persistence\Repositories\File\Logo;

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

    public function get(string $fileId): string|false
    {
        return Storage::disk($this->disk)->url(basename($fileId));
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
