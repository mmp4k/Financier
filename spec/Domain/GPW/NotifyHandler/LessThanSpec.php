<?php

namespace spec\Domain\GPW\NotifyHandler;

use Domain\GPW\Asset;
use Domain\GPW\ClosingPrice;
use Domain\GPW\Fetcher;
use Domain\GPW\NotifyHandler\LessThan;
use Domain\Notifier\NotifyHandler;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class LessThanSpec extends ObjectBehavior
{
    function let(Fetcher $fetcher)
    {
        $this->beConstructedWith($fetcher);
        $this->shouldImplement(NotifyHandler::class);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(LessThan::class);
    }

    function it_notifies_if_finishing_price_is_less_than(\Domain\GPW\NotifierRule\LessThan $lessThan, Fetcher $fetcher)
    {
        $asset = new Asset('ETFSP500');

        $lessThan->minValue()->willReturn(5.12);
        $lessThan->minValue()->shouldBeCalled();
        $lessThan->asset()->willReturn($asset);
        $lessThan->asset()->shouldBeCalled();

        $fetcher->findTodayClosingPrice($asset)->shouldBeCalled();
        $fetcher->findTodayClosingPrice($asset)->willReturn(new ClosingPrice($asset, new \DateTime(), 5.11));

        $this->notify($lessThan)->shouldBe(true);
    }
}
