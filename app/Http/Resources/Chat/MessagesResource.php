<?php

namespace App\Http\Resources\Chat;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MessagesResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'message' => $this->message,
            'sender_type' => $this->senderType->name ?? null,
            'created_at' => Carbon::parse($this->created_at)->format('Y-m-d'),
            'user' => [
                'name' => $this->user->name ?? null,
                'last_name' => $this->user->last_name ?? null,
                'email' => $this->user->email ?? null,
            ]
        ];
    }
}
