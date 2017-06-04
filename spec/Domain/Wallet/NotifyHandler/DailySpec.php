<?php

namespace spec\Domain\Wallet\NotifyHandler;

use Domain\ETFSP500\BusinessDay;
use Domain\Wallet\NotifyHandler\Daily;
use Domain\ETFSP500\Storage;
use Domain\Wallet\Wallet;
use Domain\Notifier\NotifierRule;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class DailySpec extends ObjectBehavior
{
    function let(Wallet $wallet, Storage $storage, BusinessDay $businessDay)
    {
        $this->beConstructedWith($wallet, $storage, $businessDay);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(Daily::class);
    }

    function it_supports_daily_rule(\Domain\Wallet\NotifierRule\Daily $daily)
    {
        $this->isSupported($daily)->shouldBe(true);
    }

    function it_prepares_body_for_notify(Wallet $wallet, Storage $storage, NotifierRule $notifierRule, BusinessDay $businessDay)
    {
        $storage->getCurrentValue($businessDay)->willReturn(5);

        $wallet->boughtAssets()->willReturn(1);
        $wallet->boughtValue()->willReturn(1);
        $wallet->valueOfInvestment()->willReturn(1);
        $wallet->currentValue(5, 5.0)->willReturn(1);
        $wallet->profit(5, 5.0)->willReturn(1);

        $this->prepareBody($notifierRule)->shouldBeString();
    }
}
