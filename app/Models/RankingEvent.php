<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Casts\Attribute;

class RankingEvent extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'user_id',
        'ranking_rule_id',
        'points',
        'event_date',
        'metadata'
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'metadata' => 'array'
        ];
    }

    /**
     * The function "rule" returns a BelongsTo relationship with the RankingRule model in PHP.
     * 
     * @return BelongsTo The `rule()` function is returning a BelongsTo relationship with the
     * `RankingRule` model.
     */
    public function rule(): BelongsTo
    {
        return $this->belongsTo(RankingRule::class, 'ranking_rule_id');
    }
}
