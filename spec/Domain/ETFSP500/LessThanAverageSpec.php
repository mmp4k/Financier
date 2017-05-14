<?php

namespace spec\Domain\ETFSP500;

use Domain\ETFSP500\LessThanAverage;
use Domain\ETFSP500\Storage;
use Domain\NotifierRule;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class LessThanAverageSpec extends ObjectBehavior
{
    function let(Storage $storage)
    {
        $this->beConstructedWith($storage);
        $this->shouldImplement(NotifierRule::class);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(LessThanAverage::class);
    }

    function it_notifies(Storage $storage)
    {
        $storage->getAverageFromLastTenMonths()->willReturn(65.02);
        $storage->getCurrentValue()->willReturn(65.01);
        $this->notify()->shouldBe(true);
    }
}
