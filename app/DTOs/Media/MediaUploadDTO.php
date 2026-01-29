<?php

declare(strict_types=1);

namespace App\DTOs\Media;

use Illuminate\Http\UploadedFile;

final class MediaUploadDTO
{
    public function __construct(
        public readonly UploadedFile $file,
        public readonly string $disk,
        public readonly int $userId
    ){}

    public static function fromArray(array $files, string $disk, int $userId): array
    {
        return collect($files)
        ->map(fn (UploadedFile $file) => new self(
            file: $file,
            disk: $disk,
            userId: $userId
        ))
        ->toArray();
    }
}