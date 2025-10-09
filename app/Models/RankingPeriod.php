<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RankingPeriod extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'user_id',
        'period_type_id',
        'start_date',
        'end_date',
        'total_points',
        'calculated_at'
    ];
}
