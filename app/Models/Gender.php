<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Gender extends Model
{
    use SoftDeletes;    
    
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'slug'
    ];

    /**
     * The function userProfiles() defines a relationship where a user has many user profiles.
     * 
     * @return HasMany A relationship method named `userProfiles` is being returned, which defines a
     * one-to-many relationship between the current model and the `UserProfile` model.
     */
    public function userProfiles(): HasMany
    {
        return $this->hasMany(UserProfile::class);
    }
}
