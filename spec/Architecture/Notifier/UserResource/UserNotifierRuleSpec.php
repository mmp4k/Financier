<?php

namespace spec\Architecture\Notifier\UserResource;

use Architecture\Notifier\UserResource\UserNotifierRule;
use Domain\Notifier\NotifierRule;
use Domain\User\Assigner;
use Domain\User\User;
use Domain\User\UserResource;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class UserNotifierRuleSpec extends ObjectBehavior
{
    function let(NotifierRule $rule, User $user)
    {
        $this->beConstructedWith($rule, $user);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(UserNotifierRule::class);
        $this->shouldImplement(UserResource::class);
    }

    function it_is_assigable_by_user(Assigner $assigner)
    {
        $assigner->assign($this);
    }
}
