<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserNotification extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'user_id',
        'notification_id',
        'is_read',
        'read_at',
        'delivered_at',
        'channel'
    ];

    /**
     * The function "notification" returns a BelongsTo relationship with the Notification model in PHP.
     * 
     * @return BelongsTo The `notification()` function is returning a BelongsTo relationship with the
     * `Notification` model.
     */
    public function notification(): BelongsTo
    {
        return $this->belongsTo(Notification::class);
    }
}
