<?php

namespace spec\App\ETFSP500;

use App\ETFSP500\DailyAverage;
use App\ETFSP500\DailyAverageCollection;
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
