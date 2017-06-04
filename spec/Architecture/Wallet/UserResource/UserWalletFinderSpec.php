<?php

namespace spec\Architecture\Wallet\UserResource;

use Architecture\Wallet\UserResource\UserWallet;
use Architecture\Wallet\UserResource\UserWalletFinder;
use Domain\User\User;
use Domain\User\UserResource;
use Domain\User\UserResourceFinder;
use Domain\Wallet\Fetcher;
use Domain\Wallet\Wallet;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

class UserWalletFinderSpec extends ObjectBehavior
{
    function let(UserResourceFinder $userResourceFinder, Fetcher $walletFetcher)
    {
        $this->beConstructedWith($userResourceFinder, $walletFetcher);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(UserWalletFinder::class);
    }

    function it_finds_user_wallets(UserResourceFinder $userResourceFinder, Fetcher $walletFetcher, User $user, UuidInterface $idResource)
    {
        $userResourceFinder->findByTypeAndUser(Wallet::class, $user)->shouldBeCalled();
        $userResourceFinder->findByTypeAndUser(Wallet::class, $user)->willReturn([$idResource]);
        $walletFetcher->findWallet($idResource)->shouldBeCalled();

        $wallets = $this->findWallets($user);
        $wallets->shouldBeArray();

        $wallet = $wallets[0];
        $wallet->shouldBeAnInstanceOf(UserWallet::class);
    }

    function it_finds_user_by_wallet(UserResourceFinder $userResourceFinder, Wallet $wallet, UuidInterface $uuid)
    {
        $wallet->id()->willReturn($uuid);
        $wallet->id()->shouldBeCalled();

        $userResourceFinder->findByTypeAndResource(Wallet::class, $uuid)->shouldBeCalled();

        $this->findUser($wallet)->shouldBeAnInstanceOf(User::class);
    }
}
