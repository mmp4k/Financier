<?php

namespace App\Resolver;

use Architecture\ETFSP500\Storage\Doctrine;
use Architecture\Wallet\UserResource\UserWallet;
use Architecture\Wallet\UserResource\UserWalletFinder;
use Domain\ETFSP500\BusinessDay;
use Domain\Wallet\Fetcher;
use Ramsey\Uuid\Uuid;

class WalletNewTypeResolver
{
    /**
     * @var Doctrine
     */
    private $etfsp500;

    /**
     * @var UserWalletFinder
     */
    private $userWalletFinder;

    /**
     * @var Fetcher
     */
    private $fetcher;

    public function __construct(Doctrine $etfsp500, Fetcher $fetcher, UserWalletFinder $userWalletFinder)
    {
        $this->etfsp500 = $etfsp500;
        $this->userWalletFinder = $userWalletFinder;
        $this->fetcher = $fetcher;
    }

    public function getCurrentETFSP500Value() : float
    {
        $businessDay = new BusinessDay(new \DateTime());
        return $this->etfsp500->getCurrentValue($businessDay);
    }

    public function findWallet($id) : UserWallet
    {
        $uuid = Uuid::fromString($id);

        $wallet = $this->fetcher->findWallet($uuid);

        $user = $this->userWalletFinder->findUser($wallet);

        $wallets = $this->userWalletFinder->findWallets($user);

        foreach ($wallets as $userWallet) {
            if ($userWallet->id()->equals($uuid)) {
                return $userWallet;
            }
        }

    }
}