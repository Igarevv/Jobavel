<?php

declare(strict_types=1);

namespace App\Persistence\Repositories\File\CV;

use App\Contracts\Storage\CvStorageInterface;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class S3CvStorage implements CvStorageInterface
{

    protected string $disk = 's3';

    public function upload(UploadedFile $file): false|string
    {
        $path = 'employee-cvs/';

        return Storage::disk($this->disk)->putFile($path, $file);
    }

    public function get(string $fileId): string|false
    {
        $path = 'employee-cvs/'.$fileId;

        return Storage::disk($this->disk)->temporaryUrl($path, now()->addMinutes(5));
    }

    public function delete(string $fileId): bool
    {
        return Storage::disk($this->disk)->delete('employee-cvs/'.$fileId);
    }

    public function isExists(string $fileId): bool
    {
        return Storage::disk($this->disk)->exists('employee-cvs/'.$fileId);
    }
}