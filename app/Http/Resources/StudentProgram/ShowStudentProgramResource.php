<?php

namespace App\Http\Resources\StudentProgram;

use App\Models\SwimCategory;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ShowStudentProgramResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $categories = $this->categories;
        $completedLevelsCount = $categories->whereNotNull('completed_at')->count();
        $currentLevel = $categories->firstWhere('completed_at', null);

        $nextLevel = $currentLevel
            ? SwimCategory::where([['id', '>', $currentLevel->swim_category_id]])->first()
            : null;
        
        $program = $this->program;

        return [
            'user' => new UserInfoResource($this->user),
            'completed_levels_count' => $completedLevelsCount,
            'program' => new ProgramDetailResource($program),
            'current_level' => $currentLevel ? new CurrentLevelResource($currentLevel) : null,
            'next_level' => $nextLevel ? new NextLevelResource($nextLevel) : null,
            'progression_history' => ProgressionHistoryResource::collection($categories),
        ];
    }
}
