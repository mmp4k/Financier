<?php

namespace spec\Domain\User;

use Domain\User\FinderStorage;
use Domain\User\User;
use Domain\User\UserResource;
use Domain\User\UserResourceFinder;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Ramsey\Uuid\UuidInterface;

class UserResourceFinderSpec extends ObjectBehavior
{
    function let(FinderStorage $finderStorage)
    {
        $this->beConstructedWith($finderStorage);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(UserResourceFinder::class);
    }

    function it_finds_by_type(FinderStorage $finderStorage, UuidInterface $uuid)
    {
        $type = 'some_type';
        $finderStorage->findByType($type)->shouldBeCalled();
        $finderStorage->findByType($type)->willReturn([$uuid]);

        $resources = $this->findByType($type);

        $resources->shouldBeArray();
        $resources[0]->shouldBeAnInstanceOf(UuidInterface::class);
    }

    function it_finds_by_type_and_user(FinderStorage $finderStorage, User $user, UuidInterface $uuid)
    {
        $type = 'some_type';
        $finderStorage->findByTypeAndUser($type, $user)->shouldBeCalled();
        $finderStorage->findByTypeAndUser($type, $user)->willReturn([$uuid]);

        $resources = $this->findByTypeAndUser($type, $user);

        $resources->shouldBeArray();
        $resources[0]->shouldBeAnInstanceOf(UuidInterface::class);
    }

    function it_finds_by_type_and_resource(FinderStorage $finderStorage, UuidInterface $idResource, User $user)
    {
        $type = 'some_type';
        $finderStorage->findByTypeAndResource($type, $idResource)->shouldBeCalled();
        $finderStorage->findByTypeAndResource($type, $idResource)->willReturn($user);

        $user = $this->findByTypeAndResource($type, $idResource);

        $user->shouldBeAnInstanceOf(User::class);
    }
}
