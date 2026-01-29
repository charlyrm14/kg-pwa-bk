<?php

declare(strict_types=1);

namespace App\Domain\Media\Contracts;

use Illuminate\Http\UploadedFile;

interface FileStorageInterface
{
    public function generateBasePath(): string;

    public function putFile(string $disk, string $path, UploadedFile $file): string;

    public function putContent(string $disk, string $path, string $content): void;
}