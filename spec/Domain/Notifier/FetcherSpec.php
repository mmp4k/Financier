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
//
//    function it_gets_notifier_rules(UuidInterface $id, FetcherStorage $storage, NotifierRuleFactory $notifierRuleFactory, NotifierRuleFactory $notifierRuleFactory2)
//    {
//        $this->addFactory($notifierRuleFactory);
//        $this->addFactory($notifierRuleFactory2);
//
//        $notifierRuleFactory->support('Domain\ETFSP500\NotifierRule\LessThan')->willReturn(true);
//        $notifierRuleFactory->support('Domain\ETFSP500\NotifierRule\LessThanAverage')->willReturn(false);
//        $notifierRuleFactory->create([
//            'minValue' => 90,
//            'id' => $id,
//        ])->shouldBeCalled();
//        $notifierRuleFactory->create([
//            'minValue' => 90,
//            'id' => $id,
//        ])->willReturn($lessThan);
//        $notifierRuleFactory->support('Domain\ETFSP500\NotifierRule\LessThan')->shouldBeCalled();
//
//        $notifierRuleFactory2->support('Domain\ETFSP500\NotifierRule\LessThan')->willReturn(false);
//        $notifierRuleFactory2->support('Domain\ETFSP500\NotifierRule\LessThanAverage')->willReturn(true);
//        $notifierRuleFactory2->create(['id' => $id])->shouldBeCalled();
//        $notifierRuleFactory2->create(['id' => $id])->willReturn($lessThanAverage);
//        $notifierRuleFactory2->support('Domain\ETFSP500\NotifierRule\LessThanAverage')->shouldBeCalled();
//
//        $storage->getNotifierRules()->shouldBeCalled();
//
//        $storage->getNotifierRules()->willReturn([
//            [
//                'id' => $id,
//                'class' => 'Domain\ETFSP500\NotifierRule\LessThan',
//                'options' => [
//                    'minValue' => 90,
//                ],
//            ],
//            [
//                'id' => $id,
//                'class' => 'Domain\ETFSP500\NotifierRule\LessThanAverage',
//                'options' => [
//                ],
//            ]
//        ]);
//        $this->getNotifierRules()->shouldBeArray();
//        $objRules = $this->getNotifierRules();
//        $objRules[0]->shouldImplement(LessThan::class);
//        $objRules[0]->shouldImplement(NotifierRule::class);
//        $objRules[1]->shouldImplement(LessThanAverage::class);
//        $objRules[1]->shouldImplement(NotifierRule::class);
//    }
}
