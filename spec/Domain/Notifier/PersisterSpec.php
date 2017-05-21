<?php

namespace spec\Domain\Notifier;

use Domain\Notifier\Persister;
use Domain\Notifier\PersisterStorage;
use Domain\Notifier\PersistableNotifierRule;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class PersisterSpec extends ObjectBehavior
{
    function let(PersisterStorage $persisterStorage)
    {
        $this->beConstructedWith($persisterStorage);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(Persister::class);
    }

    function it_persists(PersistableNotifierRule $persistableNotifierRule, PersisterStorage $persisterStorage)
    {
        $persisterStorage->persist($persistableNotifierRule)->shouldBeCalled();

        $this->persist($persistableNotifierRule);
    }
}
