<?php

namespace Domain\ETFSP500\NotifierRule;

use Domain\NotifierRule;

class Daily implements NotifierRule
{
    public function notify(): bool
    {
        return true;
    }
}
