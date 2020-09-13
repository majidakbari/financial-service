<?php

namespace App\Repositories;

use App\Entities\Wallet;
use App\Repositories\Common\BaseRepository;
use Illuminate\Support\Facades\DB;

class WalletRepository extends BaseRepository
{
    protected function model(): string
    {
        return Wallet::class;
    }

    public function changeBalance(int $int, float $balance): void
    {
        $this->query()->where('id', $int)->update(['balance' => DB::raw("balance + $balance")]);
    }
}
