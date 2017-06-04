<?php

namespace spec\Domain\Wallet;

use Domain\Wallet\WalletTransaction;
use Domain\Wallet\Asset;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Ramsey\Uuid\UuidInterface;

class WalletTransactionSpec extends ObjectBehavior
{
    function let(Asset $asset)
    {
        $numberOfAssets = 5;
        $priceOfAsset = 15;
        $commissionIn = 5;
        $this->beConstructedWith($asset, new \DateTime(), $numberOfAssets, $priceOfAsset, $commissionIn);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(WalletTransaction::class);
    }

    function it_has_unique_id()
    {
        $this->id()->shouldNotBeNull();
    }

    function it_has_date()
    {
        $this->date()->shouldBeAnInstanceOf(\DateTime::class);
    }

    function it_stores_asset_name(Asset $asset)
    {
        $asset->getName()->shouldBeCalled();
        $asset->getName()->willReturn('ETFSP500');
        $this->assetName()->shouldBe('ETFSP500');
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

    function it_sets_uuid(UuidInterface $uuid)
    {
        $this->setUuid($uuid);
    }
}
