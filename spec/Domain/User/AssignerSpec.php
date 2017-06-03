<?php

namespace spec\Domain\User;

use Domain\User\Assigner;
use Domain\User\AssignerStorage;
use Domain\User\User;
use Domain\User\UserResource;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class AssignerSpec extends ObjectBehavior
{
    function let(AssignerStorage $storage)
    {
        $this->beConstructedWith($storage);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(Assigner::class);
    }

    function it_assigns_resource_to_user(AssignerStorage $storage, UserResource $resource)
    {
        $storage->assign($resource)->shouldBeCalled();
        $this->assign($resource);
    }
}
