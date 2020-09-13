<?php

namespace Database\Factories\Entities;

use App\Entities\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
        ];
    }

    public function company()
    {
        return $this->state([
            'name' => config('logic.company_name'),
            'email' => config('logic.company_email')
        ]);
    }
}
