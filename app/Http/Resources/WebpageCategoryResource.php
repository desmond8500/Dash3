<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class WebpageCategoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     * @mixin Webpage
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'webpages' => $this->webpages,
        ];
    }
}
