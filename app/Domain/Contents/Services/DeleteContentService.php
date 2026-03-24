<?php

declare(strict_types=1);

namespace App\Domain\Contents\Services;

use App\Models\Content;
use App\Domain\Media\Services\MediaDeleteService;

class DeleteContentService
{
    public function __construct(
        private MediaDeleteService $deleteMedia
    ){}

    /**
     * This PHP function deletes a content item along with its associated media, if any.
     *
     * @param Content content The `delete` function takes a `Content` object as a parameter. It first
     * checks if the `Content` object has associated media. If it does, it calls the `delete` method on
     * the `deleteMedia` object passing the media object to delete it. Finally, it calls the `
     */
    public function delete(Content $content): void
    {
        if($content->media) {
            $this->deleteMedia->delete($content->media);
        }

        $content->forceDelete();
    }
}
