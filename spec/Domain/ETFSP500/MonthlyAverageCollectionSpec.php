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

    function it_returns_current(MonthlyAverage $monthlyAverage)
    {
        $this->add($monthlyAverage);
        $this->current()->shouldBe($monthlyAverage);
    }

    function it_increment_iterator(MonthlyAverage $monthlyAverage)
    {
        $this->add($monthlyAverage);
        $this->next();
        $this->key()->shouldBe(1);
    }

    function it_checks_next_value_exists()
    {
        $this->valid()->shouldBe(false);
    }

    function it_rewinds_iterator(MonthlyAverage $monthlyAverage)
    {
        $this->add($monthlyAverage);
        $this->rewind();
        $this->key()->shouldBe(0);
    }
}
