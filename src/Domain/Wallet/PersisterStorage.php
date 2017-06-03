<?php

namespace Domain\Wallet;

interface PersisterStorage
{
    public function persist(Wallet $wallet);

    public function persistTransaction(Wallet $wallet, WalletTransaction $transaction);
}
