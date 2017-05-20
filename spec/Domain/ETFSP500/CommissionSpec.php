<?php

namespace spec\Domain\ETFSP500;

use Domain\ETFSP500\Commission;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class CommissionSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith(5.0, 6.0);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(Commission::class);
    }

    function it_stores_commission_in()
    {
        $this->commissionIn()->shouldBe(5.0);
    }

    function it_stores_commission_out()
    {
        $this->commissionOut()->shouldBe(6.0);
    }

    function it_counts_sum_of_commissions()
    {
        $this->sumOfCommissions()->shouldBe(11.0);
    }
}
