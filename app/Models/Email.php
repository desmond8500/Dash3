<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Email extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'contact_id',
        'team_id',
        'provider_id',
        'email',
    ];

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }
    public function contact(): BelongsTo
    {
        return $this->belongsTo(Contact::class);
    }
    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }
    public function provider(): BelongsTo
    {
        return $this->belongsTo(Provider::class);
    }
}
