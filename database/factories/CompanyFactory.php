<?php

namespace Database\Factories;

use App\Models\Admin;
use App\Models\Company;
use App\Models\Employee;
use App\Models\Position;
use Exception;
use Illuminate\Database\Eloquent\Factories\Factory;

class CompanyFactory extends Factory
{
    protected $model = Company::class;

    /**
     * @throws Exception
     */
    public function configure()
    {
        return $this->afterCreating(static function (Company $company) {
            $company->chief->company_id = $company->id;
            $company->chief->position_id = Position::query()->where('name', "Директор")->first()->id;
            $company->chief->save();
        });
    }

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->unique()->company(),
            'email' => $this->faker->unique()->companyEmail(),
            'site' => $this->faker->url,
            'chief_id' => Employee::all()?->random()->id,
            'creator_id' => Admin::all()->random()->id,
            'phone' => '998' . $this->faker->numberBetween('100000000', '999999999'),
            'address' => $this->faker->address,
        ];
    }
}
