<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ArticleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     * @mixin Article
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {

        return [
            'id' => $this->id,
            'designation' => $this->designation,
            'description' => $this->description,
            'reference' => $this->reference,
            'price' => $this->price,
            'weight' => $this->weight,
            'spec' => $this->spec,
            'tva' => $this->tva,
            'quantity' => $this->quantity,
            'quantity_min' => $this->quantity_min,
            'priority_id' => $this->priority_id,
            'priority' => $this->priority(),
            'brand_id' => $this->brand_id,
            'brand_name' => $this->brand->name ?? null,
            'provider_id' => $this->provider_id,
            'provider_name' => $this->provider->name ?? null,
            'image' => url($this->image ?? 'img/icons/no-camera.png'),
            // Tags (servent au type des équipements et à leur icône sur les plans)
            'tag_names' => $this->whenLoaded('tags', fn () => $this->tags->pluck('name')->values()),
        ];
    }
}
