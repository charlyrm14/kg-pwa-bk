<?php

namespace App\Http\Resources\Attendance;

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
            'attendance_status' => $this->whenLoaded('attendanceStatus', function() {
                return [
                    'id' => $this->attendanceStatus->id,
                    'name' => $this->attendanceStatus->name,
                    'description' => $this->attendanceStatus->description
                ];
            }),
            'user_schedule' => $this->whenLoaded('userSchedule', function() {
                return [
                    'day_name' => $this->userSchedule->day->name,
                    'entry_time' => $this->userSchedule->entry_time,
                    'departure_time' => $this->userSchedule->departure_time
                ];
            }),
        ];
    }
}
