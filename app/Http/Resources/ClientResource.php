<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ClientResource extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'data' => [
                'name' => $this->name,
                'description' => $this->description,
                'address' => $this->address,
                'avatar' => url($this->avatar ?? 'img/icons/no-camera.png'),
                'status' => $this->status,
                'type' => $this->type,
                'favorite' => $this->favorite,
            ],
            'meta' => [
                'current_page' => $this->currentPage(),
                'last_page' => $this->lastPage(),
                'per_page' => $this->perPage(),
                'total' => $this->total(),
            ],
        ];
    }
}
