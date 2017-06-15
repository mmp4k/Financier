<?php

namespace spec\Domain\GPW;

use Domain\GPW\ClosingPrice;
use Domain\GPW\Persister;
use Domain\GPW\Persister\PersistStorage;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class PersisterSpec extends ObjectBehavior
{
    function let(PersistStorage $storage)
    {
        $this->beConstructedWith($storage);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(Persister::class);
    }

    function it_persists_closing_price(PersistStorage $storage, ClosingPrice $closingPrice)
    {
        $storage->persist($closingPrice)->shouldBeCalled();
        $this->persist($closingPrice);
    }
}
