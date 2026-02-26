<?php

namespace App\Http\Resources\Attendance;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AssignAttendanceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'user' => $this->whenLoaded('user', function() {
                return [
                    'name' => $this->user->name,
                    'last_name' => $this->user->last_name,
                    'mother_last_name' => $this->user->mother_last_name,
                    'email' => $this->user->email,
                    'uuid' => $this->user->uuid,
                    'student_code' => $this->user->student_code
                ];
            }),
            'attendance_date' => Carbon::parse($this->attendance_date)->format('Y-m-d'),
            'attendance_status' => $this->whenLoaded('attendanceStatus')->name ?? null,
            'user_schedule_day' => $this->whenLoaded('userSchedule')->day->name ?? null
        ];
    }
}
