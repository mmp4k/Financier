<?php

namespace spec\Domain\ETFSP500;

use Domain\ETFSP500\BusinessDay;
use Domain\ETFSP500\LessThanAverage;
use Domain\ETFSP500\Storage;
use Domain\NotifierRule;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class LessThanAverageSpec extends ObjectBehavior
{
    function let(Storage $storage, BusinessDay $businessDay)
    {
        $this->beConstructedWith($storage, $businessDay);
        $this->shouldImplement(NotifierRule::class);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(LessThanAverage::class);
    }

    function it_notifies(Storage $storage, BusinessDay $businessDay)
    {
        $businessDay->isBusinessDay()->willReturn(true);

        $storage->getAverageFromLastTenMonths()->willReturn(65.02);
        $storage->getCurrentValue($businessDay)->willReturn(65.01);
        $this->notify()->shouldBe(true);
    }
}
