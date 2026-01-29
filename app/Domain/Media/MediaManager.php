<?php

declare(strict_types=1);

namespace App\Domain\Media;

use App\Models\Media;
use App\DTOs\Media\MediaUploadDTO;
use App\Domain\Media\StrategyResolver;
use App\Domain\Media\Repository\MediaRepository;

class MediaManager
{
    public function __construct(
        private StrategyResolver $resolver,
        private MediaRepository $repository
    ){}

    /**
     * The `upload` function takes an array of file data transfer objects, uploads each file
     * individually, and returns an array of results.
     * 
     * @param array fileDTOs The `upload` function takes an array of file Data Transfer Objects (DTOs)
     * as input. The function then iterates over each DTO in the array and calls the `uploadSingle`
     * method for each DTO. Finally, it returns an array containing the results of uploading each file
     * DTO.
     * 
     * @return array An array of results from uploading each file DTO in the input array.
     */
    public function upload(array $fileDTOs)
    {
        return collect($fileDTOs)->map(fn ($dto) => $this->uploadSingle($dto));
    }

    /**
     * The function `uploadSingle` takes a `MediaUploadDTO` object, resolves the upload strategy based
     * on the file MIME type, processes the upload using the strategy, and then creates a new `Media`
     * object in the repository.
     * 
     * @param MediaUploadDTO dto The `dto` parameter in the `uploadSingle` function is an instance of
     * the `MediaUploadDTO` class. It contains information about the media file being uploaded, such as
     * the file itself and any additional metadata associated with it.
     * 
     * @return Media The `uploadSingle` function is returning an instance of the `Media` class after
     * processing the uploaded media file using a strategy based on the file's MIME type and then
     * creating a new `Media` entity in the repository with the processed data.
     */
    protected function uploadSingle(MediaUploadDTO $dto): Media
    {
        $strategy = $this->resolver->resolve($dto->file->getMimeType());
        $processed = $strategy->handle($dto);
        
        return $this->repository->create($processed);
    }
}