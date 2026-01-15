<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class RankingPeriod extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'period_type_id',
        'start_date',
        'end_date',
        'calculated_at',
        'status'
    ];

    /**
     * The function "periodType" returns a BelongsTo relationship with the PeriodType model in PHP.
     * 
     * @return BelongsTo The `periodType()` function is returning a BelongsTo relationship with the
     * `PeriodType` model.
     */
    public function periodType(): BelongsTo
    {
        return $this->belongsTo(PeriodType::class);
    }

    /**
     * The function `users()` returns a relationship where a model has many users.
     * 
     * @return HasMany The code snippet is a PHP function named `users` that returns a relationship
     * definition for a "HasMany" relationship in Laravel Eloquent. It specifies that the current model
     * has a one-to-many relationship with the `User` model.
     */
    public function users(): HasMany
    {
        return $this->hasMany(RankingPeriodUser::class, 'ranking_period_id', 'id');
    }
}
