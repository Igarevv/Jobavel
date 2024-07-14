<?php

declare(strict_types=1);

namespace App\Persistence\Repositories\File;

use App\Contracts\Storage\LogoStorageInterface;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class LocalFileStorage implements LogoStorageInterface
{

    public function upload(UploadedFile $file): false|string
    {
        return Storage::putFile('public/logo', $file);
    }

    public function get(string $imageId): string|false
    {
        if (! Storage::disk('public_logo')->exists($imageId)) {
            return false;
        }

        $url = Storage::disk('public_logo')->url($imageId);

        return asset($url);
    }

    public function delete(string $imageId): bool
    {
        return Storage::disk('public_logo')->delete($imageId);
    }
}