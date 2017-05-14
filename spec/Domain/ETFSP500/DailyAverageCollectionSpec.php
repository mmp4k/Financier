<?php

namespace spec\Domain\ETFSP500;

use Domain\ETFSP500\DailyAverage;
use Domain\ETFSP500\DailyAverageCollection;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class DailyAverageCollectionSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(DailyAverageCollection::class);
    }

    function it_accepts_daily_average(DailyAverage $dailyAverage)
    {
        $this->add($dailyAverage);
    }
}
