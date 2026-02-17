<?php

namespace App\Http\Resources\Payment;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ShowPaymentResource extends JsonResource
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
            'folio' => $this->folio,
            'amount' => $this->amount,
            'payment_date' => Carbon::parse($this->payment_date)->format('Y-m-d'),
            'covered_until_date' => $this->covered_until_date,
            'notes' => $this->notes,
            'created_at' => Carbon::parse($this->created_at)->format('Y-m-d'),
            'created_at_formatted' => $this->created_at->diffForHumans(),
            'updated_at' => Carbon::parse($this->updated_at)->format('Y-m-d'),
            'updated_at_formatted' => $this->updated_at->diffForHumans(),
            'user' => $this->whenLoaded('user', function() {
                return [
                    'name' => $this->user->name,
                    'last_name' => $this->user->last_name,
                    'mother_last_name' => $this->user->mother_last_name,
                    'email' => $this->user->email
                ];
            }),
            'type' => $this->whenLoaded('type', function() {
                return [
                    'name' => $this->type->name,
                    'slug' => $this->type->slug,
                    'description' => $this->type->description,
                    'base_amount' => $this->type->base_amount,
                    'is_recurring' => $this->type->is_recurring,
                    'coverage_days' => $this->type->coverage_days
                ];
            }),
            'reference' => $this->whenLoaded('reference', function() {
                return [
                    'name' => $this->reference->name,
                    'slug' => $this->reference->slug,
                    'description' => $this->reference->description
                ];
            })
        ];
    }
}
