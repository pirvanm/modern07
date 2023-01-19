<?php

namespace Modules\Employees\Database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class EmployeeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = \Modules\Employees\Entities\Employee::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'fname' =>  fake()->firstName,
            'lname' => fake()->lastName,
            'phone' => fake()->phoneNumber(),
            'email' => fake()->email(),
            'status' => 1,
        ];
    }
}
