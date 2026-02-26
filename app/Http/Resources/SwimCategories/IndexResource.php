<?php

namespace App\Http\Resources\SwimCategories;

use Illuminate\Http\Request;
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
        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'description' => $this->description,
            'level_order' => $this->level_order,
            'swim_program_id' => $this->swim_program_id,
            'skills' => $this->whenLoaded('skills', function() {
                return $this->skills->map(function($skill) {
                    return [
                        'id' => $skill->id,
                        'swim_category_id' => $skill->swim_category_id,
                        'description' => $skill->description,
                        'skill_order' => $skill->skill_order
                    ];
                });
            })
        ];
    }
}
