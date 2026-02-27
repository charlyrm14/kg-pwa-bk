<?php

namespace App\Http\Resources\StudentProgram;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProgressionHistoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $skillsCompleted = $this->skills->where('progress_percentage', 100)->count();

        return [
            'category_id' => $this->swimCategory?->id,
            'category_name' => $this->swimCategory?->name,
            'category_slug' => $this->swimCategory?->slug,
            'category_description' => $this->swimCategory?->description,
            'progress_percentage' => $this->progress_percentage,
            'is_completed' => !is_null($this->completed_at),
            'is_current' => is_null($this->completed_at),
            'skills_completed' => $skillsCompleted,
            'skills_total' => $this->skills->count(),
            'started_at' => $this->started_at,
            'completed_at' => $this->completed_at,
            'skills' => SkillProgressResource::collection($this->skills),
        ];
    }
}
