<?php

namespace App\Repositories;

use App\Models\Projet_Projet;
use App\Repositories\BaseRepository;

/**
 * Class Projet_ProjetRepository
 * @package App\Repositories
 * @version September 4, 2020, 10:09 pm GMT
*/

class Projet_ProjetRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
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
     * Return searchable fields
     *
     * @return array
     */
    public function getFieldsSearchable()
    {
        return $this->fieldSearchable;
    }

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Projet_Projet::class;
    }
}
