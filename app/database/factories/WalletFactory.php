<?php

namespace Database\Factories\Entities;

use App\Entities\User;
use App\Entities\Wallet;
use Illuminate\Database\Eloquent\Factories\Factory;

class WalletFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Wallet::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->randomElement(['Primary', 'Secondary']),
            'balance' => $this->faker->randomFloat(2, 1000, 10000),
            'is_active' => true,
            'user_id' => User::factory()
        ];
    }

    public function company()
    {
        return $this->state([
            'name' => config('logic.company_wallet_name'),
            'balance' => 0,
            'is_active' => true,
            'user_id' => User::factory()->company()
        ]);
    }

    public function inactive()
    {
        return $this->state([
            'is_active' => false,
        ]);
    }
}
