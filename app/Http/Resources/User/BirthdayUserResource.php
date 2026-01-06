<?php

namespace App\Http\Resources\User;

use Illuminate\Http\Request;
use App\Services\DateService;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\UserOverview\IndexResource;

class BirthdayUserResource extends JsonResource
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
            'profile' => $this->whenLoaded('profile', function() {
                return [
                    'about_me' => $this->profile->about_me,
                    'birthdate' => $this->profile->birthdate,
                    'age' => DateService::calculateAge($this->profile->birthdate),
                    'gender' => optional($this->profile->gender)->name,
                ];
            }),
            'current_level' => 'NIVEL ' . $this->current_level
        ];
    }
}
