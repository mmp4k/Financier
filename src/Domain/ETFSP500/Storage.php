<?php

namespace Domain\ETFSP500;

interface Storage
{
    public function getCurrentValue() : float;

    public function getAverageFromLastTenMonths() : float;
}
