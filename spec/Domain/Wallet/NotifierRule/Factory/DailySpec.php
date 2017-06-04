<?php

namespace spec\Domain\Wallet\NotifierRule\Factory;

use Domain\Wallet\NotifierRule\Factory\Daily;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class DailySpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(Daily::class);
    }

    function it_support_less_than_rule()
    {
        $this->support(\Domain\Wallet\NotifierRule\Daily::class)->shouldBe(true);
    }

    function it_creates_rule_from_options()
    {
        $rule = $this->create([
        ]);
        $rule->shouldBeAnInstanceOf(\Domain\Wallet\NotifierRule\Daily::class);
    }
}
