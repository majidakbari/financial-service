<?php

namespace App\Http\Services\Transaction;

use App\Entities\Transaction;
use App\Repositories\TransactionRepository;

class StoreTransactionService
{
    private TransactionRepository $transactionRepository;

    public function __construct(TransactionRepository $transactionRepository)
    {
        $this->transactionRepository = $transactionRepository;
    }


    public function __invoke(
        int $sourceWallet,
        int $destinationWallet,
        float $amount,
        int $type,
        ?string $description = null
    ): Transaction {
        return $this->transactionRepository->create([
            'source_wallet_id' => $sourceWallet,
            'destination_wallet_id' => $destinationWallet,
            'amount' => $amount,
            'description' => $description,
            'type' => $type
        ]);
    }
}
