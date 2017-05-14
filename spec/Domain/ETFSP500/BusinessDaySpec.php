<?php

namespace spec\Domain\ETFSP500;

use Domain\ETFSP500\BusinessDay;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class BusinessDaySpec extends ObjectBehavior
{
    function let(\DateTime $dateTime)
    {
        $this->beConstructedWith($dateTime);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(BusinessDay::class);
    }

    function it_talks_that_is_business_day()
    {
        $this->isBusinessDay()->shouldBeBool();
    }

    function it_treats_monday_as_business_day(\DateTime $dateTime)
    {
        $dateTime->format('N')->willReturn(1);
        $this->isBusinessDay()->shouldBe(true);
    }

    function it_treats_tuesday_as_business_day(\DateTime $dateTime)
    {
        $dateTime->format('N')->willReturn(2);
        $this->isBusinessDay()->shouldBe(true);
    }

    function it_treats_wednesday_as_business_day(\DateTime $dateTime)
    {
        $dateTime->format('N')->willReturn(3);
        $this->isBusinessDay()->shouldBe(true);
    }

    function it_treats_thursday_as_business_day(\DateTime $dateTime)
    {
        $dateTime->format('N')->willReturn(4);
        $this->isBusinessDay()->shouldBe(true);
    }

    function it_treats_friday_as_business_day(\DateTime $dateTime)
    {
        $dateTime->format('N')->willReturn(5);
        $this->isBusinessDay()->shouldBe(true);
    }

    function it_treats_saturday_as_not_business_day(\DateTime $dateTime)
    {
        $dateTime->format('N')->willReturn(6);
        $this->isBusinessDay()->shouldBe(false);
    }

    function it_treats_sunday_as_not_business_day(\DateTime $dateTime)
    {
        $dateTime->format('N')->willReturn(7);
        $this->isBusinessDay()->shouldBe(false);
    }

    function it_treats_polish_holidays_are_not_business_day()
    {

    }
}
