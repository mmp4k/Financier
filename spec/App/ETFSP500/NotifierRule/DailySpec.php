<?php

namespace spec\App\ETFSP500\NotifierRule;

use App\ETFSP500\NotifierRule\Daily;
use App\NotifierRule;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class DailySpec extends ObjectBehavior
{
    function let()
    {
        $this->shouldImplement(NotifierRule::class);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(Daily::class);
    }
}
