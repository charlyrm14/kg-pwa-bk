<?php

namespace App\Http\Resources\Notification;

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
            'id' => $this->id,
            'is_read' => $this->is_read,
            'read_at' => $this->read_at,
            'delivered_at' => $this->delivered_at,
            'channel' => $this->channel,
            'created_at' => Carbon::parse($this->created_at)->format('Y-m-d'),
            'updated_at' => Carbon::parse($this->updated_at)->format('Y-m-d'),
            'notification' => $this->whenLoaded('notification', function() {
                return [
                    'id' => $this->notification->id,
                    'title' => $this->notification->title,
                    'body' => $this->notification->body,
                    'notification_type_id' => $this->notification->notification_type_id,
                    'data' => $this->notification->data,
                    'action_url' => $this->notification->action_url,
                    'is_broadcast' => (boolean) $this->notification->is_broadcast,
                    'created_at' => Carbon::parse($this->notification->created_at)->format('Y-m-d'),
                    'updated_at' => Carbon::parse($this->notification->updated_at)->format('Y-m-d'),
                    'notification_type' => [
                        'id' => $this->notification->notificationType->id,
                        'name' => $this->notification->notificationType->name,
                        'slug' => $this->notification->notificationType->slug,
                        'description' => $this->notification->notificationType->description
                    ]
                ];
            })
        ];
    }
}
