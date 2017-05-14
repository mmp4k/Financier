<?php

namespace spec\Domain\ETFSP500;

use Domain\ETFSP500\MonthlyAverageCollection;
use Domain\ETFSP500\MonthlyAverage;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class MonthlyAverageCollectionSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(MonthlyAverageCollection::class);
    }

    function it_accepts_month_average(MonthlyAverage $monthlyAverage)
    {
        $this->add($monthlyAverage);
    }
}
