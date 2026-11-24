<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $ma = Role::create(['name' => 'Mitarbeiter:in']);
        $autor = Role::create(['name' => 'Autor:in']);
        $red = Role::create(['name' => 'Redakteur:in']);
        $admin = Role::create(['name' => 'Admin']);

        // Channels / Veröffentlichungskanäle
        $p = Permission::create(['name' => 'see publications']);
        $ma->givePermissionTo($p);
        $autor->givePermissionTo($p);
        $red->givePermissionTo($p);
        $admin->givePermissionTo($p);
        $p = Permission::create(['name' => 'create publications']);
        $autor->givePermissionTo($p);
        $red->givePermissionTo($p);
        $admin->givePermissionTo($p);
        $p = Permission::create(['name' => 'delete publications']);
        $red->givePermissionTo($p);
        $admin->givePermissionTo($p);
        $p = Permission::create(['name' => 'edit publications']);
        $red->givePermissionTo($p);
        $admin->givePermissionTo($p);
        $p = Permission::create(['name' => 'restore publications']);
        $admin->givePermissionTo($p);

        // Personen
        $p = Permission::create(['name' => 'see persons']);
        $ma->givePermissionTo($p);
        $autor->givePermissionTo($p);
        $red->givePermissionTo($p);
        $admin->givePermissionTo($p);
        $p = Permission::create(['name' => 'create persons']);
        $autor->givePermissionTo($p);
        $red->givePermissionTo($p);
        $admin->givePermissionTo($p);
        $p = Permission::create(['name' => 'delete persons']);
        $red->givePermissionTo($p);
        $admin->givePermissionTo($p);
        $p = Permission::create(['name' => 'edit persons']);
        $red->givePermissionTo($p);
        $admin->givePermissionTo($p);
        $p = Permission::create(['name' => 'restore persons']);
        $admin->givePermissionTo($p);

        //Tags
        $p = Permission::create(['name' => 'see tags']);
        $ma->givePermissionTo($p);
        $autor->givePermissionTo($p);
        $red->givePermissionTo($p);
        $admin->givePermissionTo($p);
        $p = Permission::create(['name' => 'create tags']);
        $autor->givePermissionTo($p);
        $red->givePermissionTo($p);
        $admin->givePermissionTo($p);
        $p = Permission::create(['name' => 'delete tags']);
        $red->givePermissionTo($p);
        $admin->givePermissionTo($p);
        $p = Permission::create(['name' => 'edit tags']);
        $red->givePermissionTo($p);
        $admin->givePermissionTo($p);
        $p = Permission::create(['name' => 'restore tags']);
        $admin->givePermissionTo($p);

        //Alben
        $p = Permission::create(['name' => 'see albums']);
        $ma->givePermissionTo($p);
        $autor->givePermissionTo($p);
        $red->givePermissionTo($p);
        $admin->givePermissionTo($p);
        $p = Permission::create(['name' => 'create albums']);
        $autor->givePermissionTo($p);
        $red->givePermissionTo($p);
        $admin->givePermissionTo($p);
        $p = Permission::create(['name' => 'delete albums']);
        $red->givePermissionTo($p);
        $admin->givePermissionTo($p);
        $p = Permission::create(['name' => 'edit albums']);
        $red->givePermissionTo($p);
        $admin->givePermissionTo($p);
        $p = Permission::create(['name' => 'restore albums']);
        $admin->givePermissionTo($p);

        //Bilder / Dateien
        $p = Permission::create(['name' => 'see files']);
        $ma->givePermissionTo($p);
        $autor->givePermissionTo($p);
        $red->givePermissionTo($p);
        $admin->givePermissionTo($p);
        $p = Permission::create(['name' => 'create files']);
        $autor->givePermissionTo($p);
        $red->givePermissionTo($p);
        $admin->givePermissionTo($p);
        $p = Permission::create(['name' => 'delete files']);
        $red->givePermissionTo($p);
        $admin->givePermissionTo($p);
        $p = Permission::create(['name' => 'edit files']);
        $red->givePermissionTo($p);
        $admin->givePermissionTo($p);
        $p = Permission::create(['name' => 'restore files']);
        $admin->givePermissionTo($p);

        // User
        $p = Permission::create(['name' => 'edit users']);
        $admin->givePermissionTo($p);
    }
}
