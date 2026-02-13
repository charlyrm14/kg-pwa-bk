<?php

namespace App\Http\Resources\Payment;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UpdatePaymentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'amount' => $this->amount,
            'payment_date' => $this->payment_date,
            'covered_until_date' => $this->covered_until_date ? Carbon::parse($this->covered_until_date)->format('Y-m-d') : null,
            'payment_reference' => $this->whenLoaded('reference')->name ?? null,
            'payment_type' => $this->whenLoaded('type')->name,
            'notes' => $this->notes,
            'created_at' => Carbon::parse($this->created_at)->format('Y-m-d'),
            'created_at_formatted' => $this->created_at->diffForHumans()
        ];
    }
}
