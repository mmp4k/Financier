<?php

namespace Domain\ETFSP500;

use Domain\Notifier\NotifierRule;

class LessThan implements NotifierRule
{
    /**
     * @var Storage
     */
    private $storage;

    /**
     * @var float
     */
    private $minValue;
    /**
     * @var BusinessDay
     */
    private $businessDay;

    public function __construct(Storage $storage, float $minValue, BusinessDay $businessDay)
    {
        $this->storage = $storage;
        $this->minValue = $minValue;
        $this->businessDay = $businessDay;
    }

    public function notify(): bool
    {
        if ($this->minValue > $this->storage->getCurrentValue($this->businessDay)) {
            return true;
        }

        return false;
    }

    public function getMinValue()
    {
        return $this->minValue;
    }

    public function getCurrentValue()
    {
        return $this->storage->getCurrentValue($this->businessDay);
    }
}
