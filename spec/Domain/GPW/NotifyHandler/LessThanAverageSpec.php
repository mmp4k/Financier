<?php

namespace spec\Domain\GPW\NotifyHandler;

use Domain\GPW\Asset;
use Domain\GPW\ClosingPrice;
use Domain\GPW\Fetcher;
use Domain\GPW\NotifyHandler\LessThanAverage;
use Domain\Notifier\NotifyHandler;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class LessThanAverageSpec extends ObjectBehavior
{
    function let(Fetcher $fetcher)
    {
        $this->beConstructedWith($fetcher);
        $this->shouldImplement(NotifyHandler::class);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(LessThanAverage::class);
    }

    function it_supports_only_less_than_average(\Domain\GPW\NotifierRule\LessThanAverage $lessThanAverage)
    {
        $this->support($lessThanAverage)->shouldBe(true);
    }

    function it_does_not_notify_if_does_not_found_current_closing_price(\Domain\GPW\NotifierRule\LessThanAverage $lessThanAverage, Fetcher $fetcher, Asset $asset)
    {
        $asset->code()->willReturn('ETF');
        $lessThanAverage->asset()->willReturn($asset);
        $fetcher->findTodayClosingPrice($asset)->willReturn(null);
        $fetcher->findTodayClosingPrice($asset)->shouldBeCalled();

        $this->notify($lessThanAverage)->shouldBe(false);
    }

    function it_notify_if_current_price_is_less_than_average(\Domain\GPW\NotifierRule\LessThanAverage $lessThanAverage, Fetcher $fetcher, Asset $asset, ClosingPrice $closingPrice, ClosingPrice $closingPrice2, ClosingPrice $closingPrice3)
    {
        $closingPrice->price()->willReturn(3.11);
        $closingPrice2->price()->willReturn(2.12);
        $closingPrice3->price()->willReturn(4.12);

        $asset->code()->willReturn('ETF');
        $lessThanAverage->asset()->willReturn($asset);
        $fetcher->findTodayClosingPrice($asset)->willReturn($closingPrice);
        $fetcher->findTodayClosingPrice($asset)->shouldBeCalled();

        $fetcher->findClosingPricesFromEndLastTenMonths($asset, Argument::any())->willReturn([$closingPrice2, $closingPrice3]);

        $this->notify($lessThanAverage)->shouldBe(true);
    }
}
