<?php

namespace spec\Domain\GPW;

use Domain\GPW\Asset;
use Domain\GPW\ClosingPrice;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Ramsey\Uuid\UuidInterface;

class ClosingPriceSpec extends ObjectBehavior
{
    function let(Asset $asset, \DateTime $dateTime)
    {
        $asset->code()->willReturn('ETFSP500');
        $this->beConstructedWith($asset, $dateTime, 2.15);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(ClosingPrice::class);
    }

    function it_has_code_asset()
    {
        $this->asset()->shouldBe('ETFSP500');
    }

    function it_has_date()
    {
        $this->date()->shouldImplement(\DateTime::class);
    }

    function it_has_closing_price()
    {
        $this->price()->shouldBe(2.15);
    }

    function it_has_uuid()
    {
        $this->uuid()->shouldImplement(UuidInterface::class);
    }
}
