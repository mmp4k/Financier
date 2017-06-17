<?php

namespace spec\Domain\GPW\NotifierRule\Factory;

use Domain\GPW\NotifierRule\Factory\LessThanFactory;
use Domain\GPW\NotifierRule\LessThan;
use Domain\Notifier\NotifierRuleFactory;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

class LessThanFactorySpec extends ObjectBehavior
{
    function let()
    {
        $this->shouldImplement(NotifierRuleFactory::class);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(LessThanFactory::class);
    }

    function it_supports_only_less_than_rule(LessThan $rule)
    {
        $this->support('Domain\GPW\NotifierRule\LessThan')->shouldBe(true);
    }

    function it_creates_rule_from_array()
    {
        $options = [
            'minValue' => 15.2,
            'assetName' => 'ETF',
            'id' => Uuid::uuid4(),
        ];
        $this->create($options)->shouldImplement(LessThan::class);
    }
}
