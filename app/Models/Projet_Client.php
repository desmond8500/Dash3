<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Projet_Client
 * @package App\Models
 * @version September 4, 2020, 2:58 pm GMT
 *
 * @property \Illuminate\Database\Eloquent\Collection $projetProjets
 * @property string $name
 * @property string $description
 * @property string $adress
 * @property string $logo
 */
class Projet_Client extends Model
{
    use SoftDeletes;

    public $table = 'projet__clients';
    

    protected $dates = ['deleted_at'];



    public $fillable = [
        'name',
        'description',
        'adress',
        'logo'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'name' => 'string',
        'description' => 'string',
        'adress' => 'string',
        'logo' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function projetProjets()
    {
        return $this->hasMany(\App\Models\Projet_Projet::class);
    }
}
