<?php

namespace Database\Factories;

use App\Models\Company;
use App\Models\Employee;
use App\Models\Position;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

class EmployeeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Employee::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'fathers_name' => $this->faker->lastName,
            'position_id' => Position::all()->random()->id,
            'company_id' => Company::get()?->random()->id,
            'login' => $this->faker->unique()->word,
            'password' => Hash::make('123456'),
            'phone' => '998' . $this->faker->numberBetween('100000000', '999999999'),
            'address' => $this->faker->address,
            'passport' => $this->faker->randomElement(['AA', 'AB', 'AC']) .
                $this->faker->unique()->numberBetween('1000000', '9999999'),
        ];
    }
}
