<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class ContentType extends Model
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
     * The function `contents()` returns a relationship where a model has many contents.
     * 
     * @return HasMany The code snippet is a PHP function named `contents` that returns a relationship
     * definition for a "HasMany" relationship in Laravel Eloquent. It specifies that the current model
     * has a one-to-many relationship with the `Content` model.
     */
    public function contents(): HasMany
    {
        return $this->hasMany(Content::class, 'id', 'content_type_id');
    }
}
