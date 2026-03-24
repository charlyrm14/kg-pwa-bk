<?php

declare(strict_types=1);

namespace App\Domain\Contents\Services;

use App\Domain\Media\Services\MediaDeleteService;
use App\Models\Content;
use App\Http\Requests\Content\UpdateContentRequest;

class UpdateContentService
{
    public function __construct(
        private MediaDeleteService $deleteMedia
    ){}

    /**
     * The update function updates content and associated event details while deleting current media
     * files.
     *
     * @param UpdateContentRequest request  is an instance of UpdateContentRequest, which is a
     * request object containing the data needed to update content.
     * @param Content content The `update` function you provided takes an `UpdateContentRequest` object
     * as the first parameter and a `Content` object as the second parameter. The function updates the
     * content based on the request data, excluding the 'location', 'start_date', and 'end_date'
     * fields. If the content
     *
     * @return Content The `update` method is returning the updated `Content` object after making
     * changes to its attributes and related event, if applicable.
     */
    public function update(UpdateContentRequest $request, Content $content): Content
    {
        $content->update($request->safe()->except(['location', 'start_date', 'end_date']));

        if($content->event){
            $content->event->update($request->safe()->only(['location', 'start_date', 'end_date']));
        }

        $this->deleteCurrentMediaFiles($request, $content);

        return $content;
    }

    /**
     * This PHP function deletes the current media files associated with a content if a new cover image
     * is uploaded.
     *
     * @param UpdateContentRequest request  is an instance of UpdateContentRequest, which is a
     * request object containing data for updating content.
     * @param Content content The `content` parameter in the `deleteCurrentMediaFiles` function is an
     * instance of the `Content` model. It seems to represent some content data in your application.
     * The function checks if the `content` has associated media files and if a new cover image is
     * being set in the request.
     *
     * @return void If any of the conditions in the `deleteCurrentMediaFiles` function are met, the
     * function will return early and not proceed with deleting the media file. The conditions are:
     * 1. If the `` object does not have any associated media files.
     * 2. If the validated request does not contain a `cover_image` key.
     * 3. If the first element of the `cover_image` array
     */
    public function deleteCurrentMediaFiles(UpdateContentRequest $request, Content $content): void
    {
        if(!$content->media) {
            return;
        }

        if(!$request->validated()['cover_image']) {
            return;
        }

        if($request->validated()['cover_image'][0] === $content->media->id) {
            return;
        }

        $this->deleteMedia->delete($content->media);
    }
}