<?php

namespace App\Http\Resources\Profile;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserProfileResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'birthdate' => $this->birthdate,
            'phone_number' => $this->phone_number,
            'address' => $this->address,
            'gender_name' => $this->whenLoaded('gender', function() {
                return $this->gender->name;
            })
        ];
    }
}
