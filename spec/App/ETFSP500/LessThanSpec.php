<?php

namespace spec\App\ETFSP500;

use App\ETFSP500\LessThan;
use App\NotifierRule;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use App\ETFSP500\Storage;

class LessThanSpec extends ObjectBehavior
{
    function let(Storage $storage)
    {
        $this->beConstructedWith($storage, 65.1);
        $this->shouldImplement(NotifierRule::class);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(LessThan::class);
    }

    function it_notifies_for_less_values(Storage $storage)
    {
        $storage->getCurrentValue()->willReturn(64);
        $this->notify()->shouldBe(true);
    }

    function it_notifies_for_less_float_values(Storage $storage)
    {
        $storage->getCurrentValue()->willReturn(65.09);
        $this->notify()->shouldBe(true);
    }

    function it_does_not_notify_for_bigger_values(Storage $storage)
    {
        $storage->getCurrentValue()->willReturn(65.11);
        $this->notify()->shouldBe(false);
    }
}
