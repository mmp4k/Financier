<?php

namespace spec\Domain\ETFSP500\NotifierRule\Factory;

use Domain\ETFSP500\BusinessDay;
use Domain\ETFSP500\NotifierRule\Factory\LessThanAverage;
use Domain\ETFSP500\Storage;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class LessThanAverageSpec extends ObjectBehavior
{
    function let(Storage $storage, BusinessDay $businessDay)
    {
        $this->beConstructedWith($storage, $businessDay);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(LessThanAverage::class);
    }

    function it_support_less_than_rule()
    {
        $this->support(\Domain\ETFSP500\NotifierRule\LessThanAverage::class)->shouldBe(true);
    }

    function it_creates_rule_from_options()
    {
        $rule = $this->create([
        ]);
        $rule->shouldBeAnInstanceOf(\Domain\ETFSP500\NotifierRule\LessThanAverage::class);
    }
}
