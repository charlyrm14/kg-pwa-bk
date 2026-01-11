<?php

namespace App\Http\Resources\Payment;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class IndexPaymentCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'data' => IndexPaymentResource::collection($this->collection),
            'path' => $this->path(),
            'per_page' => $this->perPage(),
            'next_cursor' => optional($this->nextCursor())->encode(),
            'next_page_url' => $this->nextPageUrl(),
            'prev_cursor' => optional($this->previousCursor())->encode(),
            'prev_page_url' => $this->previousPageUrl(),
        ];
    }
}
