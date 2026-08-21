<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PersonaResource extends JsonResource
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
            'firstname' => $this->firstname,
            'lastname' => $this->lastname,
            'fullname' => "{$this->firstname} {$this->lastname}",
            'description' => $this->description,
            'avatar' => $this->avatar
                ? asset($this->avatar)
                : asset('img/icons/004-user.png'),
            'created_at' => $this->created_at?->format('Y-m-d H:i'),
        ];
    }
}
