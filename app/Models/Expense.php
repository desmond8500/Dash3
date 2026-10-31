<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    protected $fillable = [
        'expense_space_id',
        'user_id',
        'article_id',
        'brand_id',
        'provider_id',
        'category_id',
        'paid_by',
        'amount',
        'description',
        'expense_date',
        'payment_method',
        'expense_type',
        'notes',
    ];
}
