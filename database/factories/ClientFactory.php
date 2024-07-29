<?php

namespace Database\Factories;

use App\Http\Controllers\DashController;
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
        $id = random_int(0, 99);
        $image = random_int(0, 99);

        return [
            'name' => $type == "Entreprise" ? $this->faker->company() : $this->faker->name(),
            'type' => $type,
            'address' => $this->faker->address(),
            'description' => $this->faker->text(),
            // 'avatar' => $this->faker->imageUrl(200,200),
            'avatar' =>  DashController::store_url_image("https://avatar.iran.liara.run/public/$id", "demo/stock/$image/avatar"),
        ];
    }
}
