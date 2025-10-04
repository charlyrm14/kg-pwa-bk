<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Observers\UserObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[ObservedBy([UserObserver::class])]
class User extends Authenticatable
{
    public $plainPassword;
    
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'last_name',
        'mother_last_name',
        'email',
        'email_verified_at',
        'password',
        'force_password_change',
        'uuid',
        'student_code',
        'role_id'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * The function "role" returns the relationship between the current object and the Role model in
     * PHP.
     * 
     * @return BelongsTo A BelongsTo relationship is being returned.
     */
    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }

    /**
     * The function "userProfile" returns a HasOne relationship with the UserProfile model in PHP.
     * 
     * @return HasOne A HasOne relationship is being returned, linking the current model to the UserProfile
     */
    public function profile(): HasOne
    {
        return $this->hasOne(UserProfile::class);
    }

    /**
     * The function "getByUuid" retrieves a User object based on a given UUID.
     * 
     * @param string uuid The parameter "uuid" is a string that represents the unique identifier of a
     * user. It is used to search for and retrieve a specific user from the database.
     * 
     * @return User|null The method `getByUuid` returns an instance of the `User` class if a user with
     * the specified UUID is found in the database. If no user is found with that UUID, it returns
     * `null`.
     */
    public static function getByUuid(string $uuid): ?User
    {
        return static::firstWhere('uuid', $uuid);
    }
}
