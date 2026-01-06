<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserAttendance extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'user_id',
        'user_schedule_id',
        'attendance_status_id'
    ];

    /**
     * This PHP function returns the relationship between the current model and the AttendanceStatus
     * model.
     * 
     * @return BelongsTo A BelongsTo relationship is being returned in this code snippet. It indicates
     * that the current model has a belongsTo relationship with the AttendanceStatus model.
     */
    public function attendanceStatus (): BelongsTo
    {
        return $this->belongsTo(AttendanceStatus::class);
    }

    /**
     * The userSchedule function returns the relationship between the current model and the
     * UserSchedule model.
     * 
     * @return BelongsTo A BelongsTo relationship is being returned.
     */
    public function userSchedule(): BelongsTo
    {
        return $this->belongsTo(UserSchedule::class);
    }

    /**
     * The user function returns the relationship between the current model and the
     * User model.
     * 
     * @return BelongsTo A BelongsTo relationship is being returned.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
