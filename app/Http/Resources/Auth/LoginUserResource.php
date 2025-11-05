<?php

namespace App\Http\Resources\Auth;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LoginUserResource extends JsonResource
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
            'student_code' => $this->student_code,
            'role' => $this->whenLoaded('role')->name ?? 'unknown',
        ];
    }
}
