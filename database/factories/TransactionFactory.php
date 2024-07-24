<?php

namespace Database\Factories;

use App\Models\Transaction;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Transaction>
 */
class TransactionFactory extends Factory
{
    protected $model = Transaction::class;

    public function definition(): array
    {
        return [
            'objet' => $this->faker->text($this->faker->numberBetween(5,20)),
            'type' => $this->faker->randomElement(array('credit', 'debit')),
            'montant' => $this->faker->numberBetween(1000, 9000),
            'description' => $this->faker->text(20),
            'date' => $this->faker->date(),
        ];
    }
}
