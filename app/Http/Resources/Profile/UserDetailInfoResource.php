<?php

namespace App\Http\Resources\Profile;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserDetailInfoResource extends JsonResource
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
            'force_password_change' => $this->force_password_change,
            'uuid' => $this->uuid,
            'student_code' => $this->student_code,
            'role' => $this->whenLoaded('role', function() {
                return $this->role->name;
            }),
            'profile' => $this->whenLoaded('profile', function() {
                return [
                    'about_me' => $this->profile->about_me,
                    'birthdate' => $this->profile->birthdate,
                    'lada' => $this->profile->lada,
                    'phone_number' => $this->profile->phone_number,
                    'address' => $this->profile->address,
                    'gender' => optional($this->profile->gender)->name,
                ];
            }),
            'hobbies' => $this->whenLoaded('hobbies', function() {
                return $this->hobbies->map(function($hobby) {
                    return [
                        'id' => $hobby->id,
                        'name' => $hobby->name,
                    ];
                });
            }),
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
            'created_at' => Carbon::parse($this->created_at)->format('Y-m-d'),
            'updated_at' => Carbon::parse($this->created_at)->format('Y-m-d')
        ];
    }
}
