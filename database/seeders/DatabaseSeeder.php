<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Http\Controllers\DashController;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        DashController::init_task_status();
        DashController::init_task_priority();
        DashController::initUser();
        DashController::initRoles();

        // Clients
        DashController::init_clients();

    }
}
