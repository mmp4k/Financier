<?php

namespace App\ETFSP500;

use App\NotifierRule;

class LessThanAverage implements NotifierRule
{
    /**
     * @var Storage
     */
    private $storage;
    /**
     * @var LessThan
     */
    private $lessThan;

    public function __construct(Storage $storage)
    {
        $this->storage = $storage;
    }

    public function notify(): bool
    {
        if ($this->storage->getCurrentValue() < $this->storage->getAverageFromLastTenMonths()) {
            return true;
        }

        return false;
    }
}
