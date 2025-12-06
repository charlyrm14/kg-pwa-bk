<?php

namespace App\Http\Resources\Attendance;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Services\DateService;
use Illuminate\Support\Str;
use Carbon\Carbon;

class AttendanceResource extends JsonResource
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
            'current_month' => Str::ucfirst(DateService::getCurrentMonth()),
            'current_year' => (new Carbon())->year,
            'attendances' => AttendanceResourceItem::collection($this->whenLoaded('attendancesCurrentMonth'))
        ];
    }
}
