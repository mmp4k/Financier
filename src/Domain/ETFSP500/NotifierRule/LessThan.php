<?php

namespace Domain\ETFSP500\NotifierRule;

use Domain\ETFSP500\BusinessDay;
use Domain\ETFSP500\Storage;
use Domain\Notifier\NotifierRule;
use Domain\Notifier\PersistableNotifierRule;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

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

    /**
     * @var UuidInterface
     */
    private $id;

    public function __construct(Storage $storage, float $minValue, BusinessDay $businessDay)
    {
        $this->storage = $storage;
        $this->minValue = $minValue;
        $this->businessDay = $businessDay;
        $this->id = Uuid::uuid4();
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

    public function id(): UuidInterface
    {
        return $this->id;
    }

    public function setId(UuidInterface $id)
    {
        $this->id = $id;
    }
}
