<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentProgram extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'user_id',
        'swim_program_id',
        'started_at',
        'ended_at',
        'is_active'
    ];
}
