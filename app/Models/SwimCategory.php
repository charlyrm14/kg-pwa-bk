<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
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
     * The function `skills()` returns a collection of skills associated with a model instance.
     *
     * @return HasMany The `skills()` function is returning a relationship method `HasMany` which
     * defines a one-to-many relationship between the current model and the `Skill` model. This means
     * that an instance of the current model can have multiple `Skill` instances associated with it.
     */
    public function skills(): HasMany
    {
        return $this->hasMany(Skill::class);
    }

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
