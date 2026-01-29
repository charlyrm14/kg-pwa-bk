<?php

declare(strict_types=1);

namespace App\Domain\Media\Contracts;

use App\Models\Media;
use App\DTOs\Media\{MediaUploadDTO, ProcessedMediaDTO};

interface MediaStrategyInterface
{
    public function handle(MediaUploadDTO $dto): ProcessedMediaDTO;
}