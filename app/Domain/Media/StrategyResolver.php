<?php

declare(strict_types=1);

namespace App\Domain\Media;


use Illuminate\Support\Str;
use RuntimeException;
use App\Domain\Media\Strategies\ImageStrategy;
use App\Domain\Media\Contracts\MediaStrategyInterface;
use App\DTOs\Media\{MediaUploadDTO, ProcessedMediaDTO};

class StrategyResolver
{
    /**
     * The function resolves a media strategy based on the provided MIME type, returning an
     * ImageStrategy if the MIME type starts with 'image/'.
     * 
     * @param string mimeType The `mimeType` parameter in the `resolve` function is a string that
     * represents the type of media file. It is used to determine the appropriate strategy for handling
     * that specific type of media.
     * 
     * @return ProcessedMediaDTO The `ImageStrategy` class is being returned.
     */
    public function resolve(string $mimeType)
    {
        if (Str::startsWith($mimeType, 'image/')) {
            return app(ImageStrategy::class);
        }
        
        throw new RuntimeException("Unsupported media type: {$mimeType}");
    }
}