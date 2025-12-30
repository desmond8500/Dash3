<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AchatResource extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'provider_id' => $this->provider_id ,
            'journal_id' => $this->journal_id ,
            'transaction_id' => $this->transaction_id ,
            'name' => $this->name,
            'description' => $this->description,
            'date' => $this->date,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'total' => $this->total(),
            'ttc' => $this->total() + $this->tva(),
            'tva' => $this->tva(),
            'factures' => $this->factures(),
            'provider' => $this->provider,
        ];
    }
}
