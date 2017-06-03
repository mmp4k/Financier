<?php

namespace spec\Domain\User;

use Domain\User\User;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class UserSpec extends ObjectBehavior
{
    function it_is_anonymous_user()
    {
        $this->beConstructedWith('random-temporary-id');
        $this->identifier()->shouldBe('random-temporary-id');
    }

}
