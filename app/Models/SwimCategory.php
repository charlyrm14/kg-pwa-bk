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
        'description',
        'level_order',
        'swim_program_id',
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
    // public function categorySkills(): HasMany
    // {
    //     return $this->hasMany(SwimCategorySkill::class);
    // }

    /**
     * The function `nextSwimCategory` retrieves the next swim category based on the provided category
     * ID.
     * 
     * @param int categoryId The `nextSwimCategory` function takes an integer parameter ``,
     * which represents the ID of a swim category. The function retrieves the next swim category with
     * an ID greater than the provided `` from the database and returns it. If there is no
     * next swim category, it returns `null
     * 
     * @return ? SwimCategory The `nextSwimCategory` function is returning the next `SwimCategory`
     * after the one with the provided ``. It queries the database for a `SwimCategory` with
     * an `id` greater than the provided ``, orders the results by `id` in ascending order,
     * and returns the first result found.
     */
    public static function nextSwimCategory(int $categoryId): ? SwimCategory
    {
        return static::where('id', '>', $categoryId)
            ->orderBy('id', 'asc')
            ->first();
    }
}
