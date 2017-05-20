<?php

namespace Domain\ETFSP500\NotifierRule;

use Domain\Notifier\NotifierRule;

class Daily implements NotifierRule
{
    public function notify(): bool
    {
        return true;
    }
}
