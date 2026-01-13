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
            'user' => $this->whenLoaded('user', function() {
                return [
                    'name' => $this->user->name,
                    'last_name' => $this->user->last_name,
                    'mother_last_name' => $this->user->mother_last_name,
                    'email' => $this->user->email,
                    'uuid' => $this->user->uuid,
                    'student_code' => $this->user->student_code,
                ];
            }),
            'amount' => $this->amount,
            'payment_date' => $this->payment_date,
            'covered_until_date' => $this->covered_until_date ? Carbon::parse($this->covered_until_date)->format('Y-m-d') : null,
            'payment_reference' => $this->whenLoaded('reference', function(){
                return [
                    'name' => $this->reference->name,
                    'description' => $this->reference->description,
                ];
            }),
            'payment_type' => $this->whenLoaded('type', function() {
                return [
                    'id' => $this->type->id,
                    'name' => $this->type->name,
                    'description' => $this->type->description
                ];
            }),
            'notes' => $this->notes,
            'created_at' => Carbon::parse($this->created_at)->format('Y-m-d')
        ];
    }
}
