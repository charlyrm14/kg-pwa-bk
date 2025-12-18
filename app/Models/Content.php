<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Content extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'slug',
        'content',
        'content_type_id',
        'content_status_id',
        'author_id',
        'published_at'
    ];

    /**
     * The function "type" returns a BelongsTo relationship with the Content Type model in PHP.
     * 
     * @return BelongsTo A BelongsTo relationship is being returned, linking the current model to the Content Type
     */
    public function type(): BelongsTo
    {
        return $this->belongsTo(ContentType::class, 'content_type_id', 'id');
    }

    /**
     * The function "status" returns a BelongsTo relationship with the Content Status model in PHP.
     * 
     * @return BelongsTo A BelongsTo relationship is being returned, linking the current model to the Content Status
     */
    public function status(): BelongsTo
    {
        return $this->belongsTo(ContentStatus::class, 'content_status_id', 'id');
    }

    /**
     * The function "user" returns a BelongsTo relationship with the User model in PHP.
     * 
     * @return BelongsTo A BelongsTo relationship is being returned, linking the current model to the User
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id', 'id');
    }

    /**
     * The function "event" returns a HasOne relationship with the Event model in PHP.
     * 
     * @return HasOne A HasOne relationship is being returned, linking the current model to the Event
     */
    public function event(): HasOne
    {
        return $this->hasOne(Event::class);
    }

    /**
     * This PHP function retrieves the latest published content of a specific type.
     * 
     * @param int contentTypeId The `contentTypeId` parameter in the `getLatestContentPublished`
     * function is used to specify the type of content for which you want to retrieve the latest
     * published content. In the provided code snippet, the default value for `contentTypeId` is set to
     * `2` that means a content type event, but you can pass a different
     * 
     * @return ?Content The `getLatestContentPublished` function is returning the latest published
     * content of a specific content type with the content status ID of 5 that means that the content is PUBLISHED. 
     * It retrieves the content along with its related event and status information. 
     * The return type is a nullable `Content` object, indicating that it may return a `Content` object 
     * or `null` if no matching content is found.
     */
    public static function getLatestContentPublished(int $contentTypeId = 2): ?Content
    {
        return static::with(['event', 'status'])->where([
            ['content_type_id', $contentTypeId],
            ['content_status_id', 5]
        ])->orderByDesc('id')->first();
    }
}
