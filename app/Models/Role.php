<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Role extends Model
{
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
     * The function `users()` returns a relationship where a model has many users.
     *
     * @return HasMany The code snippet is a PHP function named `users` that returns a relationship
     * definition for a "HasMany" relationship in Laravel Eloquent. It specifies that the current model
     * has a one-to-many relationship with the `User` model.
     */
    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }
}
