<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExpenseAttachements extends Model
{
    protected $fillable = [
        'name',
        'folder',
    ];
}
