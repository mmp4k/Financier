<?php

namespace Domain\Wallet;

use Domain\ETFSP500\ETFSP500;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

class Fetcher
{
    /**
     * @var FetcherStorage
     */
    private $fetcherStorage;

    public function __construct(FetcherStorage $fetcherStorage)
    {
        $this->fetcherStorage = $fetcherStorage;
    }

    public function findWallet(UuidInterface $uuid) : Wallet
    {
        $wallet = $this->fetcherStorage->findWallet($uuid);

        $this->fetcherStorage->findTransactions($wallet);

        return $wallet;
    }

    public function findWallets()
    {
        $wallets = $this->fetcherStorage->findWallets();

        foreach ($wallets as $wallet) {
            $this->fetcherStorage->findTransactions($wallet);
        }

        return $wallets;
    }
}
