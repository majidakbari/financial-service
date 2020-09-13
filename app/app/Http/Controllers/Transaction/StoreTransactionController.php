<?php

namespace App\Http\Controllers\Transaction;

use App\Http\Actions\StoreTransactionAction;
use App\Http\Resources\TransactionCollection;
use App\Http\Requests\Transaction\StoreTransactionRequest;

class StoreTransactionController
{
    private StoreTransactionAction $storeTransactionAction;

    public function __construct(StoreTransactionAction $storeTransactionAction)
    {
        $this->storeTransactionAction = $storeTransactionAction;
    }

    public function __invoke(StoreTransactionRequest $request): TransactionCollection
    {
        return new TransactionCollection(($this->storeTransactionAction)(
            $request->get('source_wallet_id'),
            $request->get('destination_wallet_id'),
            $request->get('amount'),
            $request->get('description'),
        ));
    }
}
