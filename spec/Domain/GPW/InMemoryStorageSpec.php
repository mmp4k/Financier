<?php

namespace spec\Domain\GPW;

use Domain\GPW\ClosingPrice;
use Domain\GPW\Fetcher\FetchStorage;
use Domain\GPW\InMemoryStorage;
use Domain\GPW\Persister\PersistStorage;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class InMemoryStorageSpec extends ObjectBehavior
{
    function let()
    {
        $this->shouldImplement(PersistStorage::class);
        $this->shouldImplement(FetchStorage::class);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(InMemoryStorage::class);
    }

    function it_persists_closing_price(ClosingPrice $closingPrice)
    {
        $this->persist($closingPrice);
    }

    function it_does_not_found_closing_price_if_none_exists(\DateTime $dateTime)
    {
        $this->findByAssetAndDate('name', $dateTime)->shouldBe(null);
    }

    function it_does_not_found_closing_price_if_asset_have_different_name(ClosingPrice $closingPrice, \DateTime $dateTime)
    {
        $this->persist($closingPrice);
        $closingPrice->asset()->willReturn('ETF1');
        $closingPrice->asset()->shouldBeCalled();
        $this->findByAssetAndDate('ETF2', $dateTime)->shouldBe(null);
    }

    function it_does_not_found_closing_price_if_date_is_different(ClosingPrice $closingPrice, \DateTime $dateTime)
    {
        $this->persist($closingPrice);
        $closingPrice->asset()->willReturn('ETF2');
        $closingPrice->asset()->shouldBeCalled();
        $closingPrice->date()->willReturn(new \DateTime());
        $closingPrice->date()->shouldBeCalled();
        $this->findByAssetAndDate('ETF2', $dateTime)->shouldBe(null);
    }

    function it_founds_closing_price_if_asset_name_and_date_match(ClosingPrice $closingPrice, \DateTime $dateTime)
    {
        $this->persist($closingPrice);
        $closingPrice->asset()->willReturn('ETF2');
        $closingPrice->asset()->shouldBeCalled();
        $closingPrice->date()->willReturn($dateTime);
        $closingPrice->date()->shouldBeCalled();
        $this->findByAssetAndDate('ETF2', $dateTime)->shouldBe($closingPrice);
    }
}
