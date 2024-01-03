<?php

namespace Database\Factories;

use App\Models\Client;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Client>
 */
class ClientFactory extends Factory
{
    protected $model = Client::class;

    public function definition(): array
    {
        $array = array("Entreprise", "Particulier");
        $type =  $array[array_rand($array, 1)];

        return [
            'name' => $this->faker->company(),
            'type' => $type,
            'address' => $this->faker->address(),
            'description' => $this->faker->text($maxNbChars = 100),
        ];
    }
}
