<?php

namespace Architecture\Wallet\UserResource;

use Domain\User\User;
use Domain\User\UserResourceFinder;
use Domain\Wallet\Fetcher;
use Domain\Wallet\Wallet;

class UserWalletFinder
{
    /**
     * @var UserResourceFinder
     */
    private $userResourceFinder;
    /**
     * @var Fetcher
     */
    private $walletFetcher;

    public function __construct(UserResourceFinder $userResourceFinder, Fetcher $walletFetcher)
    {
        $this->userResourceFinder = $userResourceFinder;
        $this->walletFetcher = $walletFetcher;
    }

    /**
     * @param User $user
     *
     * @return array|UserWallet[]
     */
    public function findWallets(User $user)
    {
        $resources = $this->userResourceFinder->findByTypeAndUser(UserWallet::class, $user);

        $userWallets = [];
        foreach ($resources as $resource) {
            $wallet = $this->walletFetcher->findWallet($resource);
            $userWallets[] = new UserWallet($wallet, $user);
        }

        return $userWallets;
    }

    public function findUser(Wallet $wallet)
    {
        return $this->userResourceFinder->findByTypeAndResource(UserWallet::class, $wallet->id());
    }
}
