<?php

namespace App\Http\Resources\Attendance;

use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TodayAttendanceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $day = $this->whenLoaded('day');

        return [
            'user' => $this->whenLoaded('user', function() {
                return [
                    'name' => $this->user->name,
                    'last_name' => $this->user->last_name,
                    'mother_last_name' => $this->user->mother_last_name,
                    'email' => $this->user->email,
                    'uuid' => $this->user->uuid,
                    'student_code' => $this->user->student_code,
                    'role_name' => $this->user->role->name ?? null,
                ];
            }),
            'day_name' => $day->name ?? null,
            'shorting_day' => Str::charAt($day->name, 0),
            'day_formatted_name' => Str::title($day->name),
            'entry_time' => $this->entry_time,
            'departure_time' => $this->departure_time,
            'attendance_status' => $this->attendanceStatus?->name ?? null,
            'created_at' => Carbon::parse($this->created_at)->format('Y-m-d'),
            'updated_at' => Carbon::parse($this->updated_at)->format('Y-m-d'),
        ];
    }
}
