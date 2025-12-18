<?php

namespace App\Http\Resources\UserOverview;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Services\DateService;
use Illuminate\Http\Resources\Json\JsonResource;

class IndexResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $startDate = $this->last_event?->event?->start_date;
        $endDate   = $this->last_event?->event?->end_date;

        return [
            'name' => $this->name,
            'last_name' => $this->last_name,
            'mother_last_name' => $this->mother_last_name,
            'email' => $this->email,
            'uuid' => $this->uuid,
            'student_code' => $this->student_code,
            'role' => $this->whenLoaded('role')->name ?? 'unknown',
            'current_level' => [
                'category_name' => $this->current_level['category_name'] ?? '',
                'total_progress' => $this->current_level['total_progress'] ?? '',
                'total_progress_formatted' => $this->current_level['total_progress_formatted'],
            ],
            'next_level' => $this->next_level['category_name'] ?? '',
            'last_event' => [
                'title' => $this->last_event?->name,
                'slug' => $this->last_event?->slug,
                'content' => $this->last_event?->content,
                'published_at' => $this->last_event?->published_at,
                'location' => $this->last_event?->event?->location,
                'start_date' => $startDate ? Carbon::parse($startDate)->format('Y-m-d') : null,
                'start_hour' => $startDate ? Carbon::parse($startDate)->format('H:i') : null,
                'end_date' => $endDate ? Carbon::parse($endDate)->format('Y-m-d') : null,
                'end_hour' => $endDate ? Carbon::parse($endDate)->format('H:i') : null,
                'remaining_time' => DateService::remainingTime($startDate)
            ],
            'last_reminder' => [
                'title' => 'Próximo pago',
                'Subtitle' => 'Pago de mensualidad • $120.00'
            ],
            'todays_birthdays' => $this->todays_birthdays->map(function($user) {
                return [
                    'name' => $user->name,
                    'last_name' => $user->last_name,
                    'age' => DateService::calculateAge($user->profile->birthdate),
                ];
            })
        ];
    }
}
