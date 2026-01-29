<?php

declare(strict_types=1);

namespace App\Domain\Media\Repository;

use App\Models\Media;
use App\DTOs\Media\ProcessedMediaDTO;

class MediaRepository
{
    /**
     * The function creates a new Media object with the provided data and its variants.
     * 
     * @param ProcessedMediaDTO dto The `create` function takes a `ProcessedMediaDTO` object as a
     * parameter. This object contains the following properties:
     * 
     * @return Media The `create` method is returning an instance of the `Media` model after creating a
     * new record in the database based on the data provided in the `ProcessedMediaDTO` object.
     */
    public function create(ProcessedMediaDTO $dto): Media
    {
        $media = Media::create([
            'uuid' => $dto->uuid,
            'path' => $dto->path,
            'mime_type' => $dto->mimeType,
            'disk' => $dto->disk,
            'uploaded_by_user_id' => $dto->uploadedByUserId
        ]);

        foreach ($dto->variants as $variant) {
            $media->variants()->create($variant);
        }

        return $media->load('variants');
    }
}