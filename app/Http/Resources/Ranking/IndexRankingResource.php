<?php

namespace App\Http\Resources\Ranking;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class IndexRankingResource extends JsonResource
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
            'period_type_id' => $this->period_type_id,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'calculated_at' => $this->calculated_at,
            'status' => $this->status,
            'created_at' => Carbon::parse($this->created_at)->format('Y-m-d'),
            'users' => $this->whenLoaded('users', function() {
                return $this->users->map(function($user) {
                    return [
                        'id' => $user->id,
                        'ranking_period_id' => $user->ranking_period_id,
                        'total_points' => $user->total_points,
                        'position' => $user->position,
                        'detail' => [
                            'name' => $user->user->name,
                            'last_name' => $user->user->last_name,
                            'mother_last_name' => $user->user->mother_last_name,
                        ]
                    ];
                });
            })
        ];
    }
}
