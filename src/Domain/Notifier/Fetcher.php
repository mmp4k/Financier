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

            switch($rule['class']) {
                case 'Domain\ETFSP500\NotifierRule\LessThan':
                    $ruleObj = new LessThan($this->etfsp500Storage, $options['minValue'], new BusinessDay(new \DateTime()));
                    break;
                case 'Domain\ETFSP500\NotifierRule\LessThanAverage':
                    $ruleObj = new LessThanAverage($this->etfsp500Storage, new BusinessDay(new \DateTime()));
                    break;
                case 'Domain\ETFSP500\NotifierRule\Daily':
                    $ruleObj = new Daily();
                    break;
                default:
                    throw new \DomainException("Not defined creator for notifier rule.");
                    break;
            }
            $rules[] = $ruleObj;
        }

        return $rules;
    }
}
