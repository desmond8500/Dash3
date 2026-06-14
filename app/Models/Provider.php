<?php

namespace App\Models;

use App\Traits\searchTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Provider extends Model
{
    use HasFactory;
    use searchTrait;

    /**
     * @OA\Schema(
     *     schema="Fournisseur",
     *     title="Fournisseur",
     *     description="Modèle d'un fournisseur",
     *     @OA\Property(
     *         property="name",
     *         type="string",
     *         example=""
     *     ),
     *     @OA\Property(
     *         property="logo",
     *         type="string",
     *         example=""
     *     ),
     *     @OA\Property(
     *         property="address",
     *         type="string",
     *         example="avenue 12"
     *     ),
     *     @OA\Property(
     *         property="description",
     *         type="string",
     *         example="Installation complète du projet"
     *     ),
     *     @OA\Property(
     *         property="email",
     *         type="string",
     *         example="email@mail.com"
     *     ),
     *     @OA\Property(
     *         property="phone",
     *         type="string",
     *         example="777589564"
     *     ),
     *     @OA\Property(
     *         property="webside",
     *         type="string",
     *         example="www.site.com
     *     ),
     * )
     */

    protected $fillable = [
        'name',
        'logo',
        'address',
        'description',
        'email',
        'phone',
        'website'
    ];

    protected $hidden = ['created_at','updated_at','deleted_at'];

    public function article(): HasMany
    {
        return $this->hasMany(Article::class);
    }
}
