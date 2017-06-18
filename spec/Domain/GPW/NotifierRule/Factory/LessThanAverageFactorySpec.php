<?php

namespace spec\Domain\GPW\NotifierRule\Factory;

use Domain\GPW\NotifierRule\Factory\LessThanAverageFactory;
use Domain\GPW\NotifierRule\LessThanAverage;
use Domain\Notifier\NotifierRuleFactory;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Ramsey\Uuid\Uuid;

class LessThanAverageFactorySpec extends ObjectBehavior
{
    function let()
    {
        $this->shouldImplement(NotifierRuleFactory::class);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(LessThanAverageFactory::class);
    }

    function it_supports_only_less_than_rule()
    {
        $this->support('Domain\GPW\NotifierRule\LessThanAverage')->shouldBe(true);
    }

    function it_creates_rule_from_array()
    {
        $options = [
            'assetName' => 'ETF',
            'id' => Uuid::uuid4(),
        ];
        $this->create($options)->shouldImplement(LessThanAverage::class);
    }
}
