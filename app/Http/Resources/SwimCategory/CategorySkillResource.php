<?php

namespace App\Http\Resources\SwimCategory;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategorySkillResource extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'percentage' => $this->percentage,
            'skill' => $this->whenLoaded('skill', function() {
                return $this->skill->description;
            })
        ];
    }
}
