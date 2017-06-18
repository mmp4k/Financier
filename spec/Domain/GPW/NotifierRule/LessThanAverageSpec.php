<?php

namespace spec\Domain\GPW\NotifierRule;

use Domain\GPW\Asset;
use Domain\GPW\NotifierRule\LessThanAverage;
use Domain\Notifier\NotifierRule;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Ramsey\Uuid\UuidInterface;

class LessThanAverageSpec extends ObjectBehavior
{
    function let(Asset $asset)
    {
        $this->beConstructedWith($asset);
        $this->shouldImplement(NotifierRule::class);
    }

    function it_has_uuid()
    {
        $this->id()->shouldImplement(UuidInterface::class);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(LessThanAverage::class);
    }

    function it_is_related_to_asset(Asset $asset)
    {
        $this->asset()->shouldBe($asset);
    }

    function it_has_persistable_config(Asset $asset)
    {
        $asset->code()->willReturn('RANDOM');

        $this->persistConfig()->shouldBe([
            'assetName' => 'RANDOM'
        ]);
    }
}
