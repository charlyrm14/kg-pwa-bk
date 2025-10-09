<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
}
