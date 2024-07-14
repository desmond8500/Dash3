<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Journal>
 */
class JournalFactory extends Factory
{

    public function definition(): array
    {
        $type = array(
            "Rapport de visite",
            "Rapport de d'intervention",
            "Proposition technique",
            "Visite de chantier",
        );
        $type =  $type[array_rand($type, 1)];

        return [
            'user_id' => 1,
            'title' => $this->faker->sentence(4,true),
            'date' => $this->faker->date(),
            'description' => $this->faker->text(),
            'type' => $type,
        ];
    }
}
