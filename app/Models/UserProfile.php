<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class UserProfile extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'about_me',
        'birthdate',
        'lada',
        'phone_number',
        'address',
        'user_id',
        'gender_id'
    ];

    /**
     * The user function returns the relationship between the current object and a User model.
     *
     * @return BelongsTo A BelongsTo relationship is being returned.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * The function "gender" returns a BelongsTo relationship with the Gender model in PHP.
     *
     * @return BelongsTo A BelongsTo relationship is being returned, linking the current model to the
     * Gender model.
     */
    public function gender(): BelongsTo
    {
        return $this->belongsTo(Gender::class);
    }

    /**
     * The `avatar` function returns a polymorphic relationship for the `Media` model associated with a
     * specific model.
     *
     * @return MorphOne A MorphOne relationship is being returned. This relationship allows the model
     * to have multiple image media associated with it through polymorphic relations. The avatar method
     * returns a MorphOne relationship with the Media model, specifying 'mediaable' as the morphable
     * type.
     */
    public function avatar(): MorphOne
    {
        return $this->morphOne(Media::class, 'mediaable')
            ->where('context', 'avatar')
            ->latestOfMany();
    }

    /**
     * The `file` function returns a polymorphic relationship for the `Media` model associated with a
     * specific model.
     *
     * @return MorphOne A MorphOne relationship is being returned. This relationship allows the model
     * to have multiple image media associated with it through polymorphic relations. The file method
     * returns a MorphOne relationship with the Media model, specifying 'mediaable' as the morphable
     * type.
     */
    public function media(): MorphOne
    {
        return $this->morphOne(Media::class, 'mediaable');
    }
}
