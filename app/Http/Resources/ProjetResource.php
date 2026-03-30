<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ProjetResource extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
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
        ];
    }
}
