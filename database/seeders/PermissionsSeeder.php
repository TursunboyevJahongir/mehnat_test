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
        $superadmin = Role::create(['guard_name' => 'admin-api', 'name' => 'superadmin']);
        $admin = Role::create(['guard_name' => 'admin-api', 'name' => 'admin']);

        Permission::create(['guard_name' => 'admin-api', 'name' => 'read company']);
        Permission::create(['guard_name' => 'admin-api', 'name' => 'create company']);
        Permission::create(['guard_name' => 'admin-api', 'name' => 'update company']);
        Permission::create(['guard_name' => 'admin-api', 'name' => 'delete company']);

        Permission::create(['guard_name' => 'admin-api', 'name' => 'read employee']);
        Permission::create(['guard_name' => 'admin-api', 'name' => 'create employee']);
        Permission::create(['guard_name' => 'admin-api', 'name' => 'update employee']);
        Permission::create(['guard_name' => 'admin-api', 'name' => 'delete employee']);

        Permission::create(['guard_name' => 'admin-api', 'name' => 'read admin']);
        Permission::create(['guard_name' => 'admin-api', 'name' => 'create admin']);
        Permission::create(['guard_name' => 'admin-api', 'name' => 'update admin']);
        Permission::create(['guard_name' => 'admin-api', 'name' => 'delete admin']);

        Permission::create(['guard_name' => 'admin-api', 'name' => 'read position']);
        Permission::create(['guard_name' => 'admin-api', 'name' => 'create position']);
        Permission::create(['guard_name' => 'admin-api', 'name' => 'update position']);
        Permission::create(['guard_name' => 'admin-api', 'name' => 'delete position']);

        $admin->syncPermissions(Permission::all());

        Permission::create(['guard_name' => 'admin-api', 'name' => 'read role']);
        Permission::create(['guard_name' => 'admin-api', 'name' => 'create role']);
        Permission::create(['guard_name' => 'admin-api', 'name' => 'update role']);
        Permission::create(['guard_name' => 'admin-api', 'name' => 'delete role']);
        $superadmin->syncPermissions(Permission::all());//ikkisining farqi kimgadir admin huquqi berilsa u bosh adminni o'chirolmasligi uchun

        $first = Admin::first();

        $first->assignRole($superadmin);
        $first->save();
    }
}
