<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MediaVariant extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'path',
        'variant',
        'is_main',
        'width',
        'height',
        'media_id'
    ];

    /**
     * The function `media()` returns a BelongsTo relationship with the Media model in PHP.
     * 
     * @return BelongsTo A BelongsTo relationship is being returned for the Media model.
     */
    public function media(): BelongsTo
    {
        return $this->belongsTo(Media::class);
    }
}
