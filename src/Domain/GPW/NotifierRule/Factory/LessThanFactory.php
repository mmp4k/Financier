<?php

namespace Domain\GPW\NotifierRule\Factory;

use Domain\GPW\Asset;
use Domain\GPW\NotifierRule\LessThan;
use Domain\Notifier\NotifierRule;
use Domain\Notifier\NotifierRuleFactory;

class LessThanFactory implements NotifierRuleFactory
{
    public function support(string $class)
    {
        return $class === LessThan::class;
    }

    public function create(array $options): NotifierRule
    {
        $lessThan = new LessThan(
            new Asset($options[LessThan::ASSET_NAME]),
            $options[LessThan::MIN_VALUE]
        );

        $lessThan->setId($options['id']);

        return $lessThan;
    }
}