<?php

namespace App\Http\Resources\Media;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StoreMediaResource extends JsonResource
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
            'uuid' => $this->uuid,
            'path' => $this->path,
            'mime_type' => $this->mime_type,
            'disk' => $this->disk,
            'created_at' => Carbon::parse($this->created_at)->format('Y-m-d'),
            'variants' => $this->whenLoaded('variants', function() {
                return $this->variants->map(function($variant) {
                    return [
                        'id' => $variant->id,
                        'path' => $variant->path,
                        'variant' => $variant->variant,
                        'is_main' => $variant->is_main,
                        'width' => $variant->width,
                        'height' => $variant->height,
                        'media_id' => $variant->media_id,
                        'created_at' => Carbon::parse($variant->created_at)->format('Y-m-d'),
                    ];
                });
            })
        ];
    }
}
