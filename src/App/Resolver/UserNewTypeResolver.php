<?php

namespace App\Resolver;

use Architecture\ETFSP500\Storage\Doctrine;
use Architecture\Notifier\UserResource\UserNotifierFinder;
use Architecture\Wallet\UserResource\UserWallet;
use Architecture\Wallet\UserResource\UserWalletFinder;
use Domain\ETFSP500\BusinessDay;
use Domain\User\Fetcher;
use Domain\User\User;
use Domain\Wallet\Wallet;

class UserNewTypeResolver
{
    /**
     * @var Fetcher
     */
    private $fetcher;

    /**
     * @var UserWalletFinder
     */
    private $userWalletFinder;

    /**
     * @var UserNotifierFinder
     */
    private $userNotifierFinder;

    public function __construct(Fetcher $fetcher, UserWalletFinder $userWalletFinder, UserNotifierFinder $userNotifierFinder)
    {
        $this->fetcher = $fetcher;
        $this->userWalletFinder = $userWalletFinder;
        $this->userNotifierFinder = $userNotifierFinder;
    }

    public function findUser(string $email) : User
    {
        return $this->fetcher->findUserByIdentify($email);
    }

    public function findUserWallets(User $user) : array
    {
        return $this->userWalletFinder->findWallets($user);
    }
    public function findNotifications(User $user) : array
    {
        return $this->userNotifierFinder->findRules($user);
    }

}