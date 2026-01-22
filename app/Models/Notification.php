<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Notification extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'title',
        'body',
        'notification_type_id',
        'data',
        'action_url',
        'is_broadcast',
        'created_by_user_id'
    ];

    /**
     * The function "type" returns a BelongsTo relationship with the NotificationType model in PHP.
     * 
     * @return BelongsTo The `type()` function is returning a BelongsTo relationship with the
     * `NotificationType` model.
     */
    public function notificationType(): BelongsTo
    {
        return $this->belongsTo(NotificationType::class);
    }
}
