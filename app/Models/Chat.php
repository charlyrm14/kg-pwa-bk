<?php

namespace App\Models;

use App\Observers\ChatObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

#[ObservedBy([ChatObserver::class])]
class Chat extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'title',
        'uuid',
        'chat_type_id',
        'created_by',
    ];

    /**
     * The function chatType() returns a BelongsTo relationship with the ChatType model in PHP.
     * 
     * @return BelongsTo A BelongsTo relationship is being returned.
     */
    public function chatType(): BelongsTo
    {
        return $this->belongsTo(ChatType::class);
    }

    /**
     * The function createdBy() returns the User model instance that created the current model
     * instance.
     * 
     * @return BelongsTo A BelongsTo relationship is being returned, specifically a relationship with
     * the User model where the foreign key 'created_by' is used for the association.
     */
    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * The participants function returns a collection of ChatParticipant models associated with the
     * current model.
     * 
     * @return HasMany The code snippet is a PHP function named `participants` that returns a
     * relationship definition for a "hasMany" relationship in Laravel's Eloquent ORM. It specifies
     * that the current model has multiple instances of the `ChatParticipant` model.
     */
    public function participants(): HasMany
    {
        return $this->hasMany(ChatParticipant::class);
    }
}
