<?php

namespace spec\Domain\ETFSP500\NotifyHandler;

use Domain\ETFSP500\NotifyHandler\LessThan;
use Domain\Notifier\NotifierRule;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class LessThanSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(LessThan::class);
    }

    function is_supports_daily_rule(\Domain\ETFSP500\NotifierRule\LessThan $lessThan)
    {
        $this->isSupported($lessThan)->shouldBe(true);
    }

    function it_prepares_body_for_notify(\Domain\ETFSP500\NotifierRule\LessThan $notifierRule)
    {
        $notifierRule->getCurrentValue()->willReturn(5);
        $notifierRule->getMinValue()->willReturn(6);

        $this->prepareBody($notifierRule)->shouldBeString();
    }
}
