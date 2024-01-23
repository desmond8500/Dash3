<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'projet_id',
        'devis_id',
        'building_id',
        'stage_id',
        'room_id',
        'name',
        'description',
        'priority_id',
        'statut_id',
        'expiration_date',
    ];

    public function client(): BelongsTo{
        return $this->belongsTo(Client::class);
    }
    public function projet(): BelongsTo{
        return $this->belongsTo(Projet::class);
    }
    public function buiding(): BelongsTo{
        return $this->belongsTo(Building::class);
    }
    public function stage(): BelongsTo{
        return $this->belongsTo(Stage::class);
    }
    public function room(): BelongsTo{
        return $this->belongsTo(Room::class);
    }
}
