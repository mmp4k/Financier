<?php

namespace Domain\ETFSP500;

use Domain\NotifierRule;

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

    public function __construct(Storage $storage, float $minValue)
    {
        $this->storage = $storage;
        $this->minValue = $minValue;
    }

    public function notify(): bool
    {
        if ($this->minValue > $this->storage->getCurrentValue()) {
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
        return $this->storage->getCurrentValue();
    }
}
