<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Observers\UserObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use PhpParser\Builder\Class_;

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
     * The function `hobbies()` returns a HasMany relationship for a user's hobbies.
     * 
     * @return HasMany The `hobbies()` function is returning a relationship method `HasMany` which
     * defines a one-to-many relationship between the current model and the `UserHobby` model. This
     * means that a user can have multiple hobbies associated with them.
     */
    public function hobbies(): BelongsToMany
    {
        return $this->belongsToMany(Hobby::class, 'user_hobbies', 'user_id', 'hobby_id')
            ->withTimestamps();
    }

    /**
     * The function `contents()` returns a relationship where a model has many contents.
     * 
     * @return HasMany The code snippet is a PHP function named `contents` that returns a relationship
     * definition for a "HasMany" relationship in Laravel Eloquent. It specifies that the current model
     * has a one-to-many relationship with the `Content` model.
     */
    public function contents(): HasMany
    {
        return $this->hasMany(Content::class, 'id', 'author_id');
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
