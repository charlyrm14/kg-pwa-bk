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
        'period_type_id',
        'start_date',
        'end_date',
        'calculated_at',
        'status'
    ];
}
