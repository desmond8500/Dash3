<?php

namespace App\Models;

use App\Traits\searchTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\Storage;
use Spatie\Tags\HasTags;

class Article extends Model
{
    use HasFactory;
    use searchTrait;
    use HasTags;

    protected $fillable = [
        'designation',
        'image',
        'reference',
        'description',
        'quantity',
        'quantity_min',
        'priority_id',
        'brand_id',
        'provider_id',
        'price',
        'spec',
    ];

    protected $hidden = [
        'quantity',
        'quantity_min',
        'brand_id',
        'provider_id',
        'created_at',
        'updated_at',
        'deleted_at'];

    public function provider(): HasOne
    {
        return $this->hasOne(Provider::class,'id','provider_id');
    }

    public function brand(): HasOne
    {
        return $this->hasOne(Brand::class, 'id', 'brand_id');
    }

    public function images()
    {
        $dir = "stock/articles/$this->id/images";

        return Storage::disk('public')->allFiles($dir);
    }

    public function priority()
    {
        if($this->priority_id == 0){
            return "Centrale 1";
        }
        if($this->priority_id == 1){
            return "Centrale 2";
        }
        if($this->priority_id == 2){
            return "Organe 1";
        }
        if($this->priority_id == 3){
            return "Organe 2";
        }
        if($this->priority_id == 4){
            return "Organe 3";
        }
        if($this->priority_id == 5){
            return "Cable";
        }
        if($this->priority_id == 6){
            return "Accessoires";
        }
        if($this->priority_id == 7){
            return "Forfait";
        }
    }

    public function links(): HasMany
    {
        return $this->hasMany(ArticleLink::class);
    }

    public function achat_row(): HasOne
    {
        return $this->hasOne(AchatRow::class);
    }
}
