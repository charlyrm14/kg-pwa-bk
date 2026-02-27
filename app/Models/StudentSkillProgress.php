<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
        'progress_percentage',
        'completed_at'
    ];

    /**
     * The function categoryProgress() returns the relationship between the current model and the
     * StudentCategoryProgress model based on the student_category_progress_id foreign key.
     *
     * @return BelongsTo A BelongsTo relationship is being returned in this function. It defines a
     * relationship where the current model belongs to another model (in this case,
     * StudentCategoryProgress) based on the specified foreign key ('student_category_progress_id').
     */
    public function categoryProgress(): BelongsTo
    {
        return $this->belongsTo(StudentCategoryProgress::class,'student_category_progress_id');
    }

    /**
     * The function skill() returns the relationship between the current model and the
     * Skill model
     *
     * @return BelongsTo A BelongsTo relationship is being returned in this function. It defines a
     * relationship where the current model belongs to another model (in this case,
     * Skill).
     */
    public function skill(): BelongsTo
    {
        return $this->belongsTo(Skill::class);
    }
}
