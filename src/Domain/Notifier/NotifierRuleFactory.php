<?php

namespace Domain\Notifier;

interface NotifierRuleFactory
{
    public function support(string $class);

    public function create(array $options) : NotifierRule;
}
