<?php

namespace App\Http\Resources\StudentProgram;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SkillProgressResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'skill_progress_id' => $this->id,
            'skill_id' => $this->skill?->id,
            'skill_description' => $this->skill?->description,
            'skill_order' => $this->skill?->skill_order,
            'skill_progress_percentage' => $this->progress_percentage,
            'skill_progress_completed_at' => $this->completed_at,
        ];
    }
}
