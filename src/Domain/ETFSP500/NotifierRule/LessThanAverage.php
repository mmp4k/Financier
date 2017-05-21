<?php

namespace Domain\ETFSP500\NotifierRule;

use Domain\ETFSP500\BusinessDay;
use Domain\ETFSP500\Storage;
use Domain\Notifier\NotifierRule;
use Domain\Notifier\PersistableNotifierRule;

class LessThanAverage implements NotifierRule, PersistableNotifierRule
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

    public function persistConfig(): array
    {
        return [];
    }
}
