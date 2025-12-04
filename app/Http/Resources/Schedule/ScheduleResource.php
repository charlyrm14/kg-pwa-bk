<?php

namespace App\Http\Resources\Schedule;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;

class ScheduleResource extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'day_id' => $this->day_id,
            'day_name' => $this->whenLoaded('day')->name ?? 'unknown',
            'shorting_day' => Str::charAt($this->whenLoaded('day')->name, 0),
            'day_formatted_name' => Str::title($this->whenLoaded('day')->name),
            'entry_time' => $this->entry_time,
            'departure_time' => $this->departure_time
        ];
    }
}
