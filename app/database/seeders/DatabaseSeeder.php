<?php

namespace Database\Seeders;

use App\Entities\User;
use App\Entities\Wallet;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        if (User::query()->where('email', config('logic.company_email'))->doesntExist()) {
            Wallet::factory()->company()->create();
        }
        Wallet::factory(10)->create();
    }
}
