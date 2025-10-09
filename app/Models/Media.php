<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'uuid',
        'path',
        'mime_type',
        'disk',
        'is_protected',
        'mediaable_id',
        'mediaable_type'
    ];
}
