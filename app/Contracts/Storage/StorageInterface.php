<?php

namespace App\Contracts\Storage;

use Illuminate\Http\UploadedFile;

interface StorageInterface
{
    public function upload(UploadedFile $file): false|string;

    public function get(string $fileId): string|false;

    public function delete(string $fileId): bool;

    public function isExists(string $fileId): bool;
}