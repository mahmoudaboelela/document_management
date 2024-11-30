<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Permissions
        Permission::create(['name' => 'view documents']);
        Permission::create(['name' => 'create documents']);
        Permission::create(['name' => 'edit documents']);
        Permission::create(['name' => 'delete documents']);

        $admin = Role::create(['name' => 'Admin']);
        $user = Role::create(['name' => 'User']);
        $viewer = Role::create(['name' => 'Viewer']);

        //admin has all permissions
        $admin->givePermissionTo(Permission::all());

        //user has create and edit permissions
        $user->givePermissionTo(['create documents', 'edit documents']);

        //viewer can only view documents
        $viewer->givePermissionTo('view documents');
    }
}
