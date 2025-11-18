<?php

namespace App\Http\Resources\Content;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DetailContentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'title' => $this->name,
            'slug' => $this->slug,
            'content' => $this->content,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'author' => $this->whenLoaded('user')->name ?? 'unknown',
            'type' => $this->whenLoaded('type')->name ?? 'unknown',
            'status' => $this->whenLoaded('status')->name ?? 'unknown',
            'event' => $this->whenLoaded('event', function() {
                return [
                    'location' => $this->event->location,
                    'start_date' => $this->event->start_date,
                    'end_date' => $this->end_date
                ];
            })
        ];
    }
}
