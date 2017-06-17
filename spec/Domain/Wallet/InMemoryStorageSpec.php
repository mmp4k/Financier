<?php

namespace spec\Domain\Wallet;

use Domain\Wallet\FetcherStorage;
use Domain\Wallet\InMemoryStorage;
use Domain\Wallet\PersisterStorage;
use Domain\Wallet\Wallet;
use Domain\Wallet\WalletTransaction;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Ramsey\Uuid\UuidInterface;

class InMemoryStorageSpec extends ObjectBehavior
{
    function let()
    {
        $this->shouldImplement(FetcherStorage::class);
        $this->shouldImplement(PersisterStorage::class);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(InMemoryStorage::class);
    }

    function it_persists_wallets(Wallet $wallet, UuidInterface $uuid, WalletTransaction $transaction)
    {
        $uuid->getHex()->willReturn('HEX');
        $wallet->id()->willReturn($uuid);

        $this->persist($wallet);
        $this->persistTransaction($wallet, $transaction);
        $this->findWallet($uuid)->shouldBe($wallet);
        $this->findWallets()->shouldBe([
            'HEX' => $wallet
        ]);
        $this->findTransactions($wallet)->shouldBe([$transaction]);
    }
}
