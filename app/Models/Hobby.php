<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Hobby extends Model
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
     * The function userHobbies() defines a relationship where a user can have multiple hobbies.
     * 
     * @return HasMany A relationship method named `userHobbies` is being returned, which defines a
     * one-to-many relationship between the current model and the `UserHobby` model.
     */
    public function userHobbies(): HasMany
    {
        return $this->hasMany(UserHobby::class);
    }
}
