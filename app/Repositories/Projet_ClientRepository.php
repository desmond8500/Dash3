<?php

namespace App\Repositories;

use App\Models\Projet_Client;
use App\Repositories\BaseRepository;

/**
 * Class Projet_ClientRepository
 * @package App\Repositories
 * @version September 4, 2020, 2:58 pm GMT
*/

class Projet_ClientRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'description',
        'adress',
        'logo'
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
        return Projet_Client::class;
    }
}
