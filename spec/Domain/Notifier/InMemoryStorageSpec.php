<?php

namespace spec\Domain\Notifier;

use Domain\Notifier\FetcherStorage;
use Domain\Notifier\InMemoryStorage;
use Domain\Notifier\NotifierRule;
use Domain\Notifier\PersisterStorage;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Ramsey\Uuid\UuidInterface;

class InMemoryStorageSpec extends ObjectBehavior
{
    function let()
    {
        $this->shouldImplement(FetcherStorage::class);
        $this->shouldImplement(PersisterStorage::class);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(InMemoryStorage::class);
    }

    function it_persists_rules(NotifierRule $rule)
    {
        $this->persist($rule);
    }

    function it_stores_rules(NotifierRule $rule, UuidInterface $uuid)
    {
        $rule->id()->willReturn($uuid);
        $rule->persistConfig()->willReturn([
        ]);
        $this->persist($rule);

        $this->getNotifierRules()->shouldHaveCount(1);
    }
}
