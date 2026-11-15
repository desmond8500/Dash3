<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ClientResource extends JsonResource

{
    /**
     * Transform the resource collection into an array.
     * @mixin Client
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'address' => $this->address,
            'avatar' => url($this->avatar ?? 'img/icons/012-performance.png'),
            'status' => $this->status,
            'type' => $this->type,
            'favorite' => $this->favorite,
            'projets_count' => $this->whenHas('projets_count'),
            'tasks_count' => $this->whenHas('tasks_count'),
            'contacts_count' => $this->whenHas('contacts_count'),
        ];
    }
}
