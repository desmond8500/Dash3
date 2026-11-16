<?php

use Illuminate\Database\Migrations\Migration;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

/**
 * Rôle « technicien » : il n'a que la permission « tech », qui ouvre
 * uniquement les routes /api/v1/tech/* (pas l'ERP, le stock ni les devis).
 */
return new class extends Migration
{
    public function up(): void
    {
        app(PermissionRegistrar::class)->forgetCachedPermissions();

        $permission = Permission::firstOrCreate(['name' => 'tech', 'guard_name' => 'web']);
        $role = Role::firstOrCreate(['name' => 'technicien', 'guard_name' => 'web']);
        $role->givePermissionTo($permission);
    }

    public function down(): void
    {
        app(PermissionRegistrar::class)->forgetCachedPermissions();

        Role::where('name', 'technicien')->where('guard_name', 'web')->delete();
        Permission::where('name', 'tech')->where('guard_name', 'web')->delete();
    }
};
