<?php

namespace Domain\ETFSP500\NotifierRule;

use Domain\ETFSP500\BusinessDay;
use Domain\ETFSP500\Storage;
use Domain\Notifier\NotifierRule;

class LessThanAverage implements NotifierRule
{
    /**
     * @var Storage
     */
    private $storage;

    /**
     * @var BusinessDay
     */
    private $businessDay;

    public function __construct(Storage $storage, BusinessDay $businessDay)
    {
        $this->storage = $storage;
        $this->businessDay = $businessDay;
    }

    public function notify(): bool
    {
        if ($this->storage->getCurrentValue($this->businessDay) <= $this->storage->getAverageFromLastTenMonths()) {
            return true;
        }

        return false;
    }

    public function getCurrentValue()
    {
        return $this->storage->getCurrentValue($this->businessDay);
    }

    public function getAverageFromLastTenMonths()
    {
        return $this->storage->getAverageFromLastTenMonths();
    }
}
