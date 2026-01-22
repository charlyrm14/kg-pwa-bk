<?php

declare(strict_types=1);

namespace App\Events;

use Carbon\Carbon;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\DTOs\Notifications\NotificationDTO;
use Illuminate\Broadcasting\InteractsWithSockets;


class NotificationBroadcasted implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(
        private readonly NotificationDTO $payload
    ){}

    /**
     * Get the channel the event should broadcast on.
     */
    public function broadcastOn(): array //: Channel
    {
        // return new PrivateChannel(
        //     'users.' . $this->payload->userId
        // );
        return ['notifications'];
    }

    /**
     * The model event's broadcast name.
     */
    public function broadcastAs(): string|null
    {
        return 'notification.received';
    }

    /**
     * Get the data to broadcast for the model.
     *
     * @return array<string, mixed>
     */
    public function broadcastWith(): array
    {
        return [
            'id' => $this->payload->notification->id,
            'title' => $this->payload->notification->title,
            'body' => $this->payload->notification->body,
            'action_url' => $this->payload->notification->action_url,
            'type' => $this->payload->notification->type->slug ?? null,
            'created_at' => Carbon::parse($this->payload->notification->created_at)->format('Y-m-d'),
        ];
    }
}