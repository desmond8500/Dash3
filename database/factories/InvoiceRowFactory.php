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
        $invoice_id = rand(1, 50);
        $invoice = Invoice::find($invoice_id);

        return [
            'invoice_id' => $invoice->id,
            'designation' => $this->faker->word(),
            'coef' => 1,
            'reference' => $this->faker->word(),
            'quantite'=>1,
            'priorite'=>1,
            'prix'=> $this->faker->numberBetween($min = 1000, $max = 9000),
        ];
    }
}
