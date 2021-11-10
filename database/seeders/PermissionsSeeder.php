<?php

namespace Database\Seeders;


use App\Models\Admin;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $superadmin = Role::create(['name' => 'superadmin'],);
        $admin = Role::create(['name' => 'admin']);

        Permission::create(['name' => 'read admin']);
        Permission::create(['name' => 'create admin']);
        Permission::create(['name' => 'update admin']);
        Permission::create(['name' => 'delete admin']);

        Permission::create(['name' => 'read company']);
        Permission::create(['name' => 'create company']);
        Permission::create(['name' => 'update company']);
        Permission::create(['name' => 'delete company']);

        Permission::create(['name' => 'read employee']);
        Permission::create(['name' => 'create employee']);
        Permission::create(['name' => 'update employee']);
        Permission::create(['name' => 'delete employee']);

        $superadmin->syncPermissions(Permission::all());//ikkisining farqi kimgadir admin huquqi berilsa u bosh adminni o'chirolmasligi uchun
        $admin->syncPermissions(Permission::all());

        $first = Admin::first();

        $first->assignRole($superadmin);
        $first->save();
    }
}