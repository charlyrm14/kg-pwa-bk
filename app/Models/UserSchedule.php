<?php

namespace App\Models;

use App\Services\DateService;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Pagination\LengthAwarePaginator;

class UserSchedule extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'user_id',
        'day_id',
        'entry_time',
        'departure_time'
    ];

    /**
     * The function `user()` returns a BelongsTo relationship with the Hobby model in PHP.
     * 
     * @return BelongsTo A BelongsTo relationship is being returned.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * The function `day()` returns a BelongsTo relationship with the Hobby model in PHP.
     * 
     * @return BelongsTo A BelongsTo relationship is being returned.
     */
    public function day(): BelongsTo
    {
        return $this->belongsTo(Day::class);
    }

    /**
     * Retrieve the attendances scheduled for the current day.
     *
     * This query resolves the current day ID using the DateService
     * and fetches user schedules that match that day.
     *
     * Relationships loaded:
     * - user.role
     * - day
     *
     * If the current day ID cannot be resolved (returns 0),
     * the query will not return any records.
     *
     * @return LengthAwarePaginator Paginated list of today's attendances.
     */
    public static function todayAttendances(): LengthAwarePaginator
    {
        return static::with(['user.role', 'day'])->where([
            'day_id' => DateService::getCurrentDayName()
        ])->paginate(15);
    }
}
