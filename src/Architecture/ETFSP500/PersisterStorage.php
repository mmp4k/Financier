<?php

namespace Architecture\ETFSP500;

use Domain\ETFSP500\DailyAverage;
use Domain\ETFSP500\MonthlyAverage;

interface PersisterStorage
{
    public function persistMonthlyAverage(MonthlyAverage $monthlyAverage) : void;

    public function persistDailyAverage(DailyAverage $dailyAverage) : void;
}
