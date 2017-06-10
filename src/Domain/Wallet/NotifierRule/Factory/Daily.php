<?php

namespace Domain\Wallet\NotifierRule\Factory;

use Domain\Notifier\NotifierRule;
use Domain\Notifier\NotifierRuleFactory;

class Daily implements NotifierRuleFactory
{
    public function support(string $class)
    {
        return \Domain\Wallet\NotifierRule\Daily::class === $class;
    }

    public function create(array $options): NotifierRule
    {
        $rule = new \Domain\Wallet\NotifierRule\Daily();
        $rule->setId($options['id']);
        return $rule;
    }
}