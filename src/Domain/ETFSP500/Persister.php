<?php

namespace Domain\ETFSP500;

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
