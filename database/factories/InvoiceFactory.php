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
        $name = $this->faker->lexify('???');
        $number = $this->faker->numberBetween(1,200);
        $reference = $this->faker->numberBetween($min = 5, $max = 10);

        return [
            'reference' => "$name-$number-24",
            'description' => $this->faker->text($reference),
            'modalite' => '',
            'note' => '',
            'statut' => ErpController::getRandomStatus(),
            'tax' => 0,
            'remise' => 0,
        ];
    }
}
