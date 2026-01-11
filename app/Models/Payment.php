<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment extends Model
{
    use SoftDeletes;
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
        'payment_reference_id',
        'registered_by_user_id',
        'notes'
    ];

    /**
     * The function "user" returns the relationship between the current object and the User model in
     * PHP.
     * 
     * @return BelongsTo A BelongsTo relationship is being returned.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * The function "type" returns the relationship between the current object and the PaymentType model in
     * PHP.
     * 
     * @return BelongsTo A BelongsTo relationship is being returned.
     */
    public function type(): BelongsTo
    {
        return $this->belongsTo(PaymentType::class, 'payment_type_id');
    }

    /**
     * The function "reference" returns the relationship between the current object and the PaymentReference model in
     * PHP.
     * 
     * @return BelongsTo A BelongsTo relationship is being returned.
     */
    public function reference(): BelongsTo
    {
        return $this->belongsTo(PaymentReference::class, 'payment_reference_id');
    }
}
