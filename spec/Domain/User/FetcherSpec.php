<?php

namespace spec\Domain\User;

use Domain\User\Fetcher;
use Domain\User\FetcherStorage;
use Domain\User\User;
use PhpSpec\ObjectBehavior;
use PhpSpec\Wrapper\Subject;
use Prophecy\Argument;

class FetcherSpec extends ObjectBehavior
{
    function let(FetcherStorage $fetcherStorage)
    {
        $this->beConstructedWith($fetcherStorage);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(Fetcher::class);
    }

    function it_finds_user_by_identify(FetcherStorage $fetcherStorage)
    {
        $fetcherStorage->findUserByIdentify('random@email.pl')->shouldBeCalled();
        $fetcherStorage->findUserByIdentify('random@email.pl')->willReturn([
            'identify' => 'random@email.pl',
            'id' => '5',
        ]);

        /** @var User|Subject $user */
        $user = $this->findUserByIdentify('random@email.pl');
        $user->shouldBeAnInstanceOf(User::class);
        $user->beAnInstanceOf(User::class);
        $user->identifier()->shouldBe('random@email.pl');
    }

    function it_checks_that_user_exists(FetcherStorage $fetcherStorage, User $user)
    {
        $fetcherStorage->findUserByIdentify('random@email.pl')->willReturn([
            'identify' => 'random@email.pl',
            'id' => '5',
        ]);
        $user->identifier()->willReturn('random@email.pl');

        $this->exists($user)->shouldBe(true);
    }
}
