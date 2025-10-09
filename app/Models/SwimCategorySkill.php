<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
}
