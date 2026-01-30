<?php

declare(strict_types=1);

namespace App\Domain\Media\Services;

use App\Models\Media;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Exceptions\HttpResponseException;

class MediaAttachService
{
    /**
     * Attach existing media records to a given model using a polymorphic relation.
     *
     * This method assigns one or more Media records to the provided model by
     * setting their mediaable_id and mediaable_type values.
     *
     * Validations performed:
     * - The model must define a media() morph relation.
     * - Media must not be protected.
     * - Media must belong to the authenticated user.
     * - Media must not be already attached.
     *
     * All operations are executed inside a database transaction.
     *
     * @param Model $model     Target model to which media will be attached.
     * @param array $mediaIds Array of Media record IDs.
     * @param string|null $context Optional context to set on each Media record.
     *
     * @return void
     *
     * @throws HttpResponseException When:
     *  - Model does not define media() relation.
     *  - Media is protected.
     *  - Media does not belong to authenticated user.
     */
    public function attach(Model $model, array $mediaIds, ?string $context = null)
    {
        if(empty($mediaIds)){
            return null;
        };

        if (!method_exists($model, 'media')) {
            throw new HttpResponseException(
                response()->json(['message' => "Model must define a media() morph relation."], 422)
            );
        }
        
        DB::transaction(function () use ($model, $mediaIds, $context) {

            $mediaItems = Media::whereIn('id', $mediaIds)->get();

            foreach($mediaItems as $media) {
                
                if($media->is_protected) {
                    throw new HttpResponseException(
                        response()->json(['message' => 'Unauthorized file protected'], 403)
                    );
                }
    
                if(Auth::user()->id !== $media->uploaded_by_user_id) {
                    throw new HttpResponseException(
                        response()->json(['message' => 'Unauthorized, file not belongs to user'], 403)
                    );
                }

                $media->context = $context;
                $model->media()->save($media);  
            }
        });
    }
}