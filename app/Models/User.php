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
use Illuminate\Support\Facades\DB;
use Laravel\Passport\Contracts\OAuthenticatable;
use Laravel\Passport\HasApiTokens;
use Illuminate\Support\Collection;
use App\Services\DateService;

#[ObservedBy([UserObserver::class])]
class User extends Authenticatable implements OAuthenticatable
{
    public $plainPassword;
    
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, SoftDeletes, HasApiTokens;

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
     * The function `studentProgress()` returns a relationship where a model has many studentProgress progress category.
     * 
     * @return HasMany The code snippet is a PHP function named `studentProgress` that returns a relationship
     * definition for a "HasMany" relationship in Laravel Eloquent. It specifies that the current model
     * has a one-to-many relationship with the `Content` model.
     */
    public function studentProgress(): HasMany
    {
        return $this->hasMany(StudentProgress::class);
    }

    /**
     * The function `schedules()` returns a relationship where a model has many UserSchedule.
     * 
     * @return HasMany The code snippet is a PHP function named `schedules` that returns a relationship
     * definition for a "HasMany" relationship in Laravel Eloquent. It specifies that the current model
     * has a one-to-many relationship with the `UserSchedule` model.
     */
    public function schedules(): HasMany
    {
        return $this->hasMany(UserSchedule::class);
    }

    /**
     * The function "scheduleByDay" returns a HasOne relationship with the UserSchedule model in PHP.
     * 
     * @return HasOne A HasOne relationship is being returned, linking the current model to the UserSchedule
     */
    public function scheduleByDay(): HasOne
    {
        return $this->hasOne(UserSchedule::class)->where('day_id', DateService::getCurrentDayName());
    }

    /**
     * The function `attendances()` returns a relationship where a model has many UserAttendance.
     * 
     * @return HasMany The code snippet is a PHP function named `attendances` that returns a relationship
     * definition for a "HasMany" relationship in Laravel Eloquent. It specifies that the current model
     * has a one-to-many relationship with the `UserAttendance` model.
     */
    public function attendances(): HasMany
    {
        return $this->hasMany(UserAttendance::class);
    }

    /**
     * This PHP function returns the user attendances for the current month.
     * 
     * @return HasMany The `attendancesCurrentMonth` function is returning a relationship of type
     * `HasMany`. It retrieves all `UserAttendance` records associated with the current user where the
     * `date` column matches the current month and year.
     */
    public function attendancesCurrentMonth(): HasMany
    {
        return $this->hasMany(UserAttendance::class)
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->orderBy('created_at', 'DESC')
            ->with(['userSchedule.day', 'attendanceStatus']);
    }

    /**
     * This PHP function retrieves user attendances based on a specified year and month, ordering them
     * by date and including related user schedule and attendance status information.
     * 
     * @param int year The `year` parameter represents the year for which you want to retrieve
     * attendance records. It is an integer value that specifies the year (e.g., 2022).
     * @param int month The `month` parameter in the `attendancesByDate` function represents the month
     * for which you want to retrieve attendance records. It is an integer value that corresponds to
     * the month of the year (1 for January, 2 for February, and so on up to 12 for December).
     * 
     * @return HasMany The `attendancesByDate` function returns a relationship query that retrieves
     * user attendances based on the specified year and month. It filters the results by the
     * `created_at` date field, orders them in descending order by `created_at`, and eager loads the
     * related `userSchedule.day` and `attendanceStatus` models.
     */
    public function attendancesByDate(int $year, int $month): HasMany
    {
        return $this->hasMany(UserAttendance::class)
            ->whereMonth('created_at', $month)
            ->whereYear('created_at', $year)
            ->orderBy('created_at', 'DESC')
            ->with(['userSchedule.day', 'attendanceStatus']);
    }

    /**
     * The `progressionByCategory` function retrieves the total progress percentage for each swim
     * category based on student progress data.
     * 
     * @return This function returns the progression of students by swim category. It selects the swim
     * category ID, name, and the total progress percentage achieved by students in each category. The
     * results are grouped by swim category ID and then formatted into an array with keys for category
     * ID, category name, and total progress.
     */
    public function progressionByCategory()
    {   
        return $this->studentProgress()
            ->select(
                'swim_category_id as category_id',
                'swim_categories.name as category_name',
                DB::raw('SUM(progress_percentage) as total_progress')
            )
            ->join('swim_categories', 'student_progress.swim_category_id', '=', 'swim_categories.id')
            ->groupBy('swim_category_id')
            ->get()
            ->map(function ($item) {
                return [
                    'category_id' => $item->category_id,
                    'category_name' => $item->category_name,
                    'total_progress' => (int) $item->total_progress
                ];
        });
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

    /**
     * The function `birthdayToday` retrieves users whose birthday is today along with their profiles.
     * 
     * @return Collection A collection of users whose birthday is today, along with their profile
     * information.
     */
    public static function birthdayToday(): Collection
    {
        return static::whereHas('profile', function($query) {
            $query->whereMonth('birthdate', now()->month)
                ->whereDay('birthdate', now()->day);
        })
        ->with(['profile', 'studentProgress'])
        ->get();
    }

    /**
     * The function `ai` returns the user with the email specified in the configuration as an AI user.
     * 
     * @return self An instance of the class that contains this method.
     */
    public static function ai(): self
    {
        return cache()->rememberForever('ai_user', fn () =>
            self::where('email', config('app.ai_email'))->firstOrFail()
        );
    }
}
