<?php

namespace App\Http\Resources\Attendance;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;
use Carbon\Carbon;

class AttendanceResourceItem extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $schedule = $this->whenLoaded('userSchedule');  
        $day = $schedule->day;
        $attendance = $this->whenLoaded('attendanceStatus');   
        $date = Carbon::parse($this->created_at)->locale('es');

        return [
            'day_id' => $day->id,
            'day_name' => $day->name ?? 'UNKNOWN',
            'shorting_day' => Str::charAt($day->name, 0),
            'day_with_number' => $day->name . ', ' . $date->translatedFormat('d'),
            'day_number' => (int) $date->translatedFormat('d'),
            'entry_time' => $schedule->entry_time ?? '00:00',
            'departure_time' => $schedule->departure_time ?? '00:00',
            'type_attendance' => $attendance->name ?? 'UNKNOWN',
            'attendance_description' => $attendance->description ?? 'UNKNOWN',
            'attendance_month' => Str::ucfirst($date->translatedFormat('F'))
        ];
    }
}
