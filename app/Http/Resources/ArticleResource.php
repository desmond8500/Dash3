<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ArticleResource extends JsonResource
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
            'designation' => $this->designation,
            'reference' => $this->reference,
            'price' => $this->price,
            'quantity' => $this->quantity,
            'brand_id' => $this->brand_id,
            'brand_name' => $this->brand->name ?? null,
            'provider_id' => $this->provider_id,
            'provider_name' => $this->provider->name ?? null,
            'image' => url($this->image ?? 'img/icons/no-camera.png'),
        ];
    }
}
