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
        $avatar = 'https://picsum.photos/200/300';

        return [
            'name' => $type == "Entreprise" ? $this->faker->company() : $this->faker->name(),
            'type' => $type,
            'address' => $this->faker->address(),
            'description' => $this->faker->text($maxNbChars = 100),
            // 'avatar' => $this->faker->imageUrl(200,200),
            'avatar' => $avatar,
        ];
    }
}
