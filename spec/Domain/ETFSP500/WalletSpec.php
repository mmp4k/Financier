<?php

namespace spec\Domain\ETFSP500;

use Domain\ETFSP500\Wallet;
use Domain\ETFSP500\WalletTransaction;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class WalletSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(Wallet::class);
    }

    function it_collects_assets(WalletTransaction $asset)
    {
        $this->addTransaction($asset);
    }

    function it_stores_bought_assets()
    {
        $this->boughtAssets()->shouldBeNumeric();
    }

    function it_stores_value_of_investment()
    {
        $this->valueOfInvestment()->shouldBeFloat();
    }

    function it_stores_bought_value()
    {
        $this->boughtValue()->shouldBeFloat();
    }

    function it_calculates_profit()
    {
        $currentPrice = 20.0;
        $commissionOut = 5.0;

        $transaction1 = new WalletTransaction(new \DateTime(), 5, 15, 5);
        $transaction2 = new WalletTransaction(new \DateTime(), 5, 15, 5);

        $this->addTransaction($transaction1);
        $this->addTransaction($transaction2);

        $this->profit($currentPrice, $commissionOut)->shouldBeFloat();
        $this->profit($currentPrice, $commissionOut)->shouldBeApproximately(1.2333, 0.0001);
    }

    function it_calculate_current_value()
    {
        $currentPrice = 20.0;
        $commissionOut = 5.0;

        $transaction1 = new WalletTransaction(new \DateTime(), 5, 15, 5);
        $transaction2 = new WalletTransaction(new \DateTime(), 5, 15, 5);

        $this->addTransaction($transaction1);
        $this->addTransaction($transaction2);

        $this->currentValue($currentPrice, $commissionOut)->shouldBeFloat();
        $this->currentValue($currentPrice, $commissionOut)->shouldBe(185.0);
    }
}