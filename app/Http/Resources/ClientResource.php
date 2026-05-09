<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ClientResource extends JsonResource

{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'name' => $this->name,
            'description' => $this->description,
            'address' => $this->address,
            'avatar' => url($this->avatar ?? 'img/icons/no-camera.png'),
            'status' => $this->status,
            'type' => $this->type,
            'favorite' => $this->favorite,
        ];
    }
}
