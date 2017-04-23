<?php

namespace spec\App\ETFSP500;

use App\ETFSP500\DailyAverage;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class DailyAverageSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith(new \DateTime(), 1.2);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(DailyAverage::class);
    }

    function it_return_date()
    {
        $this->date()->shouldBeAnInstanceOf(\DateTime::class);
    }
//
    function it_return_average()
    {
        $this->average()->shouldBeFloat();
    }
}
