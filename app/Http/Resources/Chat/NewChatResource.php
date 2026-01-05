<?php

namespace App\Http\Resources\Chat;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class NewChatResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'title' => $this->title,
            'uuid' => $this->uuid,
            'created_by' => $this->whenLoaded('createdBy', function() {
                return [
                    'name' => $this->createdBy->name,
                    'last_name' => $this->createdBy->last_name,
                    'email' => $this->createdBy->email,
                    'uuid' => $this->createdBy->uuid,
                ];
            }),
            'chat_type' => $this->whenLoaded('chatType')->name ?? null,
            'participants' => $this->whenLoaded('participants', function() {
                return $this->participants->map(function($participant) {
                    return [
                        'name' => $participant->user->name,
                        'last_name' => $participant->user->last_name,
                        'email' => $participant->user->email,
                        'uuid' => $participant->user->uuid,
                        'joined_at' => $participant->joined_at
                    ];
                });
            }),
            'created_at' => Carbon::parse($this->created_at)->format('Y-m-d'),
            'updated_at' => Carbon::parse($this->updated_at)->format('Y-m-d'),
        ];
    }
}
