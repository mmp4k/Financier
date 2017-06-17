<?php

namespace spec\Domain\Notifier;

use Domain\Notifier\Fetcher;
use Domain\Notifier\FetcherStorage;
use Domain\Notifier\NotifierRule;
use Domain\Notifier\NotifierRuleFactory;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Ramsey\Uuid\UuidInterface;

class FetcherSpec extends ObjectBehavior
{
    function let(FetcherStorage $storage)
    {
        $this->beConstructedWith($storage);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(Fetcher::class);
    }

    public function it_stores_rules_factory(NotifierRuleFactory $notifierRuleFactory)
    {
        $this->addFactory($notifierRuleFactory);
    }

    function it_finds_rule_by_uuid(UuidInterface $uuid, FetcherStorage $storage, NotifierRuleFactory $factory, NotifierRule $rule)
    {
        $this->addFactory($factory);

        $rule->id()->willReturn($uuid);
        $factory->support('Test')->willReturn(true);
        $factory->create(Argument::any())->willReturn($rule);
        $storage->getNotifierRules()->willReturn([
           [
               'class' => 'Test',
               'id' => $uuid,
               'options' => [
               ]
           ]
        ]);

        $this->findRule($uuid);
    }

    function it_does_not_found_rule_if_factory_does_not_support(UuidInterface $uuid, FetcherStorage $storage, NotifierRuleFactory $factory)
    {
        $this->addFactory($factory);
        $factory->support('Test')->willReturn(false);
        $storage->getNotifierRules()->willReturn([
            [
                'class' => 'Test',
                'id' => $uuid,
                'options' => [
                ]
            ]
        ]);

        $this->getNotifierRules()->shouldBe([]);
    }
}
