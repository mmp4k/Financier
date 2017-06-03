<?php

namespace spec\Domain\Wallet;

use Domain\Wallet\Asset;
use Domain\Wallet\Wallet;
use Domain\Wallet\WalletTransaction;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class WalletSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(Wallet::class);
    }

    function it_has_unique_id()
    {
        $this->id()->shouldNotBeNull();
    }

    function it_collects_assets(WalletTransaction $asset)
    {
        $this->addTransaction($asset);
    }

    function it_stores_bought_assets(WalletTransaction $walletTransaction1, WalletTransaction $walletTransaction2, WalletTransaction $walletTransaction3)
    {
        $walletTransaction1->assets()->willReturn(1);
        $walletTransaction2->assets()->willReturn(2);
        $walletTransaction3->assets()->willReturn(3);

        $this->addTransaction($walletTransaction1);
        $this->addTransaction($walletTransaction2);
        $this->addTransaction($walletTransaction3);

        $this->boughtAssets()->shouldBeNumeric();
        $this->boughtAssets()->shouldBe(6);
    }

    function it_stores_value_of_investment(WalletTransaction $walletTransaction1, WalletTransaction $walletTransaction2, WalletTransaction $walletTransaction3)
    {
        $walletTransaction1->valueOfInvestment()->willReturn(1);
        $walletTransaction2->valueOfInvestment()->willReturn(2);
        $walletTransaction3->valueOfInvestment()->willReturn(3);

        $this->addTransaction($walletTransaction1);
        $this->addTransaction($walletTransaction2);
        $this->addTransaction($walletTransaction3);

        $this->valueOfInvestment()->shouldBeFloat();
        $this->valueOfInvestment()->shouldBe(6.0);
    }

    function it_stores_bought_value(WalletTransaction $walletTransaction1, WalletTransaction $walletTransaction2, WalletTransaction $walletTransaction3)
    {
        $walletTransaction1->boughtValue()->willReturn(1);
        $walletTransaction2->boughtValue()->willReturn(2);
        $walletTransaction3->boughtValue()->willReturn(3);

        $this->addTransaction($walletTransaction1);
        $this->addTransaction($walletTransaction2);
        $this->addTransaction($walletTransaction3);

        $this->boughtValue()->shouldBeFloat();
        $this->boughtValue()->shouldBe(6.0);
    }

    function it_calculates_profit(WalletTransaction $transaction1, WalletTransaction $transaction2)
    {
        $currentPrice = 20.0;
        $commissionOut = 5.0;

        $transaction1->boughtValue()->willReturn(5*15);
        $transaction2->boughtValue()->willReturn(5*15);
        $transaction1->currentValue(20, 2.5)->willReturn(92.5);
        $transaction2->currentValue(20, 2.5)->willReturn(92.5);

        $this->addTransaction($transaction1);
        $this->addTransaction($transaction2);

        $this->profit($currentPrice, $commissionOut)->shouldBeFloat();
        $this->profit($currentPrice, $commissionOut)->shouldBeApproximately(1.2333, 0.0001);
    }

    function it_calculate_current_value(WalletTransaction $transaction1, WalletTransaction $transaction2)
    {
        $currentPrice = 20.0;
        $commissionOut = 5.0;

        $transaction1->currentValue(20, 2.5)->willReturn(92.5);
        $transaction2->currentValue(20, 2.5)->willReturn(92.5);

        $this->addTransaction($transaction1);
        $this->addTransaction($transaction2);

        $this->currentValue($currentPrice, $commissionOut)->shouldBeFloat();
        $this->currentValue($currentPrice, $commissionOut)->shouldBe(185.0);
    }

    function it_orders_transactions(WalletTransaction $walletTransaction1, WalletTransaction $walletTransaction2, WalletTransaction $walletTransaction3)
    {
        $dateTime1 = \DateTime::createFromFormat('d.m.Y', '01.02.2017');
        $dateTime2 = \DateTime::createFromFormat('d.m.Y', '02.02.2017');
        $dateTime3 = \DateTime::createFromFormat('d.m.Y', '03.02.2017');

        $walletTransaction1->date()->willReturn($dateTime2);
        $walletTransaction2->date()->willReturn($dateTime3);
        $walletTransaction3->date()->willReturn($dateTime1);

        $this->addTransaction($walletTransaction1);
        $this->addTransaction($walletTransaction2);
        $this->addTransaction($walletTransaction3);

        $this->getTransactions()->shouldBe([$walletTransaction3, $walletTransaction1, $walletTransaction2]);
    }
}
