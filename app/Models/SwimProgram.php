<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SwimProgram extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'min_age',
        'max_age',
        'is_sequential',
        'is_active'
    ];
}
