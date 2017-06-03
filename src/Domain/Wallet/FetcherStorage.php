<?php

namespace Domain\Wallet;

use Ramsey\Uuid\UuidInterface;

interface FetcherStorage
{
    public function findWallet(UuidInterface $uuid) : Wallet;


    /**
     * @param Wallet $wallet
     *
     * @return WalletTransaction[]
     */
    public function findTransactions(Wallet $wallet) : array;

    /**
     * @return Wallet[]
     */
    public function findWallets() : array;
}
