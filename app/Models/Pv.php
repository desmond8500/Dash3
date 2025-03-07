<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pv extends Model
{
    use HasFactory;
    protected $fillable = [
        'invoice_id',
        'title',
        'subtitle',
        'date',
        'client',
        'client_logo',
        'bct',
        'bct_logo',
        'mo',
        'mo_logo',
        'me',
        'me_logo',
        'projet',
        'projet_description',
    ];


    public function systemes(): HasMany
    {
        return $this->hasMany(Systeme::class);
    }
    // public function intervenant(): HasMany
    // {
    //     return $this->hasMany(Systeme::class);
    // }
    // public function presents(): HasMany
    // {
    //     return $this->hasMany(Systeme::class);
    // }
}
