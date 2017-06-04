<?php

namespace spec\Domain\ETFSP500\NotifierRule;

use Domain\ETFSP500\BusinessDay;
use Domain\ETFSP500\NotifierRule\LessThanAverage;
use Domain\ETFSP500\Storage;
use Domain\Notifier\NotifierRule;
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

    function it_does_not_notify_when_current_value_is_bigger(Storage $storage, BusinessDay $businessDay)
    {
        $businessDay->isBusinessDay()->willReturn(true);

        $storage->getAverageFromLastTenMonths()->willReturn(65.01);
        $storage->getCurrentValue($businessDay)->willReturn(65.02);
        $this->notify()->shouldBe(false);
    }

    function it_gets_current_value(Storage $storage, BusinessDay $businessDay)
    {
        $businessDay->isBusinessDay()->willReturn(true);

        $storage->getCurrentValue($businessDay)->willReturn(65.11);
        $this->getCurrentValue()->shouldBe(65.11);
    }

    function it_gets_value_when_alert_is_open(Storage $storage, BusinessDay $businessDay)
    {
        $businessDay->isBusinessDay()->willReturn(true);

        $storage->getAverageFromLastTenMonths()->willReturn(65.11);
        $this->getAverageFromLastTenMonths()->shouldBe(65.11);
    }

    function it_has_empty_config()
    {
        $this->persistConfig()->shouldBe([]);
    }
}
