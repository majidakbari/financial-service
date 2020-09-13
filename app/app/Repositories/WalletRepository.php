<?php

namespace App\Repositories;

use App\Entities\Wallet;
use App\Repositories\Common\BaseRepository;

class WalletRepository extends BaseRepository
{
    protected function model(): string
    {
        return Wallet::class;
    }
}
