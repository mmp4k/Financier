<?php

namespace Domain\ETFSP500\NotifierRule;

use Domain\ETFSP500\BusinessDay;
use Domain\ETFSP500\Storage;
use Domain\Notifier\NotifierRule;
use Domain\Notifier\PersistableNotifierRule;

class LessThan implements NotifierRule, PersistableNotifierRule
{
    const CONFIG_MIN_VALUE = 'minValue';

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

    public function persistConfig(): array
    {
        return [
            self::CONFIG_MIN_VALUE => $this->getMinValue()
        ];
    }
}
