<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class SchemaList extends Model
{
    protected $fillable = ['schema_id', 'item_id', 'name', 'parent_id', 'unit'];

    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    public function schema()
    {
        return $this->belongsTo(Schema::class);
    }

    function children()
    {
        return $this->hasMany(SchemaList::class, 'parent_id', 'item_id');
    }



}
