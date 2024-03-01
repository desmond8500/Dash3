<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\Storage;

class Article extends Model
{
    use HasFactory;

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
    ];

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
        // $dir = "public/stock/articles";

        // return $dir;
        return Storage::disk('public')->allFiles($dir);
        // return Storage::directories($dir);
        // return Storage::disk('public')->files($dir);
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
}
