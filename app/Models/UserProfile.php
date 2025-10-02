<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserProfile extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'birthdate',
        'lada',
        'phone',
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
}
