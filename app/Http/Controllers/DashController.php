<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Brand;
use App\Models\Client;
use App\Models\Invoice;
use App\Models\InvoiceRow;
use App\Models\InvoiceSection;
use App\Models\Journal;
use App\Models\Projet;
use App\Models\Provider;
use App\Models\Task;
use App\Models\TaskPriority;
use App\Models\TaskStatus;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class DashController extends Controller
{
    static function init_app(){
        User::create([
            'firstname' => 'Admin',
            'lastname' => 'Admin',
            'email' => 'admin@admin.com',
            'password' => Hash::make('passer1234'),
        ]);

        $url = "http://www.google.co.in/intl/en_com/images/srpr/logo1w.png";
        $contents = file_get_contents($url);
        $name = substr($url, strrpos($url, '/') + 1);
        Storage::put($name, $contents);

        DashController::initRoles();
        DashController::init_task_status();
        DashController::init_task_priority();
    }

    public static function initUser(){
        User::create([
            'firstname' => 'Admin',
            'lastname' => 'Admin',
            'email' => 'admin@admin.com',
            'password' => Hash::make('passer1234'),
        ]);
    }

    public static  function initRoles(){
        Role::create(['name'=>'admin']);
        Role::create(['name'=>'user']);

        Permission::create(['name'=>'erp']);
        Permission::create(['name'=>'stock']);
        Permission::create(['name'=>'contacts']);
        Permission::create(['name'=>'finances']);
    }

    static function init_task_status(){
        TaskStatus::create(['name' => "Nouveau", 'level' => 1]);
        TaskStatus::create(['name' => "En cours", 'level' => 2]);
        TaskStatus::create(['name' => "En Pause", 'level' => 3]);
        TaskStatus::create(['name' => "Terminé", 'level' => 4]);
        TaskStatus::create(['name' => "Cloturé", 'level' => 5]);
    }

    static function init_task_priority(){
        TaskPriority::create(['name' => "Basse", 'level' => 1]);
        TaskPriority::create(['name' => "Moyenne", 'level' => 2]);
        TaskPriority::create(['name' => "Haute", 'level' => 3]);
    }

    static function init_transaction(){
        Transaction::factory(25)->create();
    }

    static function init_stock(){
        Provider::factory(25)->create();
        Brand::factory(25)->create();
        Article::factory(25)->create();
    }

    static function init_clients(){
        Client::factory(24)
            ->has(Projet::factory(5)
                ->has(Task::factory(3))
                ->has(Journal::factory(3))
                ->has(Invoice::factory(3)
                    ->has(InvoiceSection::factory(2)
                    ->has(InvoiceRow::factory(5))))
            )->create();
    }

    static function init_projets(){

    }
}
