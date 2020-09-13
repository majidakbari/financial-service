<?php

namespace App\Repositories;

use App\Entities\Transaction;
use App\Repositories\Common\BaseRepository;

class TransactionRepository extends BaseRepository
{
    protected array $fillable = ['source_wallet_id', 'destination_wallet_id', 'amount', 'description', 'type'];

    protected function model(): string
    {
        return Transaction::class;
    }
}
