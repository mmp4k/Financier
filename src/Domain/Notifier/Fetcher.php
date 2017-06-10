<?php

namespace Domain\Notifier;

use Domain\ETFSP500\Storage as ETFSP500Storage;
use Ramsey\Uuid\UuidInterface;

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
            $options['id'] = $rule['id'];

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

    public function findRule(UuidInterface $id)
    {
        $rules = $this->getNotifierRules();

        foreach ($rules as $rule) {
            if ($rule->id()->equals($id)) {
                return $rule;
            }
        }

        return null;
    }
}
