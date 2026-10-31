<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExpenseSpaceUser extends Model
{
    protected $fillable = [
        'user_id',
        'expense_space_id',
        'role',
    ];
}
