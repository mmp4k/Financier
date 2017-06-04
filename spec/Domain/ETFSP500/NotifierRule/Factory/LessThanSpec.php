<?php

namespace spec\Domain\ETFSP500\NotifierRule\Factory;

use Domain\ETFSP500\BusinessDay;
use Domain\ETFSP500\NotifierRule\Factory\LessThan;
use Domain\ETFSP500\Storage;
use PhpSpec\ObjectBehavior;
use PhpSpec\Wrapper\Subject;
use Prophecy\Argument;

class LessThanSpec extends ObjectBehavior
{
    function let(Storage $storage, BusinessDay $businessDay)
    {
        $this->beConstructedWith($storage, $businessDay);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(LessThan::class);
    }

    function it_support_less_than_rule()
    {
        $this->support(\Domain\ETFSP500\NotifierRule\LessThan::class)->shouldBe(true);
    }

    function it_creates_rule_from_options()
    {
        /** @var \Domain\ETFSP500\NotifierRule\LessThan|Subject $rule */
        $rule = $this->create([
            'minValue' => 50
        ]);
        $rule->shouldBeAnInstanceOf(\Domain\ETFSP500\NotifierRule\LessThan::class);
        $rule->getMinValue()->shouldBe(50.0);
    }
}
