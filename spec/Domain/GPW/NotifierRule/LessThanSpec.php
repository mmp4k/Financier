<?php

namespace spec\Domain\GPW\NotifierRule;

use Domain\GPW\Asset;
use Domain\GPW\NotifierRule\LessThan;
use Domain\Notifier\NotifierRule;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Ramsey\Uuid\UuidInterface;

class LessThanSpec extends ObjectBehavior
{
    function let(Asset $asset)
    {
        $this->beConstructedWith($asset, 5.12);
        $this->shouldImplement(NotifierRule::class);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(LessThan::class);
    }

    function it_has_uuid()
    {
        $this->id()->shouldImplement(UuidInterface::class);
    }

    function it_has_minimum_value_when_notifier_should_be_send()
    {
        $this->minValue()->shouldBe(5.12);
    }

    function it_is_related_to_asset(Asset $asset)
    {
        $this->asset()->shouldBe($asset);
    }

    function it_has_persistable_config(Asset $asset)
    {
        $asset->code()->willReturn('RANDOM');

        $this->persistConfig()->shouldBe([
            'minValue' => 5.12,
            'assetName' => 'RANDOM'
        ]);
    }
}
