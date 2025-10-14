<?php

namespace App\Http\Resources\Student;

use App\Models\StudentProgress;
use App\Models\SwimCategory;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StudentProgressResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $progressSum = $this->current_total_progress ?? 0;
        $nextCategory = $this->next_category_data;

        return [
            'user' => $this->whenLoaded('user', function() {
                return [
                    'name' => $this->user->name,
                    'last_name' => $this->user->last_name,
                    'mother_last_name' => $this->user->mother_last_name,
                    'uuid' => $this->user->uuid,
                    'student_code' => $this->user->student_code,
                ];
            }),
            'current_progress' => [
                'swim_category_id' => $this->whenLoaded('swimCategory', function() {
                    return $this->swimCategory->id;
                }),
                'swim_category_name' => $this->whenLoaded('swimCategory', function() {
                    return $this->swimCategory->name;
                }),
                'progress_status_id' => $this->whenLoaded('progressStatus', function() {
                    return $this->progressStatus->id;
                }),
                'progress_status_name' => $this->whenLoaded('progressStatus', function() {
                    return $this->progressStatus->name;
                }),
                'total_progress_sum' => $progressSum,
                'total_progress_formatted' => "{$progressSum}%",
                'level_start_date' => $this->start_date,
                'next_category_id' => $nextCategory?->id,
                'next_category_name' => $nextCategory?->name
            ]
        ];
    }
}
