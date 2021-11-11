<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        $this->call(AdminSeeder::class);
        $this->call(PermissionsSeeder::class);
        $this->call(PositionSeeder::class);
        $this->call(EmployeeSeeder::class);
        \App\Models\Company::factory(1)->create();
        \App\Models\Employee::factory(10)->create();
        \App\Models\Company::factory(10)->create();
        \App\Models\Employee::factory(100)->create();
    }
}
