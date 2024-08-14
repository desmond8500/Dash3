<?php

namespace Database\Factories;

use App\Http\Controllers\ErpController;
use App\Models\Invoice;
use App\Models\InvoiceRow;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\InvoiceRow>
 */
class InvoiceRowFactory extends Factory
{
    protected $model = InvoiceRow::class;

    public function definition(): array
    {
        $designation = $this->faker->numberBetween($min = 5, $max = 10);
        $reference = $this->faker->numberBetween($min = 5, $max = 10);
        return [
            'designation' => $this->faker->text($designation),
            'coef' => 1,
            'reference' => $this->faker->text($reference),
            'quantite'=> $this->faker->numberBetween($min = 1, $max = 30),
            'priorite_id'=>1,
            'prix'=> $this->faker->numberBetween($min = 1000, $max = 9000),
        ];
    }
}
