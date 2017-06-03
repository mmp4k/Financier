<?php

namespace spec\Domain\Wallet;

use Domain\Wallet\Persister;
use Domain\Wallet\PersisterStorage;
use Domain\Wallet\Wallet;
use Domain\Wallet\WalletTransaction;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class PersisterSpec extends ObjectBehavior
{
    function let(PersisterStorage $persisterStorage)
    {
        $this->beConstructedWith($persisterStorage);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(Persister::class);
    }

    function it_persists_wallet(PersisterStorage $persisterStorage, Wallet $wallet)
    {
        $wallet->getTransactions()->willReturn([]);

        $persisterStorage->persist($wallet)->shouldBeCalled();
        $persisterStorage->persist($wallet)->willReturn(1);

        $id = $this->persist($wallet);
        $id->shouldBe(1);
    }

    function it_persists_wallet_with_transactions(PersisterStorage $persisterStorage, Wallet $wallet, WalletTransaction $transaction)
    {
        $wallet->getTransactions()->willReturn([$transaction]);

        $persisterStorage->persist($wallet)->shouldBeCalled();
        $persisterStorage->persistTransaction($wallet, $transaction)->shouldBeCalled();

        $this->persist($wallet);
    }
}
