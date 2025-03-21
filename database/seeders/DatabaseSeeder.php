<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Http\Controllers\DashController;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        DashController::initRoles();
        DashController::init_admin();
        DashController::initUser();
        DashController::init_task_status();
        DashController::init_task_priority();
        DashController::init_transaction();
        DashController::init_stock();
        DashController::init_team();

        // Clients
        DashController::init_clients();
    }
}
