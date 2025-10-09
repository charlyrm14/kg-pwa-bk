<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RankingRule extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'description',
        'trigger_type',
        'trigger_id',
        'points_awarded',
        'is_active'
    ];
}
