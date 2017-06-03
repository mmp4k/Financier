<?php

namespace spec\Architecture\Wallet\UserResource;

use Architecture\Wallet\UserResource\UserWallet;
use Domain\User\Assigner;
use Domain\User\User;
use Domain\User\UserResource;
use Domain\Wallet\Wallet;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class UserWalletSpec extends ObjectBehavior
{
    function let(Wallet $wallet, User $user)
    {
        $this->beConstructedWith($wallet, $user);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(UserWallet::class);
        $this->shouldImplement(UserResource::class);
    }

    function it_is_assigable_by_user(Assigner $assigner)
    {
        $assigner->assign($this);
    }
}
