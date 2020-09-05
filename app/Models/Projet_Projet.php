<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Projet_Projet
 * @package App\Models
 * @version September 4, 2020, 10:09 pm GMT
 *
 * @property \App\Models\Projet_client $projetClient
 * @property string $client_id
 * @property string $name
 * @property string $description
 * @property string $categorie
 * @property string $statut
 * @property string $start
 * @property string $end
 * @property string $contact_id
 * @property string $responsable_id
 */
class Projet_Projet extends Model
{
    use SoftDeletes;

    public $table = 'projet__projets';
    

    protected $dates = ['deleted_at'];



    public $fillable = [
        'client_id',
        'name',
        'description',
        'categorie',
        'statut',
        'start',
        'end',
        'contact_id',
        'responsable_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'client_id' => 'string',
        'name' => 'string',
        'description' => 'string',
        'categorie' => 'string',
        'statut' => 'string',
        'start' => 'string',
        'end' => 'string',
        'contact_id' => 'string',
        'responsable_id' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     **/
    public function projetClient()
    {
        return $this->hasOne(\App\Models\Projet_client::class, 'id', 'client_id');
    }
}
