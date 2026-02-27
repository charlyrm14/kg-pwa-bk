<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
        'progress_percentage',
        'started_at',
        'completed_at'
    ];

    /**
     * The function returns a collection of student skill progress records associated with a specific
     * student category progress.
     *
     * @return HasMany A relationship method is being returned. It defines a one-to-many relationship
     * between the current model and the `StudentSkillProgress` model using the foreign key
     * `student_category_progress_id`.
     */
    public function skills(): HasMany
    {
        return $this->hasMany(StudentSkillProgress::class, 'student_category_progress_id');
    }

    /**
     * The program function returns a BelongsTo relationship with the StudentProgram model in PHP.
     *
     * @return BelongsTo The `program()` function is returning a relationship method `belongsTo` which
     * defines an inverse one-to-one or many relationship with the `StudentProgram` model.
     */
    public function program(): BelongsTo
    {
        return $this->belongsTo(StudentProgram::class, 'student_program_id');
    }

    /**
     * The swimCategory function returns a BelongsTo relationship with the SwimCategory model in PHP.
     *
     * @return BelongsTo The `swimCategory()` function is returning a relationship method `belongsTo` which
     * defines an inverse one-to-one or many relationship with the `SwimCategory` model.
     */
    public function swimCategory(): BelongsTo
    {
        return $this->belongsTo(SwimCategory::class);
    }

    public function swimCategories(): HasMany
    {
        return $this->hasMany(SwimCategory::class, 'swim_category_id', 'id');
    }
}
