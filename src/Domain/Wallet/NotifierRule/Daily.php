<?php

namespace Domain\Wallet\NotifierRule;

use Domain\Notifier\NotifierRule;
use Domain\Notifier\PersistableNotifierRule;

class Daily implements NotifierRule, PersistableNotifierRule
{
    public function notify(): bool
    {
        return true;
    }

    public function persistConfig(): array
    {
        return [];
    }
}
