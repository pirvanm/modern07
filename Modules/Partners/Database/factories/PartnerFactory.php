<?php

namespace Modules\Partners\Database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Partners\Entities\Partner;

class PartnerFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Partner::class;

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
