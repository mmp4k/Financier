<?php

namespace Architecture\ETFSP500;

use App\ETFSP500\DailyAverage;
use App\ETFSP500\MonthlyAverageCollection;

class Persister
{
    /**
     * @var PersisterStorage
     */
    private $storage;

    public function __construct(PersisterStorage $storage)
    {
        $this->storage = $storage;
    }

    public function saveMonthlyAverage(MonthlyAverageCollection $monthlyAverageCollection) : void
    {
        foreach ($monthlyAverageCollection as $monthlyAverage) {
            $this->storage->persistMonthlyAverage($monthlyAverage);
        }
    }

    public function saveDailyAverage(DailyAverage $dailyAverage) : void
    {
        $this->storage->persistDailyAverage($dailyAverage);
    }
}
