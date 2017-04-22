<?php

namespace spec\App\ETFSP500;

use App\ETFSP500\MonthlyAverage;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class MonthlyAverageSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith(1, 12, 23.2);
    }
    function it_is_initializable()
    {
        $this->shouldHaveType(MonthlyAverage::class);
    }

    function it_returns_month()
    {
        $this->month()->shouldBeNumeric();
    }

    function it_returns_year()
    {
        $this->year()->shouldBeNumeric();
    }

    function it_returns_average()
    {
        $this->average()->shouldBeFloat();
    }
}
