<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class StudentProgress extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'user_id',
        'swim_category_id',
        'progress_status_id',
        'progress_percentage',
        'start_date',
        'end_date'
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
     * The user function returns the relationship between the current object and a SwimCategory model.
     * 
     * @return BelongsTo A BelongsTo relationship is being returned.
     */
    public function swimCategory(): BelongsTo
    {
        return $this->belongsTo(SwimCategory::class);
    }

    /**
     * The user function returns the relationship between the current object and a ProgressStatus model.
     * 
     * @return BelongsTo A BelongsTo relationship is being returned.
     */
    public function progressStatus(): BelongsTo
    {
        return $this->belongsTo(ProgressStatus::class);
    }

    /**
     * The function `getProgressByCategory` retrieves progress data based on a user ID and category ID.
     * 
     * @param int userId The `userId` parameter is an integer representing the unique identifier of a
     * user in the system.
     * @param int categoryId The `categoryId` parameter in the `getProgressByCategory` function
     * represents the ID of the swim category for which you want to retrieve progress data. This
     * parameter is used to filter the progress data based on the specified swim category.
     * 
     * @return ?Collection The `getProgressByCategory` function is returning a collection of progress
     * records that match the provided user ID and swim category ID. The function uses the `where`
     * method to filter the records based on the user ID and swim category ID, and then retrieves the
     * filtered records using the `get` method.
     */
    public static function getProgressByCategory(int $userId, int $categoryId): ?Collection
    {
        return static::where([
            ['user_id', $userId],
            ['swim_category_id', $categoryId]
        ]) ->get();
    }

    /**
     * The function `getCurrentTotalProgress` retrieves the total progress percentage for a specific
     * user and swim category.
     * 
     * @param int userId The `userId` parameter is an integer representing the user ID for which you
     * want to retrieve the total progress.
     * @param int categoryId The `categoryId` parameter in the `getCurrentTotalProgress` function
     * represents the ID of the swim category for which you want to retrieve the total progress
     * percentage for a specific user.
     * 
     * @return ?int The `getCurrentTotalProgress` function is returning the total sum of the
     * `progress_percentage` column for records where the `user_id` matches the provided `` and
     * the `swim_category_id` matches the provided ``. The return type is nullable integer
     * (`?int`).
     */
    public static function getCurrentTotalProgress(int $userId, int $categoryId): ?int
    {
        return static::where([
            ['user_id', $userId],
            ['swim_category_id', $categoryId]
        ]) ->sum('progress_percentage');
    }

    /**
     * The function `getHighestCategoryLevel` retrieves the highest swim category level for a given
     * user ID.
     * 
     * @param int userId The `userId` parameter is an integer value that represents the unique
     * identifier of a user in the database.
     * 
     * @return The function `getHighestCategoryLevel` is returning the highest value of the
     * `swim_category_id` column for a specific `user_id` in the database table.
     */
    public static function getHighestCategoryLevel(int $userId)
    {
        return static::where('user_id', $userId)->max('swim_category_id');
    }
}
