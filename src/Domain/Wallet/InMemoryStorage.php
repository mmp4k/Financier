<?php

namespace Domain\Wallet;

use Ramsey\Uuid\UuidInterface;

class InMemoryStorage implements FetcherStorage, PersisterStorage
{
    /**
     * @var Wallet[]
     */
    private $wallets = [];

    /**
     * @var WalletTransaction[]
     */
    private $transactions = [];

    public function findWallet(UuidInterface $uuid): Wallet
    {
        return $this->wallets[$uuid->getHex()];
    }

    /**
     * @param Wallet $wallet
     *
     * @return WalletTransaction[]
     */
    public function findTransactions(Wallet $wallet): array
    {
        return $this->transactions[$wallet->id()->getHex()];
    }

    /**
     * @return Wallet[]
     */
    public function findWallets(): array
    {
        return $this->wallets;
    }

    public function persist(Wallet $wallet)
    {
        $this->wallets[$wallet->id()->getHex()] = $wallet;
        $this->transactions[$wallet->id()->getHex()] = [];
    }

    public function persistTransaction(Wallet $wallet, WalletTransaction $transaction)
    {
        $this->transactions[$wallet->id()->getHex()][] = $transaction;
    }
}