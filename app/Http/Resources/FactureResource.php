<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FactureResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'invoice_id' => $this->invoice_id,
            'folder' => url($this->folder),
            'status' => $this->status,
            'reference' => $this->reference,
            'description' => $this->description,
            'montant' => $this->montant,
            'date' => $this->date,
            'facture_date' => $this->facture_date,
            'payment_date' => $this->invoice->paydate ?? null,
            'date' => $this->date,
            'year' => $this->year,
            'month' => $this->month,
        ];
    }
}
