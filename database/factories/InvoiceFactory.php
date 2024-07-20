<?php

namespace Database\Factories;

use App\Http\Controllers\ErpController;
use App\Models\Invoice;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Invoice>
 */
class InvoiceFactory extends Factory
{
    protected $model = Invoice::class;

    public function definition(): array
    {
        return [
            'reference' => "DSR-152-24",
            'description' => $this->faker->text($maxNbChars = 100),
            'modalite' => '',
            'note' => '',
            'statut' => ErpController::getRandomStatus(),
            'tax' => 0,
            'remise' => 0,
        ];
    }
}
