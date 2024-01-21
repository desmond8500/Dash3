<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Client;
use App\Models\Invoice;
use App\Models\Projet;
use App\Models\TaskPriority;
use App\Models\TaskStatus;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->count(1)->create();
        Client::factory()
        ->count(50)
        ->has(Projet::factory()->count(30))
        ->create();

        // Tasks
        TaskStatus::create([ 'name' => "Nouveau", 'level' => 1 ]);
        TaskStatus::create([ 'name' => "En cours", 'level' => 2 ]);
        TaskStatus::create([ 'name' => "En Pause", 'level' => 3 ]);
        TaskStatus::create([ 'name' => "Terminé", 'level' => 4 ]);

        TaskPriority::create([ 'name' => "Basse", 'level' => 1 ]);
        TaskPriority::create([ 'name' => "Moyenne", 'level' => 2 ]);
        TaskPriority::create([ 'name' => "Haute", 'level' => 3 ]);


        // Projet::factory()->count(30)->create();
        Invoice::factory()->count(50)->create();
    }
}
