<?php

namespace spec\Domain\GPW;

use Domain\GPW\Asset;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class AssetSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith('ETFSP500');
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(Asset::class);
    }

    function it_has_code()
    {
        $this->code()->shouldBe('ETFSP500');
    }
}
