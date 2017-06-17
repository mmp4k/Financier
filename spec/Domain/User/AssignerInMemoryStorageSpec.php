<?php

namespace spec\Domain\User;

use Domain\User\AssignerInMemoryStorage;
use Domain\User\AssignerStorage;
use Domain\User\FinderStorage;
use Domain\User\User;
use Domain\User\UserResource;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Ramsey\Uuid\UuidInterface;

class AssignerInMemoryStorageSpec extends ObjectBehavior
{
    function let()
    {
        $this->shouldImplement(AssignerStorage::class);
        $this->shouldImplement(FinderStorage::class);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(AssignerInMemoryStorage::class);
    }

    function it_assigns_resource(UserResource $userResource, UuidInterface $uuid, User $user, UuidInterface $userId)
    {
        $userId->equals($userId)->willReturn(true);
        $user->id()->willReturn($userId);

        $userResource->resourceType()->willReturn('SOME-TYPE');
        $userResource->id()->willReturn($uuid);
        $userResource->user()->willReturn($user);

        $this->assign($userResource);
        $this->findByType('SOME-TYPE')->shouldBe([$uuid]);
        $this->findByTypeAndUser('SOME-TYPE', $user)->shouldBe([$uuid]);
    }

    function it_does_not_found_resource_if_type_not_matched(UserResource $userResource, UuidInterface $uuid, User $user)
    {
        $userResource->resourceType()->willReturn('SOME-TYPE2');
        $userResource->id()->willReturn($uuid);

        $this->assign($userResource);
        $this->findByType('SOME-TYPE')->shouldBe([]);
        $this->findByTypeAndUser('SOME-TYPE', $user)->shouldBe([]);
    }

    function it_does_not_found_resource_if_user_not_matched(UserResource $userResource, UuidInterface $uuid, User $user, UuidInterface $userId)
    {
        $userId->equals($userId)->willReturn(false);
        $user->id()->willReturn($userId);

        $userResource->resourceType()->willReturn('SOME-TYPE');
        $userResource->id()->willReturn($uuid);
        $userResource->user()->willReturn($user);

        $this->assign($userResource);
        $this->findByType('SOME-TYPE')->shouldBe([$uuid]);
        $this->findByTypeAndUser('SOME-TYPE', $user)->shouldBe([]);
    }

    function it_finds_user(UserResource $userResource, UuidInterface $uuid, User $user)
    {
        $uuid->equals($uuid)->willReturn(true);
        $userResource->resourceType()->willReturn('SOME-TYPE');
        $userResource->id()->willReturn($uuid);
        $userResource->user()->willReturn($user);

        $this->assign($userResource);
        $this->findByTypeAndResource('SOME-TYPE', $uuid)->shouldBe($user);
    }

    function it_does_not_find_user_if_type_not_matched(UserResource $userResource, UuidInterface $uuid)
    {
        $userResource->resourceType()->willReturn('SOME-TYPE');

        $this->assign($userResource);
        $this->findByTypeAndResource('SOME-TYPE2', $uuid);
    }

    function it_does_not_find_user_if_resource_not_matched(UserResource $userResource, UuidInterface $uuid)
    {
        $uuid->equals($uuid)->willReturn(false);
        $userResource->resourceType()->willReturn('SOME-TYPE');
        $userResource->id()->willReturn($uuid);

        $this->assign($userResource);
        $this->findByTypeAndResource('SOME-TYPE', $uuid);
    }
}
