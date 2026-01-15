<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RankingPeriodUser extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'ranking_period_id',
        'user_id',
        'total_points',
        'position'
    ];

    /**
     * The function "user" returns a BelongsTo relationship with the User model in PHP.
     * 
     * @return BelongsTo The `user()` function is returning a BelongsTo relationship with the
     * `User` model.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
