<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentCategoryProgress extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'student_program_id',
        'swim_category_id',
        'started_at',
        'completed_at'
    ];
}
