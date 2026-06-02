<?php

namespace App\Http\Resources;

use App\Models\Building;
use App\Models\Client;
use App\Models\Invoice;
use App\Models\Journal;
use App\Models\Projet;
use App\Models\Room;
use App\Models\Stage;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TaskResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'client_id' => $this->client_id,
            'client' => Client::find($this->client_id),
            'projet_id' => $this->projet_id,
            'projet' => Projet::find($this->projet_id),
            'devis_id' => $this->devis_id,
            'devis' => Invoice::find($this->devis_id),
            'building_id' => $this->building_id,
            'building' => Building::find($this->building_id),
            'stage_id' => $this->stage_id,
            'stage' => Stage::find($this->stage_id),
            'room_id' => $this->room_id,
            'room' => Room::find($this->room_id),
            'journal_id' => $this->journal_id,
            'journal' => Journal::find($this->journal_id),

            'name' => $this->name,
            'description' => $this->description,

            'priority_id' => $this->priority_id,
            'statut_id' => $this->statut_id,

            'expiration_date' => $this->expiration_date,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'favoris' => $this->favoris,
        ];
    }
}
