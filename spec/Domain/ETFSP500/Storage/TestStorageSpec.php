<?php

namespace spec\Domain\ETFSP500\Storage;

use Domain\ETFSP500\BusinessDay;
use Domain\ETFSP500\Storage\TestStorage;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class TestStorageSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(TestStorage::class);
    }

    function it_stores_current_value(BusinessDay $businessDay)
    {
        $this->setCurrentValue(5);
        $this->getCurrentValue($businessDay)->shouldBe(5.0);
    }

    function it_stores_average_since_last_ten_months()
    {
        $this->setAverageFromLastTenMonths(10);
        $this->getAverageFromLastTenMonths()->shouldBe(10.0);
    }
}
