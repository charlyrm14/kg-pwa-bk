<?php

namespace App\Http\Resources\SwimPrograms;

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
            'min_age' => $this->min_age,
            'max_age' => $this->max_age,
            'is_sequential' => $this->is_sequential,
            'is_active' => $this->is_active,
            'categories' => $this->whenLoaded('swimCategories', function() {
                if (!$this->swimCategories) return null;
                return $this->swimCategories->map(function($category) {
                    if(!$category) return null;
                    return [
                        'id' => $category->id,
                        'name' => $category->name,
                        'slug' => $category->slug,
                        'description' => $category->description,
                        'level_order' => $category->level_order,
                        'swim_program_id' => $category->swim_program_id,
                        'skills' => $category->skills->map(function($skill) {
                            return [
                                'id' => $skill->id,
                                'swim_category_id' => $skill->swim_category_id,
                                'description' => $skill->description,
                                'skill_order' => $skill->skill_order
                            ];
                        }),
                    ];
                });
            })
        ];
    }
}
