<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

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
        'ended_at'
    ];

    /**
     * The function "user" returns the relationship between the current object and the User model in
     * PHP.
     *
     * @return BelongsTo A BelongsTo relationship is being returned.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * The function `categories()` returns a HasMany relationship for StudentCategoryProgress model.
     *
     * @return HasMany A relationship method `hasMany` is being returned, which defines a one-to-many
     * relationship between the current model and the `StudentCategoryProgress` model. This method
     * indicates that the current model has multiple instances of `StudentCategoryProgress`.
     */
    public function categories(): HasMany
    {
        return $this->hasMany(StudentCategoryProgress::class);
    }

    /**
     * The function "currentCategory" returns a HasOne relationship with the StudentCategoryProgress model in PHP.
     *
     * @return HasOne A HasOne relationship is being returned, linking the current model to the StudentCategoryProgress
     */
    public function currentCategory(): HasOne
    {
        return $this->hasOne(StudentCategoryProgress::class)->whereNull('completed_at');
    }

    /**
     * The function "program" returns the relationship between the current object and the SwimProgram model in
     * PHP.
     *
     * @return BelongsTo A BelongsTo relationship is being returned.
     */
    public function program(): BelongsTo
    {
        return $this->belongsTo(SwimProgram::class, 'swim_program_id');
    }
}
