<?php

declare(strict_types=1);

namespace App\Domain\Media\Strategies;

use App\Models\Media;
use Illuminate\Support\Str;
use Intervention\Image\Laravel\Facades\Image;
use App\Domain\Media\Contracts\FileStorageInterface;
use App\Domain\Media\Contracts\MediaStrategyInterface;
use App\DTOs\Media\{MediaUploadDTO, ProcessedMediaDTO};

class ImageStrategy implements MediaStrategyInterface
{
    public function __construct(
        private FileStorageInterface $storage
    ){}

    /**
     * The handle function processes a media upload by storing the original file, generating variants,
     * and returning relevant information.
     * 
     * @param MediaUploadDTO dto The `handle` function takes a `MediaUploadDTO` object as a parameter.
     * This object contains information about the media file being uploaded, such as the disk where the
     * file will be stored, the file itself, and any additional data related to the upload process.
     * 
     * @return The `handle` function returns an array with the following keys and values:
     * - 'path' : the original path where the file was stored
     * - 'mime_type' : the MIME type of the uploaded file
     * - 'disk' : the disk where the file was stored
     * - 'variants' : an array of generated variants for the uploaded file
     */
    public function handle(MediaUploadDTO $dto): ProcessedMediaDTO
    {
        $basePath = $this->storage->generateBasePath();

        $originalPath = $this->storage->putFile(
            $dto->disk,
            $basePath,
            $dto->file
        );

        $variants = $this->generateVariants($dto, $basePath);
        
        return new ProcessedMediaDTO(
            uuid: (string) Str::uuid(),
            path: $originalPath,
            mimeType: $dto->file->getMimeType(),
            disk: $dto->disk,
            uploadedByUserId: $dto->userId,
            variants: $variants
        );
    }

    /**
     * This PHP function generates image variants based on specified dimensions and saves them to
     * storage.
     * 
     * @param MediaUploadDTO dto The `generateVariants` function takes two parameters:
     * @param string basePath The `basePath` parameter in the `generateVariants` function is the base
     * path where the image variants will be stored. It is the directory path where the image variants
     * will be saved on the storage disk.
     * 
     * @return array An array of image variants is being returned. Each variant includes information
     * such as the variant name, file path, width, height, and a flag indicating if it is the main
     * variant.
     */
    public function generateVariants(MediaUploadDTO $dto, string $basePath): array
    {
        $variants = [];

        foreach(config('media.image_variants') as $name => [$width, $height]){
            
            $image = Image::read($dto->file)->cover($width, $height);

            $extension = $dto->file->extension();
            $variantPath = "{$basePath}/{$name}.{$extension}";

            $this->storage->putContent(
                $dto->disk,
                $variantPath,
                (string) $image->toJpeg()
            );

            $variants[] = [
                'variant' => $name,
                'path' => "{$basePath}/{$name}.jpg",
                'width' => $width,
                'height' => $height,
                'is_main' => $name === 'medium'
            ];
        }

        return $variants;
    }
}