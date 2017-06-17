<?php

namespace spec\Domain\Wallet;

use Domain\Wallet\Asset;
use Domain\Wallet\TestAsset;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class TestAssetSpec extends ObjectBehavior
{
    function let()
    {
        $this->shouldImplement(Asset::class);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(TestAsset::class);
    }

    function it_has_name()
    {
        $this->getName()->shouldBe('RANDOM_ASSET');
    }
}
