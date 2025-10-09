<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserAchievement extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'user_id',
        'achievement_id',
        'progress_value',
        'achievement_status_id',
        'earned_at',
        'start_date'
    ];
}
