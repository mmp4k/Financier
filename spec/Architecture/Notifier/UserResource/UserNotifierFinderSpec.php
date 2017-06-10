<?php

namespace spec\Architecture\Notifier\UserResource;

use Architecture\Notifier\UserResource\UserNotifierFinder;
use Architecture\Notifier\UserResource\UserNotifierRule;
use Domain\Notifier\Fetcher;
use Domain\Notifier\NotifierRule;
use Domain\User\User;
use Domain\User\UserResourceFinder;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Ramsey\Uuid\UuidInterface;

class UserNotifierFinderSpec extends ObjectBehavior
{
    function let(UserResourceFinder $finder, Fetcher $fetcher)
    {
        $this->beConstructedWith($finder, $fetcher);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(UserNotifierFinder::class);
    }

    function it_finds_user_rules(UserResourceFinder $finder, Fetcher $fetcher, User $user, UuidInterface $idResource, NotifierRule $rule)
    {

        $finder->findByTypeAndUser(UserNotifierRule::class, $user)->shouldBeCalled();
        $finder->findByTypeAndUser(UserNotifierRule::class, $user)->willReturn([$idResource]);
        $fetcher->findRule($idResource)->shouldBeCalled();
        $fetcher->findRule($idResource)->willReturn($rule);

        $rules = $this->findRules($user);
        $rules->shouldBeArray();
        $rules[0]->shouldBeAnInstanceOf(UserNotifierRule::class);
    }
}
