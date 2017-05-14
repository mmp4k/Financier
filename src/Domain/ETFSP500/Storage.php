<?php

namespace Domain\ETFSP500;

interface Storage
{
    public function getCurrentValue(BusinessDay $businessDay) : float;

    public function getAverageFromLastTenMonths() : float;
}
