<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Achat extends Model
{
    use HasFactory;

    protected $fillable = [
        'provider_id',
        'name',
        'description',
        'date'
    ];

    public function rows(): HasMany
    {
        return $this->hasMany(AchatRow::class);
    }
    public function total()
    {
        $total = 0;
        foreach ($this->rows as $key => $row) {
            $total+= $row->prix*$row->quantite;
        }

        return $total;
    }

    public function tva()
    {
        $total = 0;
        foreach ($this->rows as $key => $row) {
            $total+= $row->prix*$row->tva*$row->quantite;
        }

        return $total;
    }

    public function ttc()
    {
        $total = 0;
        foreach ($this->rows as $key => $row) {
            $total+= ($row->prix + $row->prix*$row->tva)*$row->quantite;
        }

        return $total;
    }
}
