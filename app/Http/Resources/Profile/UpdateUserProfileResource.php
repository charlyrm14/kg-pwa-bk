<?php

namespace App\Http\Resources\Profile;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Profile\UserProfileResource;

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
            'profile' => new UserProfileResource($this->profile),
            'profile_image' => $this->whenLoaded('profile', function () {
                if (!$this->profile->relationLoaded('avatar'));
                return [
                    'id' => $this->profile->avatar->id,
                    'uuid' => $this->profile->avatar->uuid,
                    'path' => $this->profile->avatar->path,
                    'mime_type' => $this->profile->avatar->mime_type,
                    'context' => $this->profile->avatar->context,
                    'created_at' => Carbon::parse($this->profile->avatar->created_at)->format('Y-m-d'),
                ];
            }),
        ];
    }
}
