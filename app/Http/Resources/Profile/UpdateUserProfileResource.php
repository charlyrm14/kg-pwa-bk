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
                
                if (!$this->profile->relationLoaded('avatar')) {
                    return null;
                }

                $avatar = $this->profile->avatar;

                if (!$avatar) {
                    return null;
                }

                return [
                    'id' => $avatar->id,
                    'uuid' => $avatar->uuid,
                    'path' => $avatar->path,
                    'mime_type' => $avatar->mime_type,
                    'context' => $avatar->context,
                    'created_at' => Carbon::parse($avatar->created_at)->format('Y-m-d'),
                ];
            }),
        ];
    }
}
