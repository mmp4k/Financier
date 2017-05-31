<?php

namespace Domain\ETFSP500\NotifierRule\Factory;

use Domain\ETFSP500\BusinessDay;
use Domain\ETFSP500\Storage;
use Domain\Notifier\NotifierRule;
use Domain\Notifier\NotifierRuleFactory;

class LessThan implements NotifierRuleFactory
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

    public function support(string $class)
    {
        return \Domain\ETFSP500\NotifierRule\LessThan::class === $class;
    }

    public function create(array $options): NotifierRule
    {
        return new \Domain\ETFSP500\NotifierRule\LessThan($this->storage, $options[\Domain\ETFSP500\NotifierRule\LessThan::CONFIG_MIN_VALUE], $this->businessDay);
    }
}