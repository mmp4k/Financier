<?php

namespace spec\Architecture\Wallet\UserResource;

use Architecture\Wallet\UserResource\UserWalletFinder;
use Domain\User\User;
use Domain\Wallet\Wallet;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class UserWalletFinderSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(UserWalletFinder::class);
    }

    function it_finds_user_wallets(User $user)
    {
        $this->findWallets($user)->shouldBeArray();
    }

    function it_finds_user_by_wallet(Wallet $wallet)
    {
        $this->findUser($wallet)->shouldBeAnInstanceOf(User::class);
    }
}
