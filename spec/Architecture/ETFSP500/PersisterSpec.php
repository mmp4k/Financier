<?php

namespace spec\Architecture\ETFSP500;

use Domain\ETFSP500\MonthlyAverage;
use Domain\ETFSP500\DailyAverage;
use Domain\ETFSP500\MonthlyAverageCollection;
use Architecture\ETFSP500\Persister;
use Architecture\ETFSP500\PersisterStorage;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class PersisterSpec extends ObjectBehavior
{
    function let(PersisterStorage $storage)
    {
        $this->beConstructedWith($storage);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(Persister::class);
    }

    function it_saves_monthly_average(PersisterStorage $storage, MonthlyAverageCollection $monthlyAverageCollection, MonthlyAverage $monthlyAverage)
    {
        $monthlyAverageCollection->add($monthlyAverage);
        $monthlyAverageCollection->valid()->willReturn(true, false);
        $monthlyAverageCollection->rewind()->willReturn();
        $monthlyAverageCollection->count()->willReturn(1);
        $monthlyAverageCollection->next()->willReturn(2);
        $monthlyAverageCollection->current()->willReturn($monthlyAverage);

        $this->saveMonthlyAverage($monthlyAverageCollection);
        $storage->persistMonthlyAverage($monthlyAverage)->shouldHaveBeenCalled();
    }

    function it_saves_daily_average(PersisterStorage $storage, DailyAverage $dailyAverage)
    {
        $this->saveDailyAverage($dailyAverage);
        $storage->persistDailyAverage($dailyAverage)->shouldHaveBeenCalled();
    }
}
