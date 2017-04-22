<?php

namespace spec\App\ETFSP500;

use App\ETFSP500\LessThanAverage;
use App\ETFSP500\Storage;
use App\NotifierRule;
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
