<?php

namespace Domain\ETFSP500\NotifierRule;

use Domain\ETFSP500\BusinessDay;
use Domain\ETFSP500\Storage;
use Domain\Notifier\NotifierRule;
use Domain\Notifier\PersistableNotifierRule;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

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

    /**
     * @var UuidInterface
     */
    private $id;

    public function __construct(Storage $storage, BusinessDay $businessDay)
    {
        $this->storage = $storage;
        $this->businessDay = $businessDay;
        $this->id = Uuid::uuid4();
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

    public function id(): UuidInterface
    {
        return $this->id;
    }

    public function setId(UuidInterface $id)
    {
        $this->id = $id;
    }
}
