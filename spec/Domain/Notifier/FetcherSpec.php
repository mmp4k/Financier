<?php

namespace spec\Domain\Notifier;

use Domain\ETFSP500\NotifierRule\Daily;
use Domain\ETFSP500\NotifierRule\LessThan;
use Domain\ETFSP500\NotifierRule\LessThanAverage;
use Domain\Notifier\Fetcher;
use Domain\Notifier\FetcherStorage;
use Domain\Notifier\NotifierRule;
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

    function it_gets_notifier_rules(FetcherStorage $storage)
    {
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
            ],
            [
                'class' => 'Domain\ETFSP500\NotifierRule\Daily',
                'options' => [],
            ]
        ]);
        $this->getNotifierRules()->shouldBeArray();
        $objRules = $this->getNotifierRules();
        $objRules[0]->shouldImplement(LessThan::class);
        $objRules[0]->shouldImplement(NotifierRule::class);
        $objRules[1]->shouldImplement(LessThanAverage::class);
        $objRules[1]->shouldImplement(NotifierRule::class);
        $objRules[2]->shouldImplement(Daily::class);
        $objRules[2]->shouldImplement(NotifierRule::class);
    }
}
