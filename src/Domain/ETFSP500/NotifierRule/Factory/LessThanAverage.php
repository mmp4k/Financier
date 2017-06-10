<?php

namespace Domain\ETFSP500\NotifierRule\Factory;

use Domain\ETFSP500\BusinessDay;
use Domain\ETFSP500\Storage;
use Domain\Notifier\NotifierRule;
use Domain\Notifier\NotifierRuleFactory;

class LessThanAverage implements NotifierRuleFactory
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
        return \Domain\ETFSP500\NotifierRule\LessThanAverage::class === $class;
    }

    public function create(array $options): NotifierRule
    {
        $rule = new \Domain\ETFSP500\NotifierRule\LessThanAverage($this->storage, $this->businessDay);
        $rule->setId($options['id']);
        return $rule;
    }
}