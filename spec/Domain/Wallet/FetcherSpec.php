<?php

namespace spec\Domain\Wallet;

use Domain\Wallet\Fetcher;
use Domain\Wallet\FetcherStorage;
use Domain\Wallet\Wallet;
use Domain\Wallet\WalletTransaction;
use PhpSpec\ObjectBehavior;
use PhpSpec\Wrapper\Subject;
use Prophecy\Argument;
use Ramsey\Uuid\Uuid;

class FetcherSpec extends ObjectBehavior
{
    function let(FetcherStorage $fetcherStorage)
    {
        $this->beConstructedWith($fetcherStorage);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(Fetcher::class);
    }

    function it_fetches_wallet_by_uuid(FetcherStorage $fetcherStorage, Uuid $uuid, Wallet $wallet)
    {
        $fetcherStorage->findWallet($uuid)->shouldBeCalled();
        $fetcherStorage->findWallet($uuid)->willReturn($wallet);
        $fetcherStorage->findTransactions($wallet)->shouldBeCalled();

        $this->findWallet($uuid)->shouldBe($wallet);
    }

    function it_fetches_wallets(FetcherStorage $fetcherStorage, Wallet $wallet)
    {
        $fetcherStorage->findWallets()->shouldBeCalled();
        $fetcherStorage->findWallets()->willReturn([$wallet]);
        $fetcherStorage->findTransactions($wallet)->shouldBeCalled();

        $this->findWallets();
    }
}