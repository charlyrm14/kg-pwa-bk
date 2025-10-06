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
}
