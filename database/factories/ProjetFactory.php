<?php

namespace Database\Factories;

use App\Models\Projet;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Projet>
 */
class ProjetFactory extends Factory
{
    protected $model = Projet::class;

    public function definition(): array
    {
        return [
            'client_id' => rand(1, 50),
            'name' => $this->faker->company(),
            'description' => $this->faker->text($maxNbChars = 100),
        ];
    }
}
