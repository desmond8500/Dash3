<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MyprojectTransaction extends Model
{

    protected $fillable = [
        'myproject_id',
        'amount',
        'transaction_date',
        'description',
        'type',
        'status',
    ];
}
