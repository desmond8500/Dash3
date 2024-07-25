<?php

namespace App\Models;

use App\Traits\searchTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Contact extends Model
{
    use HasFactory;
    use searchTrait;

    protected $fillable = [
        'client_id',
        'projet_id',
        'firstname',
        'lastname',
        'fonction',
        'avatar',
    ];

    public function phone(): HasMany
    {
        return $this->hasMany(ContactPhone::class);
    }

    public function mail(): HasMany
    {
        return $this->hasMany(ContactMail::class);
    }
}
