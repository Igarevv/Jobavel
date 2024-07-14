<?php

namespace App\Contracts\Storage;

use Illuminate\Http\UploadedFile;

interface LogoStorageInterface
{

    public function upload(UploadedFile $file): false|string;

    public function get(string $imageId): string|false;

    public function delete(string $imageId): bool;

}