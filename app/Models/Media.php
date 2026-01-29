<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Relations\HasMany;

class Media extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'uuid',
        'path',
        'mime_type',
        'disk',
        'is_protected',
        'mediaable_type',
        'mediaable_id',
        'uploaded_by_user_id'
    ];

    /**
     * The function `variants()` returns a collection of MediaVariant models associated with the
     * current model.
     * 
     * @return HasMany The `variants()` function is returning a relationship definition for a "HasMany"
     * relationship with the `MediaVariant` model.
     */
    public function variants(): HasMany
    {
        return $this->hasMany(MediaVariant::class);
    }
}
