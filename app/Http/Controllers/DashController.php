<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Brand;
use App\Models\Building;
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
        DashController::init_admin();
        DashController::initRoles();
        DashController::init_task_status();
        DashController::init_task_priority();
    }

    public static function init_admin(){
        $users = User::count();
        if (!$users) {
            $admin = User::create([
                'firstname' => 'Admin',
                'lastname' => 'Admin',
                'email' => 'admin@admin.com',
                'password' => Hash::make('passer1234'),
            ]);
            $admin->assignRole('admin');
            $admin->avatar = DashController::store_url_image('https://avatar.iran.liara.run/public', "test/user/$admin->id/avatar");
            $admin->save();
        }

    }
    public static function initUser(){

        User::factory(10)->create();
    }

    static function store_url_image($url, $dir)
    {
        if ($dir) {
            $dir = "test/avatar";
        }
        $contents = file_get_contents($url);
        $name = substr($url, strrpos($url, '/') + 1);
        Storage::disk('public')->put("$dir/$name", $contents);

        return "storage/$dir/$name";
    }

    public static  function initRoles(){
        $admin_role = Role::create(['name'=>'admin']);
        $user_role = Role::create(['name'=>'user']);

        Permission::create(['name'=>'erp']);
        Permission::create(['name'=>'clients']);
        Permission::create(['name'=>'stock']);
        Permission::create(['name'=>'journaux']);
        Permission::create(['name'=>'contacts']);
        Permission::create(['name'=>'finances']);
        Permission::create(['name'=>'settings']);
        Permission::create(['name'=>'medias']);
        Permission::create(['name'=>'test']);

        $admin_role->givePermissionTo(['erp','clients','stock','journaux','contacts','finances','settings','medias','test']);
        $user_role->givePermissionTo(['clients','stock']);
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
                ->has(Building::factory(1))
            )->create();
    }

    static function init_projets(){

    }

    static function get_fiche_types(){
        return (object) array(
            (object) array( 'name' => 'Fiche Extinction Rp1r-Supra', 'route'=>'supra_pdf' ),
            (object) array( 'name' => 'Fiche Incendie Teletek', 'route'=>'teletek_ssi_pdf' ),
        );
    }
}
