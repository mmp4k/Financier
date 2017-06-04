<?php

namespace spec\Domain\User;

use Domain\User\User;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Ramsey\Uuid\UuidInterface;

class UserSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith('random-temporary-id');
    }

    function it_is_anonymous_user()
    {
        $this->identifier()->shouldBe('random-temporary-id');
    }

    function it_has_uuid()
    {
        $this->id()->shouldBeAnInstanceOf(UuidInterface::class);
    }
}
