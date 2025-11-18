<?php

namespace App\Http\Resources\Content;

use Carbon\Carbon;
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
            'title' => $this->name,
            'slug' => $this->slug,
            'content' => $this->content,
            'created_at' => Carbon::parse($this->created_at)->format('Y-m-d'),
            'updated_at' => Carbon::parse($this->updated_at)->format('Y-m-d'),
            'author' => $this->whenLoaded('user')->name ?? 'unknown',
            'type' => $this->whenLoaded('type')->name ?? 'unknown',
            'status' => $this->whenLoaded('status')->name ?? 'unknown',
            'event' => $this->whenLoaded('event', function() {
                return [
                    'location' => $this->event->location,
                    'start_date' => Carbon::parse($this->event->start_date)->format('Y-m-d'),
                    'start_hour' => Carbon::parse($this->event->start_date)->format('H:i'),
                    'end_date' => Carbon::parse($this->event->end_date)->format('Y-m-d'),
                    'end_hour' => Carbon::parse($this->event->end_date)->format('H:i')
                ];
            })
        ];
    }
}
