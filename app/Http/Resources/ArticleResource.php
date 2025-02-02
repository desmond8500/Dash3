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
            'designation' => $this->designation,
            'reference' => $this->reference,
            'price' => number_format($this->price, 0, ',', ' '),
            'image' => url($this->image),
        ];
    }
}
