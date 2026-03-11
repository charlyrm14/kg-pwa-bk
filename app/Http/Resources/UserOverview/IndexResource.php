<?php

namespace App\Http\Resources\UserOverview;

use Carbon\Carbon;
use App\Models\SwimCategory;
use Illuminate\Http\Request;
use App\Services\DateService;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\StudentProgram\CurrentLevelResource;
use App\Http\Resources\StudentProgram\NextLevelResource;

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

        $categories = $this->studentPrograms->categories ?? null;

        $currentLevel = $categories ? $categories->firstWhere('completed_at', null) : null;
        $nextLevel = $currentLevel
            ? SwimCategory::where([['id', '>', $currentLevel->swim_category_id]])->first()
            : null;

        return [
            'name' => $this->name,
            'last_name' => $this->last_name,
            'mother_last_name' => $this->mother_last_name,
            'email' => $this->email,
            'uuid' => $this->uuid,
            'student_code' => $this->student_code,
            'role' => $this->whenLoaded('role')->name ?? 'unknown',
            'current_level' => $currentLevel ? new CurrentLevelResource($currentLevel) : null,
            'next_level' => $nextLevel ? new NextLevelResource($nextLevel) : null,
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
                'subtitle' => 'Pago de mensualidad • $120.00'
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
