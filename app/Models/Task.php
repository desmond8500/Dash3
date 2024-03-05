<?php

namespace App\Models;

use App\Traits\searchTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Task extends Model
{
    use HasFactory;
    use searchTrait;

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
        'favoris',
    ];


    public function scopeActive($query, $search)
    {
        return $query->where('statut_id', '!=' , 4)->search($search)->orderBy('priotity_id');
    }

    public function scopeFinished($query, $search)
    {
        return $query->where('statut_id', 4)->search($search)->orderBy('priotity_id');
    }

    public function scopeActiveCount($query)
    {
        return $query->where('statut_id', '!=', 4)->orderBy('priotity_id')->count();
    }

    public function scopeInactiveCount($query)
    {
        return $query->where('statut_id', 4)->orderBy('priotity_id')->count();
    }

    public function priority(): HasOne
    {
        return $this->hasOne(TaskPriority::class, 'id', 'priority_id');
    }

    public function statut(): HasOne
    {
        return $this->hasOne(TaskStatus::class, 'id', 'statut_id');
    }

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

    public function devis(): BelongsTo{
        return $this->belongsTo(Invoice::class, 'devis_id');
    }
}
