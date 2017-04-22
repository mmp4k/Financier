<?php

namespace App\ETFSP500\Storage;

use App\ETFSP500\Storage;

class TestStorage implements Storage
{
    private $currentValue;
    private $average;

    public function setCurrentValue($currentValue)
    {
        $this->currentValue = $currentValue;
    }

    public function setAverageFromLastTenMonths($average)
    {
        $this->average = $average;
    }
    public function getCurrentValue(): float
    {
        return (float) $this->currentValue;
    }

    public function getAverageFromLastTenMonths(): float
    {
        return (float) $this->average;
    }

}