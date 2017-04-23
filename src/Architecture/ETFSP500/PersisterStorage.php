<?php

namespace Architecture\ETFSP500;

use App\ETFSP500\DailyAverage;
use App\ETFSP500\MonthlyAverage;

interface PersisterStorage
{
    public function persistMonthlyAverage(MonthlyAverage $monthlyAverage) : void;

    public function persistDailyAverage(DailyAverage $dailyAverage) : void;
}
