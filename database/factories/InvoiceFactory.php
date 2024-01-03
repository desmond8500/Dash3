<?php

namespace Database\Factories;

use App\Http\Controllers\ErpController;
use App\Models\Invoice;
use App\Models\Projet;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Invoice>
 */
class InvoiceFactory extends Factory
{
    protected $model = Invoice::class;

    public function definition(): array
    {
        $projet_id = random_int(1, 30);
        $projet = Projet::find($projet_id);

        return [
            'projet_id' => $projet->id,
            'client_name' => $projet->client->name,
            'projet_name' => $projet->name,
            'reference' => ErpController::getInvoiceReference($projet),
            'description' => $this->faker->text($maxNbChars = 100),
            'modalite' => '',
            'note' => '',
            'statut' => ErpController::getRandomStatus(),
            'tax' => 0,
            'remise' => 0,
        ];
    }
}
