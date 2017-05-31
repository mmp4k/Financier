<?php

namespace Domain\ETFSP500\NotifierRule\Factory;

use Domain\Notifier\NotifierRule;
use Domain\Notifier\NotifierRuleFactory;

class Daily implements NotifierRuleFactory
{
    public function support(string $class)
    {
        return \Domain\ETFSP500\NotifierRule\Daily::class === $class;
    }

    public function create(array $options): NotifierRule
    {
        return new \Domain\ETFSP500\NotifierRule\Daily();
    }
}