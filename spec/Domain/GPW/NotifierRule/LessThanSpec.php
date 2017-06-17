<?php

namespace spec\Domain\GPW\NotifierRule;

use Domain\GPW\Asset;
use Domain\GPW\NotifierRule\LessThan;
use Domain\Notifier\NotifierRule;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

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
}
