<?php

namespace App\Http\Services\Transaction;

use App\Entities\Wallet;
use App\Repositories\WalletRepository;

class FindWalletByIdService
{
    private WalletRepository $walletRepository;

    public function __construct(WalletRepository $walletRepository)
    {
        $this->walletRepository = $walletRepository;
    }

    public function __invoke(int $id): ?Wallet
    {
        return $this->walletRepository->find($id);
    }
}
