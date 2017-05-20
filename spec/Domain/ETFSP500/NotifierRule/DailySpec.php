<?php

namespace spec\Domain\ETFSP500\NotifierRule;

use Domain\ETFSP500\NotifierRule\Daily;
use Domain\Notifier\NotifierRule;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class DailySpec extends ObjectBehavior
{
    function let()
    {
        $this->shouldImplement(NotifierRule::class);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(Daily::class);
    }

    function it_executes_always()
    {
        $this->notify()->shouldBe(true);
    }
}
