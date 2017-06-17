<?php

namespace Domain\Notifier;

interface Storage
{
    /**
     * @return NotifierRule[]
     */
    public function getNotifierRules();
}