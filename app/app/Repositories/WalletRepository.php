<?php

namespace App\Repositories;

use App\Entities\Wallet;
use Illuminate\Support\Facades\DB;
use App\Repositories\Common\BaseRepository;

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
