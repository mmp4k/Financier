<?php

namespace Domain\GPW\NotifierRule\Factory;

use Domain\GPW\Asset;
use Domain\GPW\NotifierRule\LessThanAverage;
use Domain\Notifier\NotifierRule;
use Domain\Notifier\NotifierRuleFactory;

class LessThanAverageFactory implements NotifierRuleFactory
{
    public function support(string $class)
    {
        return $class === LessThanAverage::class;
    }

    public function create(array $options): NotifierRule
    {
        $rule = new LessThanAverage(
            new Asset($options[LessThanAverage::ASSET_NAME])
        );
        $rule->setId($options['id']);

        return $rule;
    }
}
