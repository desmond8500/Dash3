<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjetNote extends Model
{
    use HasFactory;

    /**
     * @OA\Schema(
     *     schema="Notes de projet",
     *     title="Notes de projet",
     *     description="Modèle d'une tâche",
     *     @OA\Property(
     *         property="id",
     *         type="integer",
     *         example=1
     *     ),
     *     @OA\Property(
     *         property="projet_id",
     *         type="integer",
     *         example=1
     *     ),
     *     @OA\Property(
     *         property="titre",
     *         type="string",
     *         example="Installer Laravel"
     *     ),
     *     @OA\Property(
     *         property="description",
     *         type="string",
     *         example="Installation complète du projet"
     *     ),
     * )
     */

    protected $fillable = [
        'projet_id',
        'titre',
        'description',
    ];

    public function projet()
    {
        return $this->belongsTo(Projet::class);
    }
}
