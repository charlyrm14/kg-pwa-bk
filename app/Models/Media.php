<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

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
        'context',
        'uploaded_by_user_id'
    ];

    /**
     * The function `mediaable()` returns a polymorphic relationship for the model.
     *
     * @return MorphTo The `mediaable()` function is returning a MorphTo relationship. This function is
     * typically used in Laravel Eloquent models to define a polymorphic relationship, allowing the
     * model to belong to multiple other models.
     */
    public function mediaable(): MorphTo
    {
        return $this->morphTo();
    }

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

    /**
     * The variantThumbnail function returns a single MediaVariant instance where the variant is
     * 'thumbnail'.
     * 
     * @return HasOne A relationship method `variantThumbnail()` is being returned, which defines a
     * one-to-one relationship with the `MediaVariant` model where the `variant` column is equal to
     * 'thumbnail'.
     */
    public function variantThumbnail(): HasOne
    {
        return $this->hasOne(MediaVariant::class)->where('variant', 'thumbnail');
    }
}
