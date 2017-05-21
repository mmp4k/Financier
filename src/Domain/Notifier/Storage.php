<?php

namespace Domain\Notifier;

interface Storage
{
    /**
     * @return NotifierRule[]|PersistableNotifierRule[]
     */
    public function getNotifierRules();
}