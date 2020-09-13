<?php

namespace App\Http\Actions;

use App\Entities\Transaction;
use Illuminate\Support\Collection;
use App\Http\Services\Transaction\FindWalletByIdService;
use App\Http\Services\Transaction\StoreTransactionService;
use App\Http\Services\Transaction\ChangeWalletBalanceService;
use App\Exceptions\HttpException\InsufficientCreditException;
use App\Http\Services\Transaction\CalculateCommissionService;

class StoreTransactionAction
{
    private FindWalletByIdService $findWalletByIdService;
    private StoreTransactionService $storeTransactionService;
    private CalculateCommissionService $calculateCommissionService;
    private ChangeWalletBalanceService $changeWalletBalanceService;

    public function __construct(
        FindWalletByIdService $findWalletByIdService,
        StoreTransactionService $storeTransactionService,
        CalculateCommissionService $calculateCommissionService,
        ChangeWalletBalanceService $changeWalletBalanceService

    ) {
        $this->findWalletByIdService = $findWalletByIdService;
        $this->storeTransactionService = $storeTransactionService;
        $this->calculateCommissionService = $calculateCommissionService;
        $this->changeWalletBalanceService = $changeWalletBalanceService;
    }

    public function __invoke(
        int $sourceWalletId,
        int $destinationWalletId,
        float $amount,
        ?string $description = null
    ): Collection {
        $sourceWallet = ($this->findWalletByIdService)($sourceWalletId);
        if ($sourceWallet->balance < $amount) {
            throw new InsufficientCreditException();
        }

        $commission = ($this->calculateCommissionService)($amount);

        $originalTransaction = ($this->storeTransactionService)(
            $sourceWalletId,
            $destinationWalletId,
            $amount - $commission,
            Transaction::TYPE_TRANSFER_CODE,
            $description
        );
        ($this->changeWalletBalanceService)($sourceWalletId, -$amount);
        ($this->changeWalletBalanceService)($destinationWalletId, $amount - $commission);

        $companyWalletId = config('logic.company_wallet_id');
        $commissionTransaction = ($this->storeTransactionService)(
            $sourceWalletId,
            $companyWalletId,
            $commission,
            Transaction::TYPE_COMMISSION_CODE,
        );
        ($this->changeWalletBalanceService)($companyWalletId, $commission);


        return collect([$originalTransaction, $commissionTransaction]);
    }
}
