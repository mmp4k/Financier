<?php

namespace spec\Domain\User;

use Domain\User\Fetcher;
use Domain\User\FetcherStorage;
use Domain\User\Persister;
use Domain\User\PersisterStorage;
use Domain\User\User;
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

    function it_persists(PersisterStorage $persisterStorage, Fetcher $fetcher, User $user)
    {
        $fetcher->exists($user)->willReturn(false);

        $persisterStorage->persist($user)->willReturn(1);
        $persisterStorage->persist($user)->shouldBeCalled();
        $id = $this->persist($user);
        $id->shouldNotBeNull();
    }
}
