<?php

namespace Database\Seeders;

use App\Models\Position;
use Illuminate\Database\Seeder;

class PositionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Position::create(['name' => 'Директор']);
        Position::create(['name' => 'Руководитель']);
        Position::create(['name' => 'Старший специалист']);
        Position::create(['name' => 'Специалист']);
        Position::create(['name' => 'Специалист по программированию']);
        Position::create(['name' => 'Оператор']);
        Position::create(['name' => 'Водитель']);
    }
}
