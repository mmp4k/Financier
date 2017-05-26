<?php

namespace spec\Domain\Notifier;

use Domain\ETFSP500\BusinessDay;
use Domain\ETFSP500\NotifierRule\Daily;
use Domain\ETFSP500\NotifierRule\LessThan;
use Domain\ETFSP500\NotifierRule\LessThanAverage;
use Domain\Notifier\Fetcher;
use Domain\Notifier\FetcherStorage;
use Domain\Notifier\NotifierRule;
use Domain\Notifier\NotifierRuleFactory;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Domain\ETFSP500\Storage as ETFSP500Storage;

class FetcherSpec extends ObjectBehavior
{
    function let(FetcherStorage $storage, ETFSP500Storage $etfsp500Storage)
    {
        $this->beConstructedWith($storage, $etfsp500Storage);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(Fetcher::class);
    }

    public function it_stores_rules_factory(NotifierRuleFactory $notifierRuleFactory)
    {
        $this->addFactory($notifierRuleFactory);
    }

    function it_gets_notifier_rules(FetcherStorage $storage, NotifierRuleFactory $notifierRuleFactory, LessThan $lessThan, NotifierRuleFactory $notifierRuleFactory2, LessThanAverage $lessThanAverage)
    {
        $this->addFactory($notifierRuleFactory);
        $this->addFactory($notifierRuleFactory2);

        $notifierRuleFactory->support('Domain\ETFSP500\NotifierRule\LessThan')->willReturn(true);
        $notifierRuleFactory->support('Domain\ETFSP500\NotifierRule\LessThanAverage')->willReturn(false);
        $notifierRuleFactory->create([
            'minValue' => 90
        ])->shouldBeCalled();
        $notifierRuleFactory->create([
            'minValue' => 90
        ])->willReturn($lessThan);
        $notifierRuleFactory->support('Domain\ETFSP500\NotifierRule\LessThan')->shouldBeCalled();

        $notifierRuleFactory2->support('Domain\ETFSP500\NotifierRule\LessThan')->willReturn(false);
        $notifierRuleFactory2->support('Domain\ETFSP500\NotifierRule\LessThanAverage')->willReturn(true);
        $notifierRuleFactory2->create([])->shouldBeCalled();
        $notifierRuleFactory2->create([])->willReturn($lessThanAverage);
        $notifierRuleFactory2->support('Domain\ETFSP500\NotifierRule\LessThanAverage')->shouldBeCalled();

        $storage->getNotifierRules()->shouldBeCalled();

        $storage->getNotifierRules()->willReturn([
            [
                'class' => 'Domain\ETFSP500\NotifierRule\LessThan',
                'options' => [
                    'minValue' => 90
                ],
            ],
            [
                'class' => 'Domain\ETFSP500\NotifierRule\LessThanAverage',
                'options' => [],
            ]
        ]);
        $this->getNotifierRules()->shouldBeArray();
        $objRules = $this->getNotifierRules();
        $objRules[0]->shouldImplement(LessThan::class);
        $objRules[0]->shouldImplement(NotifierRule::class);
        $objRules[1]->shouldImplement(LessThanAverage::class);
        $objRules[1]->shouldImplement(NotifierRule::class);
    }
}
