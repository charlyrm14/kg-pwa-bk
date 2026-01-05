<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ChatParticipant extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'chat_id',
        'user_id',
        'joined_at',
        'left_at'
    ];

    /**
    * The `chat` function returns the relationship between the current object and a `Chat` object.
    * 
    * @return BelongsTo A BelongsTo relationship is being returned.
    */
    public function chat(): BelongsTo
    {
        return $this->belongsTo(Chat::class);
    }

    /**
     * The function `user()` returns the relationship between the current model and the User model in
     * PHP using Eloquent ORM.
     * 
     * @return BelongsTo A BelongsTo relationship is being returned.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
