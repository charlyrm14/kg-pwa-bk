<?php

namespace App\Http\Resources\Ranking\Event;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StoreRankingEventResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'points' => $this->points,
            'event_date' => $this->event_date,
            'rule' => $this->whenLoaded('rule', function() {
                return [
                    'id' => $this->rule->id,
                    'name' => $this->rule->name,
                    'description' => $this->rule->description,
                    'points_awarded' => $this->rule->points_awarded,
                    'max_points_per_period' => $this->rule->max_points_per_period
                ];
            })
        ];
    }
}
