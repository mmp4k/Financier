<?php

namespace spec\Domain\ETFSP500\NotifyHandler;

use Domain\ETFSP500\NotifyHandler\LessThanAverage;
use Domain\Notifier\NotifierRule;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class LessThanAverageSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(LessThanAverage::class);
    }

    function it_supports_less_then_average_rule(\Domain\ETFSP500\NotifierRule\LessThanAverage $lessThanAverage)
    {
        $this->isSupported($lessThanAverage)->shouldBe(true);
    }

    function it_does_not_support_other_rules(NotifierRule $notifierRule)
    {
        $this->isSupported($notifierRule)->shouldBe(false);
    }

    function it_prepares_body_for_notify(\Domain\ETFSP500\NotifierRule\LessThanAverage $notifierRule)
    {
        $notifierRule->getCurrentValue()->willReturn(5);
        $notifierRule->getAverageFromLastTenMonths()->willReturn(6);

        $this->prepareBody($notifierRule)->shouldBeString();
    }
}
