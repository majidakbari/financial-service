<?php

namespace App\Http\Services\Transaction;

use App\Repositories\WalletRepository;

class ChangeWalletBalanceService
{
    private WalletRepository $walletRepository;

    public function __construct(WalletRepository $walletRepository)
    {
        $this->walletRepository = $walletRepository;
    }

    public function __invoke(int $walletId, float $balanceChange): void
    {
        $this->walletRepository->changeBalance($walletId, $balanceChange);
    }
}
