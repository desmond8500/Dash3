<?php

namespace Database\Factories;

use App\Models\InvoiceSection;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\InvoiceSection>
 */
class InvoiceSectionFactory extends Factory
{
    protected $model = InvoiceSection::class;

    public function definition(): array
    {
        return [
            'section' => $this->faker->word(),
            'ordre' => 1,
        ];
    }
}
