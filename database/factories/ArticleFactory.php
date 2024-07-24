<?php

namespace Database\Factories;

use App\Models\Article;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Article>
 */
class ArticleFactory extends Factory
{

    protected $model = Article::class;

    public function definition(): array
    {

        return [
            'designation' => $this->faker->text(5),
            'image' => 'https://avatar.iran.liara.run/public/boy',
            'reference' => $this->faker->text(5),
            'description' => $this->faker->text(12),
            'quantity' => $this->faker->numberBetween(1,20),
            'quantity_min' => $this->faker->numberBetween(1,20),
            'priority_id' => $this->faker->numberBetween(1,6),
            'brand_id' => $this->faker->numberBetween(1, 25),
            'provider_id' => $this->faker->numberBetween(1, 25),
            'price' => $this->faker->numberBetween(1000, 9000),
        ];
    }
}
