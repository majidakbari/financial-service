<?php

namespace App\Http\Controllers\Transaction;

use App\Http\Resources\TransactionResource;
use App\Http\Actions\StoreTransactionAction;
use App\Http\Requests\Transaction\StoreTransactionRequest;

class StoreTransactionController
{
    private StoreTransactionAction $storeTransactionAction;

    public function __construct(StoreTransactionAction $storeTransactionAction)
    {
        $this->storeTransactionAction = $storeTransactionAction;
    }

    public function __invoke(StoreTransactionRequest $request): TransactionResource
    {
        return new TransactionResource(($this->storeTransactionAction)());
    }
}
