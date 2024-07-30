<?php

namespace Database\Factories;

use App\Http\Controllers\DashController;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    protected $model = User::class;

    public function definition(): array
    {
        $id = random_int(0, 99);
        $image = random_int(0, 99);
        return [
            'firstname' => $this->faker->firstName,
            'lastname' => $this->faker->lastName,
            'email' => $this->faker->email,
            'email_verified_at' => now(),
            'password' => Hash::make('passer1234'), // password
            'remember_token' => Str::random(10),
            'avatar' =>  DashController::store_url_image("https://avatar.iran.liara.run/public/$id", "demo/stock/$image/avatar"),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
