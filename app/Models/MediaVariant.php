<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MediaVariant extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'path',
        'variant',
        'is_main',
        'width',
        'height',
        'media_id'
    ];
}
