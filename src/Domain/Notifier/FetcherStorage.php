<?php

namespace Domain\Notifier;

interface FetcherStorage
{
    public function getNotifierRules() : array;
}
