<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'user_id',
        'payment_type_id',
        'amount',
        'payment_date',
        'covered_until_date',
        'payment_reference',
        'registered_by_user_id',
        'notes'
    ];
}
