<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PaymentReference extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'description'
    ];

    /**
     * The function `payments()` returns a relationship where a model has many payments.
     * 
     * @return HasMany The code snippet is a PHP function named `payments` that returns a relationship
     * definition for a "HasMany" relationship in Laravel Eloquent. It specifies that the current model
     * has a one-to-many relationship with the `Payment` model.
     */
    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }
}
