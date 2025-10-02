<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserHobby extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'user_id', 
        'hobby_id'
    ];

    /**
     * The function `hobby()` returns a BelongsTo relationship with the Hobby model in PHP.
     * 
     * @return BelongsTo A BelongsTo relationship is being returned.
     */
    public function hobby(): BelongsTo
    {
        return $this->belongsTo(Hobby::class);
    }
}
