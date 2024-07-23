<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Transaction>
 */
class TransactionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'objet' => $this->faker->words($this->faker->numberBetween(35)),
            'type' => $this->faker->randomElements($array = array('credit', 'debit'), $count = 1),
            'montant' => $this->faker->numberBetween($min = 1000, $max = 9000),
            'description' => $this->faker->words(5),
            'date' => $this->faker->date(),
        ];
    }
}
