<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentSkillProgress extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'student_category_progress_id',
        'skill_id',
        'is_completed',
        'completed_at'
    ];
}
