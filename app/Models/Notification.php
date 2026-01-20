<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
}
