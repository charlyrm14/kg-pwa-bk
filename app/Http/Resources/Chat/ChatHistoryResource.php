<?php

namespace App\Http\Resources\Chat;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Pagination\CursorPaginator;

class ChatHistoryResource extends JsonResource
{
    protected CursorPaginator $messages;

    public function __construct($chat, CursorPaginator $messages)
    {
        parent::__construct($chat);
        $this->messages = $messages;
    }

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $path = url("/api/v1/chat/{$this->uuid}/messages");
        $nextCursor = optional($this->messages->nextCursor())->encode();
        $prevCursor = optional($this->messages->previousCursor())->encode();

        return [
            'chat' => [
                'uuid' => $this->uuid,
                'title' => $this->title,
                'type' => $this->chatType->name ?? null,
                'created_by' => $this->createdBy->name ?? null,
                'created_at' => Carbon::parse($this->created_at)->format('Y-m-d'),
            ],
            'messages' => MessagesResource::collection($this->messages),
            'path' => $path,
            'per_page' => $this->messages->perPage(),
            'next_cursor' => optional($this->messages->nextCursor())->encode(),
            'next_page_url' => $nextCursor ? $path . '?cursor=' . $nextCursor : null,
            'prev_cursor' => optional($this->messages->previousCursor())->encode(),
            'prev_page_url' => $prevCursor ? $path . '?cursor=' . $prevCursor : null
        ];
    }
}
