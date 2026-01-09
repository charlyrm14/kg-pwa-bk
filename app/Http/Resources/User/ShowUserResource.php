<?php

namespace App\Http\Resources\User;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;

class ShowUserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'name' => $this->name,
            'last_name' => $this->last_name,
            'mother_last_name' => $this->mother_last_name,
            'email' => $this->email,
            'uuid' => $this->uuid,
            'student_code' => $this->student_code,
            'role_id' => $this->role_id,
            'created_at' => Carbon::parse($this->created_at)->format('Y-m-d'),
            'role_name' => $this->whenLoaded('role')->name ?? null,
            'schedules' => $this->whenLoaded('schedules', function() {
                return $this->schedules->map(function($schedule) {
                    return [
                        'day_id' => $schedule->day->id,
                        'day_name' => $schedule->day->name,
                        'shorting_day' => Str::charAt($schedule->day->name, 0),
                        'day_formatted_name' => Str::title($schedule->day->name),
                        'entry_time' => $schedule->entry_time,
                        'departure_time' => $schedule->departure_time,
                    ];
                });
            }),
            'attendances' => $this->whenLoaded('attendancesCurrentMonth', function(){
                return $this->attendancesCurrentMonth->map(function($attendance) {
                    $date = Carbon::parse($attendance->created_at)->locale('es');
                    return [
                        'day_id' => $attendance->userSchedule->day->id,
                        'day_name' => $attendance->userSchedule->day->name,
                        'shorting_day' => Str::charAt($attendance->userSchedule->day->name, 0),
                        'day_with_number' => $attendance->userSchedule->day->name . ', ' . $date->translatedFormat('d'),
                        'day_number' => (int) $date->translatedFormat('d'),
                        'entry_time' => $attendance->userSchedule->entry_time,
                        'departure_time' => $attendance->userSchedule->departure_time,
                        'attendance_description' => $attendance->attendanceStatus->description,
                        'attendance_name' => $attendance->attendanceStatus->name,
                        'attendance_month' => Str::ucfirst($date->translatedFormat('F')),
                        'attendance_status_id' => $attendance->attendanceStatus->id,
                        'created_at' => Carbon::parse($attendance->created_at)->format('Y-m-d')
                    ];
                });
            }),
        ];
    }
}
