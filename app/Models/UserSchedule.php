<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
}
