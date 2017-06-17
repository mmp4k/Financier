<?php

namespace spec\Domain\GPW;

use Domain\GPW\Asset;
use Domain\GPW\ClosingPrice;
use Domain\GPW\Fetcher;
use Domain\GPW\Fetcher\FetchStorage;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class FetcherSpec extends ObjectBehavior
{
    function let(FetchStorage $source)
    {
        $this->beConstructedWith($source);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(Fetcher::class);
    }

    function it_finds_duplicated_closing_price(FetchStorage $source, ClosingPrice $closingPrice)
    {
        $assetName = 'ETFSP500';
        $date = new \DateTime();

        $closingPrice->asset()->shouldBeCalled();
        $closingPrice->asset()->willReturn($assetName);
        $closingPrice->date()->shouldBeCalled();
        $closingPrice->date()->willReturn($date);

        $source->findByAssetAndDate($assetName, $date)->shouldBeCalled();
        $source->findByAssetAndDate($assetName, $date)->willReturn(null);

        $this->findDuplicate($closingPrice)->shouldBe(false);
    }

    function it_finds_today_closing_price(FetchStorage $source, Asset $asset)
    {
        $asset->code()->willReturn('ETFSP500');
        $source->findByAssetAndDate('ETFSP500', Argument::any())->shouldBeCalled();
        $this->findTodayClosingPrice($asset);
    }
}
