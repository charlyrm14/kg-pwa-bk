<?php

namespace App\DTOs\Media;

final class ProcessedMediaDTO
{
    public function __construct(
        public readonly string $uuid,
        public readonly string $path,
        public readonly string $mimeType,
        public readonly string $disk,
        public readonly int $uploadedByUserId,
        public readonly array $variants
    ) {}
}