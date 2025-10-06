<?php

namespace App\Http\Resources\Content;

use App\Http\Resources\ContentType\EventResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class NewContentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'name' => $this->name,
            'slug' => $this->slug,
            'content' => $this->content,
            'content_type' => $this->whenLoaded('type', function() {
                return $this->type->name;
            }),
            'content_status_id' => $this->whenLoaded('status', function() {
                return $this->status->name;
            }),
            'author' => $this->whenLoaded('user', function() {
                return $this->user->name;
            }),
            'published_at' => $this->published_at,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'details' => new EventResource($this->event)
        ];
    }
}
