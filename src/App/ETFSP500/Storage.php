<?php

namespace App\ETFSP500;

interface Storage
{

    public function getCurrentValue();

    public function getAverageFromLastTenMonths();
}
