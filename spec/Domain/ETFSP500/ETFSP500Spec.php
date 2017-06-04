<?php

namespace spec\Domain\ETFSP500;

use Domain\ETFSP500\ETFSP500;
use Domain\Wallet\Asset;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ETFSP500Spec extends ObjectBehavior
{
    function let()
    {
        $this->shouldBeAnInstanceOf(Asset::class);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(ETFSP500::class);
    }

    function it_has_name()
    {
        $this->getName()->shouldBe('ETFSP500');
    }
}
