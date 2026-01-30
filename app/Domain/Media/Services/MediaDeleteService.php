<?php

declare(strict_types=1);

namespace App\Domain\Media\Services;

use App\Models\Media;
use Illuminate\Support\Facades\{
    DB,
    Auth,
    Storage
};
use App\Domain\Media\Services\DirectoryDeleteService;
use Illuminate\Http\Exceptions\HttpResponseException;

class MediaDeleteService
{   
    public function __construct(
        private DirectoryDeleteService $deleteDirectoryService
    ){}

    /**
     * The `delete` function deletes a media file and its variants after checking for authorization and
     * protection.
     * 
     * @param Media media The `delete` function you provided is responsible for deleting a media file
     * and its associated variants. Here's a breakdown of the parameters used in the function:
     */
    public function delete(Media $media): void
    {   
        if($media->is_protected) {
            throw new HttpResponseException(
                response()->json(['message' => 'Unauthorized file protected'], 403)
            );
        }
        
        if(Auth::user()->id !== $media->uploaded_by_user_id) {
            throw new HttpResponseException(
                response()->json(['message' => 'Unauthorized'], 403)
            );
        }

        DB::transaction(function() use ($media) {

            foreach($media->variants as $variant) {
                Storage::disk($media->disk)->delete($variant->path);
            }

            Storage::disk($media->disk)->delete($media->path);

            $this->deleteDirectoryService->deleteEmptyDirectory($media->disk, $media->path);

            $media->variants()->delete();
            $media->delete();
        });
    }
}