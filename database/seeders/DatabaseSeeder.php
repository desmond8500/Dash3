<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Client;
use App\Models\Invoice;
use App\Models\Projet;
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

        // Projet::factory()->count(30)->create();
        Invoice::factory()->count(50)->create();
    }
}
