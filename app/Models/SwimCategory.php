<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class SwimCategory extends Model
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
        'description'
    ];

    /**
     * The function `categorySkills` returns a collection of `SwimCategorySkill` models associated with
     * the current model.
     * 
     * @return HasMany The code snippet is a PHP function named `categorySkills` that returns a
     * relationship definition for a one-to-many relationship in Laravel's Eloquent ORM. It returns a
     * `HasMany` relationship, indicating that the current model has multiple `SwimCategorySkill`
     * models associated with it.
     */
    public function categorySkills(): HasMany
    {
        return $this->hasMany(SwimCategorySkill::class);
    }
}
