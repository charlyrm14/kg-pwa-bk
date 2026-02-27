<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
}
