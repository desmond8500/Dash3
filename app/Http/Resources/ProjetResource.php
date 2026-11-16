<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProjetResource extends JsonResource

{
    /**
     * Transform the resource collection into an array.
     * @mixin Projet
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [

                    'id' => $this->id,
                    'client_id' => $this->client_id,
                    'name' => $this->name,
                    'description' => $this->description,
                    'start_date' => $this->start_date,
                    'end_date' => $this->end_date,
                    'favorite' => $this->favorite,
                    'client_name' => $this->client ? $this->client->name : null,
                    'invoices' => $this->invoices,
                    'buildings' => $this->buildings,
                    'tasks' => $this->tasks,
                    'journals' => $this->journals,
                    'contacts' => $this->contacts,
                    'notes' => $this->notes,
                    'badges' => $this->badges,
                    'address' => $this->address,
                    'latitude' => $this->latitude !== null ? (float) $this->latitude : null,
                    'longitude' => $this->longitude !== null ? (float) $this->longitude : null,
                    // Quantités affichées dans la carte résumé (onglets)
                    'counts' => [
                        'badges' => \App\Models\Badge::where('projet_id', $this->id)->count(),
                        'notes' => \App\Models\ProjetNote::where('projet_id', $this->id)->count(),
                        'documents' => \App\Models\ProjectDoc::where('projet_id', $this->id)->count(),
                    ],
                    'img' => url($this->logo ?? $this->client?->avatar ?? 'img/icons/005-notebook.png'),
                    'logo' => $this->logo
        ];
    }
}
