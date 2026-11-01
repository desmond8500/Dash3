<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class ExpenseSpace extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'type',
        'currency',
    ];


    public function userlist(){
        return $this->hasManyThrough(User::class, ExpenseSpaceUser::class, 'expense_space_id', 'id', 'id', 'user_id');
    }


}
