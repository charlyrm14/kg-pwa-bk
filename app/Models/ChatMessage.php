<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ChatMessage extends Model
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
        'message',
        'sender_type_id'
    ];

    /**
     * The function user() returns a BelongsTo relationship with the user model in PHP.
     * 
     * @return BelongsTo A BelongsTo relationship is being returned.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * The function senderType() returns a BelongsTo relationship with the SenderType model in PHP.
     * 
     * @return BelongsTo A BelongsTo relationship is being returned.
     */
    public function senderType(): BelongsTo
    {
        return $this->belongsTo(SenderType::class);
    }
}
