<?php

namespace App\Http\Resources\User;

use App\Http\Resources\Profile\UserProfileResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UpdateUserProfileResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'name' => $this->name,
            'last_name' => $this->last_name,
            'mother_last_name' => $this->mother_last_name,
            'email' => $this->email,
            'uuid' => $this->uuid,
            'student_code' => $this->student_code,
            'profile' => new UserProfileResource($this->profile)
        ];
    }
}
