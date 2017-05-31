<?php

namespace Domain\ETFSP500;

interface PersisterStorage
{
    public function persistMonthlyAverage(MonthlyAverage $monthlyAverage) : void;

    public function persistDailyAverage(DailyAverage $dailyAverage) : void;
}
