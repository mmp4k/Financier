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

    function it_returns_current(DailyAverage $dailyAverage)
    {
        $this->add($dailyAverage);
        $this->current()->shouldBe($dailyAverage);
    }

    function it_increment_iterator(DailyAverage $dailyAverage)
    {
        $this->add($dailyAverage);
        $this->next();
        $this->key()->shouldBe(1);
    }

    function it_checks_next_value_exists()
    {
        $this->valid()->shouldBe(false);
    }

    function it_rewinds_iterator(DailyAverage $dailyAverage)
    {
        $this->add($dailyAverage);
        $this->rewind();
        $this->key()->shouldBe(0);
    }
}
