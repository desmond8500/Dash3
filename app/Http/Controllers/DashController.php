<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class DashController extends Controller
{

    public static  function initUser(){
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
        Permission::create(['name'=>'erp']);
        Permission::create(['name'=>'erp']);
        Permission::create(['name'=>'contacts']);
    }
}
