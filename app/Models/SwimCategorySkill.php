<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SwimCategorySkill extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'swim_category_id',
        'skill_id',
        'percentage'
    ];

    /**
     * The function returns a BelongsTo relationship with the Skill model in PHP.
     * 
     * @return BelongsTo The `skill()` function is returning a BelongsTo relationship with the `Skill`
     * model.
     */
    public function skill(): BelongsTo
    {
        return $this->belongsTo(Skill::class);
    }
}
