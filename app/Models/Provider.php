<?php

namespace App\Models;

use App\Traits\searchTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Provider extends Model
{
    use HasFactory;
    use searchTrait;

    protected $fillable = [
        'name',
        'logo',
        'address',
        'description',
    ];

    protected $hidden = ['created_at','updated_at','deleted_at'];

    public function article(): BelongsTo
    {
        return $this->belongsTo(Article::class, 'provider_id');
    }
}
