<?php

declare(strict_types=1);

namespace App\Persistence\Repositories\File\Logo;

use App\Contracts\Storage\LogoStorageInterface;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class S3FileStorage implements LogoStorageInterface
{

    private string $disk = 's3';

    public function upload(UploadedFile $file): false|string
    {
        $path = 'employer-logo/';

        return Storage::disk($this->disk)->putFile($path, $file);
    }

    public function get(string $fileId): string|false
    {
        $path = 'employer-logo/'.$fileId;

        return Storage::disk($this->disk)->url($path);
    }

    public function delete(string $fileId): bool
    {
        return Storage::disk($this->disk)->delete('employer-logo/'.$fileId);
    }

    public function isExists(string $fileId): bool
    {
        return Storage::disk($this->disk)->exists('employer-logo/'.$fileId);
    }

}