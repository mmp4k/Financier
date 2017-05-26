<?php

namespace Domain\Notifier;

use Domain\ETFSP500\BusinessDay;
use Domain\ETFSP500\NotifierRule\Daily;
use Domain\ETFSP500\NotifierRule\LessThan;
use Domain\ETFSP500\NotifierRule\LessThanAverage;
use Domain\ETFSP500\Storage as ETFSP500Storage;

class Fetcher
{
    /**
     * @var FetcherStorage
     */
    private $storage;
    /**
     * @var ETFSP500Storage
     */
    private $etfsp500Storage;

    /**
     * @var NotifierRuleFactory[]
     */
    private $factories = [];

    public function __construct(FetcherStorage $storage, ETFSP500Storage $etfsp500Storage)
    {
        $this->storage = $storage;
        $this->etfsp500Storage = $etfsp500Storage;
    }

    /**
     * @return NotifierRule[]|PersistableNotifierRule[]
     */
    public function getNotifierRules()
    {
        $arrayRules = $this->storage->getNotifierRules();

        $rules = [];

        foreach ($arrayRules as $rule) {
            $options = $rule['options'];

            foreach ($this->factories as $factory) {
                if (!$factory->support($rule['class'])) {
                    continue;
                }

                $rules[] = $factory->create($options);
            }
        }

        return $rules;
    }

    public function addFactory(NotifierRuleFactory $factory)
    {
        $this->factories[] = $factory;
    }
}
