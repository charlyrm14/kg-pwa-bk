<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

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

    /**
     * The function `swimCategories` returns a collection of SwimCategory models associated with the
     * current model.
     *
     * @return HasMany The `swimCategories()` function is returning a relationship of type `HasMany`
     * for the `SwimCategory` model. This indicates that the current model has a one-to-many
     * relationship with the `SwimCategory` model, meaning that each instance of the current model can
     * have multiple related `SwimCategory` instances.
     */
    public function swimCategories(): HasMany
    {
        return $this->hasMany(SwimCategory::class);
    }
}
