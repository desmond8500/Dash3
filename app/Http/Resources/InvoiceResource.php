<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class InvoiceResource extends JsonResource
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
            'projet_id' => $this->projet_id,
            'client_name' => $this->client_name ?? $this->projet->client->name,
            'projet_name' => $this->projet_name ?? $this->projet->name,
            'reference' => $this->reference,
            'description' => $this->description,
            'modalite' => $this->modalite,
            'note' => $this->note,
            'statut' => $this->statut,
            'tax' => $this->tax,
            'remise' => $this->remise,
            'favorite' => $this->favorite,
            'facture_date' => $this->facture_date,
            'paydate' => $this->paydate,
            'montant' => $this->total(),
            'folder' => "https://dash3.yonkou.info/api/v1/facture_pdf/$this->id/facture",
            'spents' => $this->spents,
            'acomptes' => $this->acomptes,

        ];
    }
}
