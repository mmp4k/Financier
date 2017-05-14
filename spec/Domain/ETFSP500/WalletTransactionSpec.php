<?php

namespace spec\Domain\ETFSP500;

use Domain\ETFSP500\WalletTransaction;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class WalletTransactionSpec extends ObjectBehavior
{
    function let()
    {
        $numberOfAssets = 5;
        $priceOfAsset = 15;
        $commissionIn = 5;
        $this->beConstructedWith(new \DateTime(), $numberOfAssets, $priceOfAsset, $commissionIn);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(WalletTransaction::class);
    }

    function it_has_date()
    {
        $this->date()->shouldBeAnInstanceOf(\DateTime::class);
    }

    function it_has_assets()
    {
        $this->assets()->shouldBeInteger();
        $this->assets()->shouldBe(5);
    }

    function it_has_value_of_investment()
    {
        $this->valueOfInvestment()->shouldBeFloat();
        $this->valueOfInvestment()->shouldBe(80.0);
    }

    function it_has_commissions()
    {
        $this->commissionIn()->shouldBeFloat();
        $this->commissionIn()->shouldBe(5.0);
    }

    function it_counts_profit()
    {
        $currentPrice = 20.0;
        $commissionOut = 6.0;

        $this->profit($currentPrice, $commissionOut)->shouldBeFloat();
        $this->profit($currentPrice, $commissionOut)->shouldBe(1.1867);
    }

    function it_counts_current_value()
    {
        $currentPrice = 20.0;
        $commissionOut = 6.0;
        $this->currentValue($currentPrice, $commissionOut)->shouldBeFloat();
        $this->currentValue($currentPrice, $commissionOut)->shouldBe(89.0);
    }

    function it_has_bought_value()
    {
        $this->boughtValue()->shouldBeFloat();
    }
}
