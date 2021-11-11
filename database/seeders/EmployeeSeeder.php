<?php

namespace Database\Seeders;

use App\Models\Employee;
use App\Models\Position;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Employee::create([
            'first_name' => "Yangiboyev",
            'last_name' => "Alisher",
            'fathers_name' => "Yangiboy o'g'li",
            'position_id' => Position::query()->where('name', "Сотрудники")->first()->id,
            'company_id' => null,
            'login' => "employee",
            'password' => Hash::make('123456'),
            'phone' => "998900906168",
            'address' => "chilanzor 19",
            'passport' => "AA5133512",
        ]);
    }
}
